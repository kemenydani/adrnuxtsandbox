<?php

namespace App\Reference\Middlewares;

use \Slim\Http\Request;
use \Slim\Http\Response;

class ReferenceMiddleware
{
    public function test(Request $request, Response $response, $next)
    {
        // Before action

        $response = $next($request, $response);

        // After responder responded App

        return $response;
    }

}