<?php

namespace App\Lib;

use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

interface ResponderInterface
{
    public function respond(Payload $payload) : ResponseInterface;
}