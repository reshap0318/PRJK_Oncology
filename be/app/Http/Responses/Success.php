<?php
namespace App\Http\Responses;
use Illuminate\Http\JsonResponse;

class Success
{
    private const SUCCESS_CODE = 200;
    private const CREATED_CODE = 201;

    public static function defaultSuccess(): JsonResponse
    {
        return response()->json([
            'message' => 'Success',
            'code'    => self::SUCCESS_CODE
        ], self::SUCCESS_CODE);
    }

    public static function defaultSuccessExtraMessage($message): JsonResponse
    {
        return response()->json([
            'code'    => self::SUCCESS_CODE,
            'message' => $message,
        ], self::SUCCESS_CODE);
    }

    public static function defaultSuccessExtraMessageAndData($message, $data): JsonResponse
    {
        return response()->json([
            'code'    => self::SUCCESS_CODE,
            'message' => $message,
            'data'    => $data
        ], self::SUCCESS_CODE);
    }

    public static function defaultSuccessWithData($data): JsonResponse
    {
        return response()->json([
            'code'    => self::SUCCESS_CODE,
            'message' => 'Success',
            'data'    => $data
        ], self::SUCCESS_CODE);
    }

    public static function createdSuccess(): JsonResponse
    {
        return response()->json([
            'code'    => self::CREATED_CODE,
            'message' => 'Created',
        ], self::CREATED_CODE);
    }
}
