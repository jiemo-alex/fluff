<?php

use ConstanzeStandard\Container\Container;
use ConstanzeStandard\Fluff\RequestHandler\Args;
use ConstanzeStandard\Fluff\RequestHandler\Delay;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once __DIR__ . '/../AbstractTest.php';

class StringTest2
{
    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    public function index()
    {
        return new Response();
    }

    public function __invoke()
    {
        return $this->index();
    }
}

class DelayTest extends AbstractTest
{
    public function testHandlerIsCallable()
    {
        $response = $this->createMock(ResponseInterface::class);
        $func = function() use ($response) {
            return $response;
        };
        $container = new Container();
        $handler = new Delay(Args::getDefinition(), $func, [], $container);

        /** @var ServerRequestInterface $request */
        $request = $this->createMock(ServerRequestInterface::class);
        $result = $handler->handle($request);
        $this->assertEquals($response, $result);
    }

    public function testHandlerIsString()
    {
        $response = $this->createMock(ResponseInterface::class);
        $container = new Container();
        $func = function() use ($response) {
            return $response;
        };
        $handler = new Delay(Args::getDefinition(), 'StringTest2@index', [], $container);

        /** @var ServerRequestInterface $request */
        $request = $this->createMock(ServerRequestInterface::class);
        $result = $handler->handle($request);
        $this->assertInstanceOf(Response::class, $result);
    }

    public function testHandlerIsInvoke()
    {
        $response = $this->createMock(ResponseInterface::class);
        $container = new Container();
        $func = function() use ($response) {
            return $response;
        };
        $handler = new Delay(Args::getDefinition(), 'StringTest2', [], $container);

        /** @var ServerRequestInterface $request */
        $request = $this->createMock(ServerRequestInterface::class);
        $result = $handler->handle($request);
        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testHandlerInvalidArgumentException()
    {
        $response = $this->createMock(ResponseInterface::class);
        $container = new Container();
        $func = function() use ($response) {
            return $response;
        };
        $handler = new Delay(Args::getDefinition(), [], [], $container);

        /** @var ServerRequestInterface $request */
        $request = $this->createMock(ServerRequestInterface::class);
        $handler->handle($request);
    }

    public function testGetDefinition_static()
    {
        $container = new Container();
        $closure = Delay::getDefinition(Args::getDefinition());
        $result = $closure('StringTest2', [], $container);
        $this->assertInstanceOf(Delay::class, $result);
    }
}