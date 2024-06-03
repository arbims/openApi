<?php

namespace App\Error;

use Cake\Http\Response;
use Authentication\Authenticator\UnauthenticatedException;

class AppExceptionRenderer extends AppExceptionRenderer
{
    public function unauthenticated(UnauthenticatedException $exception): Response
    {
        // Customize the response for UnauthenticatedException
        $response = new Response();
        $body = json_encode([
            'error' => 'Authentication required',
            'message' => 'You must be logged in to access this resource.'
        ]);

        return $response->withStringBody($body)
                        ->withStatus(401)
                        ->withType('application/json');
    }
}
