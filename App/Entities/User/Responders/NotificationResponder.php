<?php

namespace App\User\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class NotificationResponder extends Responder
{
    public function __invoke(Payload $payload)
    {
        return $this->respond($payload);
    }

    public function respond(Payload $payload) : ResponseInterface
    {
        return $this->response->withStatus(200)->withJson($payload->getResult());
    }

}
