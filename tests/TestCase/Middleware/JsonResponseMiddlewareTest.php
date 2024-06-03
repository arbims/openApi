<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\JsonResponseMiddleware;
use Cake\TestSuite\TestCase;

/**
 * App\Middleware\JsonResponseMiddleware Test Case
 */
class JsonResponseMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Middleware\JsonResponseMiddleware
     */
    protected $JsonResponse;

    /**
     * Test process method
     *
     * @return void
     * @uses \App\Middleware\JsonResponseMiddleware::process()
     */
    public function testProcess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
