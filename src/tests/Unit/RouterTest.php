<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Container;
use App\Core\Router;
use App\Exceptions\RouteNotFoundException;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\DataProviders\RouterDataProvider;

class RouterTest extends TestCase
{

    private Router $router;

    public function test_it_registers_a_route(): void
    {
        $this->router->register('GET', '/users', ['User', 'index']);

        $expected = [
            'GET' => [
                '/users' => [
                    'User',
                    'index',
                ],
            ],
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    public function test_it_registers_a_get_route(): void
    {
        $this->router->get('/users', ['User', 'index']);

        $expected = [
            'GET' => [
                '/users' => [
                    'User',
                    'index',
                ],
            ],
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    public function test_it_registers_a_post_route(): void
    {
        $this->router->post('/users', ['User', 'store']);

        $expected = [
            'POST' => [
                '/users' => [
                    'User',
                    'store',
                ],
            ],
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    public function test_there_are_no_routes_when_router_is_created(): void
    {
        $this->assertEmpty((new Router(new Container()))->routes());
    }

    #[DataProviderExternal(RouterDataProvider::class, 'routeNotFoundCases')]
    public function test_it_throws_route_not_found_exception(
        string $expectedUrl,
        string $expectedMethod
    ): void {
        $users = new class() {

            public function delete(): true
            {
                return true;
            }

        };
        $this->router->post('/users', [$users::class, 'store']);
        $this->router->get('/users', ['users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($expectedUrl, $expectedMethod);
    }

    public function test_it_resolves_route_from_a_closure(): void
    {
        $this->router->get('/users', fn() => [1, 2, 3]);

        $this->assertSame(
            [1, 2, 3],
            $this->router->resolve('/users', 'GET')
        );
    }

    public function test_it_resolve_route(): void
    {
        $users = new class () {

            public function index(): array
            {
                return [1, 2, 3];
            }

        };
        $this->router->get('/users', [$users::class, 'index']);
        $this->assertSame(
            [1, 2, 3],
            $this->router->resolve('/users', 'GET')
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router(new Container());
    }

}