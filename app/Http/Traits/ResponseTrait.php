<?php

namespace App\Http\Traits;

trait ResponseTrait
{
    protected function success($message, $data = [], $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function error($message, $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }

    protected function withAlert($type, $message, $route = null)
    {
        $redirect = $route ? redirect()->route($route) : redirect()->back();
        return $redirect->with('alert', [
            'type' => $type,
            'message' => $message
        ]);
    }
}