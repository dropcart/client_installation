<?php
/**
 * =========================================================
 *                  HEER EN FREZER B.V.
 *                      ------------
 *  Heer en Frezer is a company for producing fast, high-
 *  quality products for a good price. We build your ideas
 *  into something you can touch.
 *                      ------------
 *                     Oudeweg 91 - 95
 *                     _____unit F-0.3
 *                     2031 CC  HAARLEM
 *
 *                  [t] +31 85 75 00 415
 *                  [e] info@heerenfrezer.nl
 *                  [w] https://heerenfrezer.nl
 * =========================================================
 *
 * File: DefaultViewServiceProvider.php
 * Date: 24-01-17
 * Time: 09:34
 * Copyright: © 2017 - Heer en Frezer B.V.
 */


namespace App\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class DefaultViewServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services
	 */
	public function boot(Application $app)
	{
		$app['view']->share('DropCart', $app['dropcart']);
		$app['view']->share('languages', function()
		{
			return list_languages();
		});
	}

	/**
	 * Registering the ServiceProvider
	 */
	public function register()
	{

	}
}