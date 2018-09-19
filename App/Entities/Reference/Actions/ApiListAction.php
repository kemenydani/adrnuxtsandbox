<?php

namespace App\Entities\Reference\Actions;

use App\Entities\Reference\Repository\ReferenceMapper;
use App\Entities\Reference\Responders\ApiListResponder;

use App\Lib\Action;
use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiListAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new ReferenceMapper();
        $this->responder  = new ApiListResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $result = $this->repository->paginate(
            @$queryParams['search'],
            @$queryParams['page'],
            @$queryParams['rowsPerPage'],
            @$queryParams['sortBy'],
            @$queryParams['descending']
        );

        $status = count($result) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        // manipulate if needed

        return $this->responder->__invoke(
            new Payload(
                $status,
                $result
            )
        );
    }
}
