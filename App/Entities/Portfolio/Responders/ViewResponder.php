<?php

namespace App\Entities\Portfolio\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class ViewResponder extends Responder
{
    public function respond(Payload $payload) : ResponseInterface
    {
        return $this->response->write('Portfolio static response body');
    }
}