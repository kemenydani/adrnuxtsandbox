<?php

namespace App\Entities\User\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class AuthResponder extends Responder
{
    public function __invoke(Payload $payload)
    {
        return $this->respond($payload);
    }

    public function respond(Payload $payload) : ResponseInterface
    {
        if($payload->getStatus() === Payload::STATUS_FOUND) return $this->response->withStatus(200)->withJson($payload->getResult());

        return $this->response->withStatus(401, 'Unauthorized');

    }


}
