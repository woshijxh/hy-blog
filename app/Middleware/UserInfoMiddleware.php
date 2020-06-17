<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
use Phper666\JwtAuth\Jwt;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserInfoMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var Jwt
     */
    protected $jwt;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userInfo = $this->jwt->getParserData();
        $request  = $request->withAttribute('user', [
            'id'       => $userInfo['id'],
            'email'    => $userInfo['email'],
            'username' => $userInfo['username'],
        ]);
        Context::set(ServerRequestInterface::class, $request);
        return $handler->handle($request);
    }
}
