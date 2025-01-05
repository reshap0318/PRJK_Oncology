<?php
namespace App\Http\Responses;
use Illuminate\Http\JsonResponse;

class Error
{
    private const ERROR_CODE = 500;
    private const UNATHORIZED_CODE = 401;
    private const PAGE_NOT_FOUND_CODE = 404;

    public static function defaultErrorExtraMessage($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code'    => self::ERROR_CODE
        ], self::ERROR_CODE);
    }

    public static function defaultErrorExtraCodeAndMessage($code, $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code'    => $code
        ], $code);
    }

    public static function defaultError(): JsonResponse
    {
        return response()->json([
            'message' => 'Internal Server Error',
            'code'    => self::ERROR_CODE
        ], self::ERROR_CODE);
    }

    public static function defaultPageNotFoundError(): JsonResponse
    {
        return response()->json([
            'message' => 'Page Not Found',
            'code'    => self::PAGE_NOT_FOUND_CODE
        ], self::PAGE_NOT_FOUND_CODE);
    }

    public static function defaultUnauthorizedError(): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthorized',
            'code'    => self::UNATHORIZED_CODE
        ], self::UNATHORIZED_CODE);
    }

    public static function defaultUnauthorizedErrorExtraMessage($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code'    => self::UNATHORIZED_CODE
        ], self::UNATHORIZED_CODE);
    }

    public static function errorWithStatusAndMessage(int $status, $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code'    => $status
        ], $status);
    }

    public static function errorWithStatusMessageAndError(int $status, $message, $error): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code'    => $status,
            'error'   => $error
        ], $status);
    }
}
