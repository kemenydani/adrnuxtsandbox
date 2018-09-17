<?php

namespace App\Entities\Article\Actions;

use App\Entities\Article\Repository\ArticleMapper;
use App\Entities\Article\Responders\ListResponder;

use App\Lib\Action;
use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ListAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new ArticleMapper();
        $this->responder  = new ListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $ArticleRecordSet = $this->repository->all();

        $result = $ArticleRecordSet->getData();

        $status = count($result) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        return $this->responder->__invoke(
            new Payload(
                $status,
                $result
            )
        );
    }
}
