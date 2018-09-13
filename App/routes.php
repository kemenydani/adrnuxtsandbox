<?php

use Slim\Http\Request;
use Slim\Http\Response;

$httpLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

foreach($httpLanguages as &$entry) $entry = substr($entry, 0, 2);

$languages = array_intersect(array_unique($httpLanguages), __LANGUAGES__);

$httpLanguage = @$languages[0] ? $languages[0] : __DEFAULT_LANGUAGE__;

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
];

/**
 *  redirect non language prefixed routes with default language
 */
$app->group('/', function() use ($routes) {

    foreach($routes as $route) $this->map(explode('|', $route['methods']), '{_:' . $route['paths'] . '}', $route['action']);

})->add(function(Request $request, Response $response, $next) {

    $path = $request->getUri()->getPath();

    return $response->withRedirect(__DEFAULT_LANGUAGE__ . $path);
});


/**
 *  language prefixed routes
 */
$app->group('/{lang:(?:en|hu)}/', function() use ($routes) {

    foreach($routes as $route) $this->map(explode('|', $route['methods']), '{_:' . $route['paths'] . '}', $route['action']);

})->add(function(Request $request, Response $response, $next) {

    return $response = $next( $request, $response );

});


$app->get('/admin', App\Entities\Admin\Actions\HomeAction::class);

$app->get('/api/auth', App\Entities\User\Actions\AuthAction::class);
$app->post('/api/signin', App\Entities\User\Actions\SignInAction::class);

$app->group('/api', function()
{
    $this->post('/signout', App\Entities\User\Actions\SignOutAction::class);

    $this->get('/articles', App\Entities\Article\Actions\ListAction::class);

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
