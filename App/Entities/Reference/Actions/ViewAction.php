<?php

namespace App\Entities\Reference\Actions;

use App\Reference\Repository\ReferenceMapper;
use App\Reference\Responders\ViewResponder;

use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ViewAction
{
    private $repository = [];
    private $responder;

    public function __construct(Container $container)
    {
        $this->repository = new ReferenceMapper();
        $this->responder  = new ViewResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $References = $this->repository->all();

        // manipulate here

        return $this->responder->respond($References);
    }
}