<?php

namespace App\Entities\Article\Actions;

use App\Entities\Article\Repository\ArticleMapper;
use App\Entities\Article\Repository\ArticleRecordSet;
use App\Entities\Article\Responders\ListResponder;

use App\Lib\Action;
use App\Lib\paginatedSearch;
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
        $ps = new paginatedSearch($this->repository);

        $ps->setKeyword($request->getQueryParam('keyword'));
        $ps->setLimit($request->getQueryParam('limit'));
        $ps->setStart($request->getQueryParam('start'));
        $ps->setPage($request->getQueryParam('page'));
        $ps->setDescending($request->getQueryParam('descending'));
        $ps->setOrder($request->getQueryParam('order'));

        $ps->execute();

        $ArticleRecordSet = $this->repository->newRecordSet($ps->getResult());

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
