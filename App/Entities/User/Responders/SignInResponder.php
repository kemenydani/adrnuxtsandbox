<?php

namespace App\Entities\User\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class SignInResponder extends Responder
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
