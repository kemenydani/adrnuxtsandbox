<?php

namespace App\Entities\Portfolio\Actions;

use App\Entities\Portfolio\Repository\ReferenceMapper;
use App\Entities\Portfolio\Repository\ReferenceRecordSet;
use App\Entities\Portfolio\Responders\ListResponder;

use App\Lib\Action;
use App\Lib\paginatedRepositorySearch;
use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ListAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new ReferenceMapper();
        $this->responder  = new ListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        /*
        $ps = new paginatedRepositorySearch($this->repository);

        $ps->setKeyword($request->getQueryParam('keyword'));
        $ps->setLimit($request->getQueryParam('limit'));
        $ps->setStart($request->getQueryParam('start'));
        $ps->setPage($request->getQueryParam('page'));
        $ps->setDescending($request->getQueryParam('descending'));
        $ps->setOrder($request->getQueryParam('order'));

        $ps->execute();

        $ReferenceRecordSet = $this->repository->newRecordSet($ps->getResult());

        $result = $ReferenceRecordSet->getData();
        */
        $result = [1];
        $status = count($result) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        return $this->responder->__invoke(
            new Payload(
                $status,
                $result
            )
        );
    }
}
