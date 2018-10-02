<?php

namespace App\Traits;

trait ResponseInfo
{
    /**
     * Ответ уведомления
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function info($message)
    {
        return response()->json(['content' => $message]);
    }

    /**
     * Ответ ошибки
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    function error($message)
    {
        return response()->json(['content' => $message], 500);
    }
}