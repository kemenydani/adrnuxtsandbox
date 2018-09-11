<?php

//https://fiberonofiber.wordpress.com/2014/02/13/slim-php-multi-language-urls/
/*
$app->redirect('/', '/en');

$app->group('/{lang:(?:en|hu|de)}', function()
{
    $this->get('', App\Entities\Home\Actions\HomeAction::class);
    $this->get('/home', App\Entities\Home\Actions\HomeAction::class);
});


*/

$app->get('/', App\Entities\Home\Actions\HomeAction::class);
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
