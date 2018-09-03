<?php

namespace App\Article\Responders;

use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class ViewResponder extends Responder
{
    public function respond($collection = null) : ResponseInterface
    {
        return $this->response->write('article static response body');
    }
}