<?php

namespace App\Entities\Admin\Actions;

use App\Entities\Admin\Responders\HomeResponder;

use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeAction
{
    private $repository = null;
    private $responder;

    public function __construct(Container $container)
    {
        $this->responder  = new HomeResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        return $this->responder->respond(new Payload(Payload::STATUS_FOUND, []));
    }
}