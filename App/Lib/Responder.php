<?php

namespace App\Lib;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Responder implements ResponderInterface
{
    /**
     * @var Request
     */
    public $request;
    /**
     * @var Response
     */
    public $response;
    /**
     * @var Container
     */
    public $container;
    /**
     * @var \Slim\Views\Twig;
     */
    public $view;

    /**
     * Responder constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view      = $container->view;
        $this->request   = $container->request;
        $this->response  = $container->response;
    }

}