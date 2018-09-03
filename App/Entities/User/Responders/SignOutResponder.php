<?php

namespace App\User\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class SignOutResponder extends Responder
{
    public function __invoke(Payload $payload)
    {
        return $this->respond($payload);
    }

    public function respond(Payload $payload) : ResponseInterface
    {
        $code = $payload->getStatus() === Payload::STATUS_DELETED ? 200 : 500;

        return $this->response->withStatus($code);
    }


}
