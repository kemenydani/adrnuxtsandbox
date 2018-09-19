<?php

use Slim\Http\Request;
use Slim\Http\Response;

$routes = [
    'home' => [
        'paths' => 'home|index|',
        'methods' => 'GET',
        'action' => App\Entities\Home\Actions\HomeAction::class
    ],
    'article.list' => [
        'paths' => 'articles',
        'methods' => 'GET',
        'action' => App\Entities\Article\Actions\ListAction::class
    ],
    'article.view' => [
        'paths' => 'article/{title}',
        'methods' => 'GET',
        'action' => App\Entities\Article\Actions\ViewAction::class
    ],
    'portfolio.list' => [
        'paths' => 'portfolio',
        'methods' => 'GET',
        'action' => App\Entities\Portfolio\Actions\ListAction::class
    ],
];

/**
 *  redirect non language prefixed routes with default language
 */
$app->group('/', function() use ($routes) {

    foreach($routes as $route) $this->map(explode('|', $route['methods']), '{_:' . $route['paths'] . '}', $route['action']);

})->add(function(Request $request, Response $response, $next) {

    $path = $request->getUri()->getPath();

    return $response->withRedirect(\App\Lib\Language::$default . $path);
});


/**
 *  language prefixed routes
 */
$app->group('/{lang:(?:en|hu|en/|hu/)}', function() use ($routes) {

    foreach($routes as $route) $this->map(explode('|', $route['methods']), '{_:' . $route['paths'] . '}', $route['action']);

})->add(function(Request $request, Response $response, $next) {

    $lang = $request->getAttribute('route')->getArgument('lang');

    $request->withAttribute('lang', $lang);

    return $response = $next( $request, $response );

});


$app->get('/admin', App\Entities\Admin\Actions\HomeAction::class);

$app->get('/api/auth', App\Entities\User\Actions\AuthAction::class);
$app->post('/api/signin', App\Entities\User\Actions\SignInAction::class);

$app->group('/api', function()
{
    $this->post('/signout', App\Entities\User\Actions\SignOutAction::class);

    $this->get('/articles', App\Entities\Article\Actions\ApiListAction::class);

    $this->get('/user/notifications', App\Entities\User\Actions\NotificationAction::class);
    $this->get('/user/conversations', App\Entities\User\Actions\ConversationAction::class);

})->add(function($request, $response, $next)
{
    $response = $next( $request, $response );

    return $response
        ->withHeader( 'Access-Control-Allow-Origin', '*')
        ->withHeader( 'Access-Control-Allow-Credentials', 'true')
        ->withHeader( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )
        ->withHeader( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
});
