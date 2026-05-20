<?php

namespace App\Controllers;

class ErrorController
{
    public static function notFound($message = 'Page Not Found')
    {
        http_response_code(404);
        loadView('error', [
            'status' => '404 Error',
            'message' => $message
        ]);
    }

    public static function notAuthorized($message = 'You are not authorized to access this page')
    {
        http_response_code(403);
        loadView('error', [
            'status' => '403 Error',
            'message' => $message
        ]);
    }
}
