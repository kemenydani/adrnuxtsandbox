<?php

namespace App\Entities\Home\Responders;

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
        return $this->view->render($this->response, 'home.html.twig', [
            'articles' => $payload->getResult()
        ]);
    }
}
