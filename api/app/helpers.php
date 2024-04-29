<?php

use App\Helpers\ResponseStatusCodes;
use App\Models\Activity;
use App\Models\Audit;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use Symfony\Component\HttpFoundation\Response;


if (!function_exists('successResponse')) {
    function successResponse($message = "Successful.", $data = [])
    {
        return response()->json([
            "status" => true,
            "statusCode" => ResponseStatusCodes::OK,
            "message" => $message,
            "data" => $data
        ], Response::HTTP_OK);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(int $statusCode = ResponseStatusCodes::BAD_REQUEST, string $message = "An error occurred.", $data = [], $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            "status" => false,
            "statusCode" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $code);
    }
}

if (!function_exists('logAction')) {
    function logAction($email, $action, $description, $ip, $agent)
    {
        Activity::create([
            'user' => $email,
            'action' => $action,
            'description' => $description,
            'ip' => $ip,
            'agent' => $agent
        ]);
    }
}


if (!function_exists('prettifyJson')) {
    function prettifyJson(array $data)
    {

        // Format JSON for better readability
        $formattedJson = json_encode($data, JSON_PRETTY_PRINT);

        // Remove curly braces
        $formattedJson = str_replace(['{', '}'], '', $formattedJson);

        return nl2br($formattedJson);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($inputDate)
    {
        if (!$inputDate) {
            return '';
        }

        try {
            $dateTime = new DateTime($inputDate);
            return $dateTime->format('M. j, Y');
        } catch (\Throwable $th) {
            return $inputDate;
        }
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($amount)
    {
        return number_format($amount, 2);
    }
}
