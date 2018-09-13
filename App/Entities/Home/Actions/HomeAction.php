<?php

namespace App\Entities\Home\Actions;

use App\Entities\Article\Repository\ArticleMapper;
use App\Entities\Home\Responders\HomeResponder;

use App\Lib\Payload;
use Psr\Http\Message\ResponseInterface;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeAction
{
    private $repository = null;
    private $responder;
    private $articleRepository;

    public function __construct(Container $container)
    {
        $this->responder  = new HomeResponder($container);
        $this->articleRepository = new ArticleMapper();
    }

    public function __invoke(Request $request, Response $response, array $args = []) : ResponseInterface
    {
        $Articles = $this->articleRepository->all();

        return $this->responder->respond(new Payload(Payload::STATUS_FOUND, $Articles->getData()));
    }
}
