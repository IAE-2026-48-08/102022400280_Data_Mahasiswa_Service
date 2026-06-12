<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SoapAuditService
{
    public function sendAudit($token, $data)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:iae="http://iae.central/audit">
    <soap:Body>
        <iae:AuditRequest>

            <iae:TeamID>' . env('IAE_TEAM_ID') . '</iae:TeamID>

            <iae:ActivityName>ValidateStudentQuota</iae:ActivityName>

            <iae:LogContent><![CDATA[' .
                json_encode($data)
            . ']]></iae:LogContent>

        </iae:AuditRequest>
    </soap:Body>
</soap:Envelope>';

        $response = Http::withToken($token)
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ])
            ->send(
                'POST',
                env('IAE_BASE_URL') . '/soap/v1/audit',
                [
                    'body' => $xml
                ]
            );

        return $response->body();
    }
}