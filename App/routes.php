<?php

//https://fiberonofiber.wordpress.com/2014/02/13/slim-php-multi-language-urls/

//s$app->redirect('/{lang:^((?!en|hu).)*$}', __LANGUAGE__);
$httpLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

foreach($httpLanguages as &$entry) $entry = substr($entry, 0, 2);

$languages = array_intersect(array_unique($httpLanguages), __LANGUAGES__);

$httpLanguage = @$languages[0] ? $languages[0] : __DEFAULT_LANGUAGE__;


$app->redirect('/', '/' . $httpLanguage);

$app->group('/{lang:(?:en/|hu/|en|hu|)}', function() use ($httpLanguage)
{
    $this->get('', App\Entities\Home\Actions\HomeAction::class);
    $this->get('home', App\Entities\Home\Actions\HomeAction::class);
})->add(function($request, $response, $next) use (&$httpLanguage){
/*
    $path = $request->getUri()->getPath();

    $exp = explode('/', $path);

    $language = in_array($exp[1], __LANGUAGES__) $exp[1]

    if(!in_array($exp[1], __LANGUAGES__))
    {

        return $response->withRedirect(__LANGUAGE__  . $path);
    }

    */

    $response = $next( $request, $response );

    return $response;
});





//$app->get('/', App\Entities\Home\Actions\HomeAction::class);
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
