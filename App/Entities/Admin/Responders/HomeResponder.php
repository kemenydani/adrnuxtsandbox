<?php

namespace App\Entities\Admin\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class HomeResponder extends Responder
{
    public function __invoke(Payload $payload)
    {
        return $this->respond($payload);
    }

    public function respond(Payload $payload) : ResponseInterface
    {
        return $this->response->write(file_get_contents('static/spa/admin/dist/index.spa.html'));
    }
}