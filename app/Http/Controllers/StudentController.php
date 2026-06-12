<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Services\SSOService;
use App\Services\SoapAuditService;
use App\Services\RabbitMQService;

#[OA\Tag(
    name: "Students",
    description: "Student Service API"
)]
class StudentController extends Controller
{
    #[OA\Get(
        path: "/api/v1/students",
        summary: "Get all students",
        tags: ["Students"],
        security: [["ApiKeyAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            )
        ]
    )]
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Student::all()
        ]);
    }

    #[OA\Get(
        path: "/api/v1/students/{id}",
        summary: "Get student detail by ID",
        tags: ["Students"],
        security: [["ApiKeyAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Success"),
            new OA\Response(response: 404, description: "Student not found")
        ]
    )]
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    #[OA\Post(
        path: "/api/v1/students/validate-quota",
        summary: "Validate student quota",
        tags: ["Students"],
        security: [["ApiKeyAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["student_id", "requested_sks"],
                properties: [
                    new OA\Property(
                        property: "student_id",
                        type: "integer",
                        example: 1
                    ),
                    new OA\Property(
                        property: "requested_sks",
                        type: "integer",
                        example: 4
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Validation success"
            ),
            new OA\Response(
                response: 404,
                description: "Student not found"
            )
        ]
    )]
    public function validateQuota(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'requested_sks' => 'required|integer|min:1'
        ]);

        $student = Student::find($request->student_id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $remaining = $student->quota_sks - $student->used_sks;

        $eligible = $request->requested_sks <= $remaining;

        $auditData = [
            "student_id" => $student->id,
            "nim" => $student->nim,
            "requested_sks" => $request->requested_sks,
            "remaining_quota" => $remaining,
            "eligible" => $eligible
        ];

        $soapStatus = "SUCCESS";
        $rabbitStatus = "SUCCESS";

        try {

            $token = (new SSOService())->getToken();

            (new SoapAuditService())->sendAudit(
                $token,
                $auditData
            );

            $rabbit = (new RabbitMQService())->publish(
                $token,
                [
                    "message" => $auditData
                ]
            );

            if (isset($rabbit['status'])) {
                $rabbitStatus = $rabbit['status'];
            }

        } catch (\Exception $e) {

            $soapStatus = "FAILED";
            $rabbitStatus = "FAILED";

        }

        return response()->json([
            "success" => true,

            "data" => [
                "student_id" => $student->id,
                "remaining_quota" => $remaining,
                "requested_sks" => $request->requested_sks,
                "eligible" => $eligible
            ],

            "integration" => [
                "soap" => $soapStatus,
                "rabbitmq" => $rabbitStatus
            ]
        ]);
        try {

    // seluruh kode SSO SOAP Rabbit

} catch (\Throwable $e) {

    return response()->json([
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile()
    ], 500);

}
    }
}

