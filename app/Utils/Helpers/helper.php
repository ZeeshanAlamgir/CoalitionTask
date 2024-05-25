<?php

if (!function_exists('apiSuccessResponse')) {
    function apiSuccessResponse ( $data=null, $status = 'success' ) {
        return response()->json(
            [
                'status' => true,
                'data'=>$data
            ]
        );
    }
}

if (!function_exists('apiErrorResponse')) {
    function apiErrorResponse ( $message="data not found", $status = 'error' ) {
        return response()->json(
            [
                'status' => false,
                'message'=>$message
            ]
        );
    }
}