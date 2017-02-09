<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
    echo "<h1>Instellingen niet geladen...</h1>
<p>Kopie&euml;r het bestand .env.example naar .env en pas de instellingen aan.</p>";
    echo "<h1>Settings not loaded...</h1>
<p>Copy the .env.example file to .env and change those settings.</p>";
    die();

}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

// DropCart Logger
$app->configureMonologUsing(function ($monolog)
{
    $monolog->pushHandler(
        new \Monolog\Handler\StreamHandler(storage_path('logs/lumen.log'), \Psr\Log\LogLevel::ERROR, true)
    );
    $monolog->pushHandler(
        new \Monolog\Handler\StreamHandler(storage_path('logs/dropcart.log'), \Psr\Log\LogLevel::CRITICAL, false)
    );

    return $monolog;
});

$app->withFacades();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Http\Middleware\ShoppingBagMiddleware::class
]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(Dropcart\Laravel\ServiceProvider::class);
$app->register(App\Providers\DefaultViewServiceProvider::class);

class_alias('Illuminate\Support\Facades\View', 'View');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

require __DIR__ . '/../app/helpers.php';
register_themes(env('THEME'));

// LOCALISATION IS NEEDED BEFORE ROUTES
$request = app('request');
if(count($request->segments()) > 0)
{
    if(!env('MULTILINGUAL', FALSE))
    {
        $default = strtolower(env('APP_LOCALE', 'nl'));
        loc($default);

    } else {
        $langs = list_languages();
        if((strtolower($request->segment(1)) !== strtolower(loc())) &&
            in_array($request->segment(1), $langs))
        {
            loc($request->segment(1));
        } else
        {
            $default = strtolower(env('APP_LOCALE', 'NL'));
            loc($default);
        }

    }
}
register_current_language_file();
// END OF REGISTERING

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../routes/web.php';
});

return $app;
