<?php

namespace App\Entities\Reference\Responders;

use App\Lib\Payload;
use App\Lib\Responder;

use Psr\Http\Message\ResponseInterface;

class ListResponder extends Responder
{
    public function __invoke(Payload $payload)
    {
        return $this->respond($payload);
    }

    public function respond(Payload $payload) : ResponseInterface
    {
        return $this->view->render($this->response, 'References.html.twig', [
            'References' => $payload->getResult()
        ]);
    }

}
