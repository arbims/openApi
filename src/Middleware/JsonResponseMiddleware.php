<?php
declare(strict_types=1);

namespace App\Middleware;

use Authentication\Authenticator\UnauthenticatedException;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * JsonResponse middleware
 */
class JsonResponseMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (UnauthenticatedException $e) {
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
}
