<?php

namespace App\Entities\User\Actions;

use App\Entities\User\Repository\UserMapper;
use App\Entities\User\Responders\AuthResponder;

use App\Lib\Action;
use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


class ConversationAction extends Action
{
    public function __construct(Container $container)
    {
        $this->repository = new UserMapper();
        $this->responder  = new AuthResponder($container);
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        // TODO: notifications
        $UserRecord = $this->repository->find(1);

        $conversations = $this->repository->getConversations($UserRecord, 5);

        $status = is_array($conversations) ? Payload::STATUS_FOUND : Payload::STATUS_NOT_FOUND;

        return $this->responder->__invoke(
            new Payload(
                $status,
                $conversations
            )
        );
    }
}
