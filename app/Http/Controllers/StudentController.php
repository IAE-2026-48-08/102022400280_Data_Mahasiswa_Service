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
        summary: "Get all active students",
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
                description: "Student ID",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Success"
            ),
            new OA\Response(
                response: 404,
                description: "Student not found"
            )
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
        path: "/api/v1/students",
        summary: "Create student",
        tags: ["Students"],
        security: [["ApiKeyAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nim", "nama", "status", "quota_sks", "used_sks"],
                properties: [
                    new OA\Property(
                        property: "nim",
                        type: "string",
                        example: "102022400280"
                    ),
                    new OA\Property(
                        property: "nama",
                        type: "string",
                        example: "Hans"
                    ),
                    new OA\Property(
                        property: "status",
                        type: "string",
                        example: "AKTIF"
                    ),
                    new OA\Property(
                        property: "quota_sks",
                        type: "integer",
                        example: 24
                    ),
                    new OA\Property(
                        property: "used_sks",
                        type: "integer",
                        example: 10
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Student created"
            )
        ]
    )]
    public function store(Request $request)
    {
        $student = Student::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'status' => $request->status,
            'quota_sks' => $request->quota_sks,
            'used_sks' => $request->used_sks
        ]);

        return response()->json([
            'success' => true,
            'data' => $student
        ], 201);
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
        $student = Student::find($request->student_id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $remaining = $student->quota_sks - $student->used_sks;

        $eligible = $request->requested_sks <= $remaining;

        $token = (new SSOService())->getToken();

        $auditData = [
            "student_id" => $student->id,
            "nim" => $student->nim,
            "requested_sks" => $request->requested_sks,
            "remaining_quota" => $remaining,
            "eligible" => $eligible
        ];

        $soapResponse = (new SoapAuditService())->sendAudit(
            $token,
            $auditData
        );

        $rabbitResponse = (new RabbitMQService())->publish(
            $token,
            [
                "message" => $auditData
            ]
        );

        return response()->json([
            "success" => true,
            "data" => [
                "student_id" => $student->id,
                "remaining_quota" => $remaining,
                "requested_sks" => $request->requested_sks,
                "eligible" => $eligible
            ],
            "soap_response" => $soapResponse,
            "rabbitmq_response" => $rabbitResponse
        ]);
    }
}