<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseApi extends Controller
{
    public function response($message, $data, $errors, $code, $reason, $isSuccess, $codeReturn)
    {


        return response()->json([
            "content" => [
                "message" => $message,
                "data" => $data,
                "errors" => $errors
            ],
            "status" => [
                "code" => $code,
                "reason" => $reason,
                "success" => $isSuccess
            ]

        ], $codeReturn);

    }

    public function getParametersErros($validationParams)
    {


        $customErrors = [];

        if ($validationParams->fails()) {
            $errors = $validationParams->errors()->toArray();
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $customErrors[] = ['field' => $field, 'message' => $message];
                }
            }


        }

        return $customErrors;
    }
}
