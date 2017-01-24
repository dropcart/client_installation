<?php

global $app;

if(! function_exists ( 'lang' ) )
{

	$currentLanguageFile = [];

	function register_current_language_file()
	{
		global $currentLanguageFile, $app;
		$currentLanguageFile = resource_path('themes/' . env('THEME', 'default') . '/lang/' . strtolower($app['translator']->getLocale()) . '.php');
		if(file_exists($currentLanguageFile))
			$currentLanguageFile = include ( $currentLanguageFile );

	}

	function lang($key, array $replace = [], $lang = null)
	{
		global $app, $currentLanguageFile;

		$languageArray = $currentLanguageFile;
		if(strtolower($lang) != strtolower($app['translator']->getLocale()))
		{
			// Load other language
			$tempLanguageFile = resource_path('themes/' . env('THEME', 'default') . '/lang/' . strtolower($lang) . '.php');
			if(file_exists($tempLanguageFile))
				$languageArray = include ($tempLanguageFile);
		}

		$result = array_get($languageArray, $key, null);
		if(is_null($result))
			$result = $key;

		if(count($replace) > 0)
		{
			// Need to replace stuff
			foreach($replace as $item => $value)
				$result = str_replace(':' . $item, $value, $result);
		}

		return $result;
	}
}

if(! function_exists ( 'register_themes' ) )
{
	function register_themes($current = 'default')
	{
		global $app;

		$glob = glob(resource_path('themes') . '/*');
		foreach($glob as $item)
		{
			if(is_dir($item))
			{
				$dirname = explode('/', $item);
				$name = array_pop($dirname);;
				View::addNamespace(ucfirst(camel_case($name)), $item . '/views');

				// Register default Current
				if(strtolower($name) == strtolower($current))
					View::addNamespace('Current', $item . '/views');
			}
		}
	}

}

if(! function_exists( 'loc' ) )
{
	function loc($locale = null)
	{
		global $app;
		
		if(!is_null($locale) && !is_bool($locale))
			app('translator')->setLocale($locale);

		return strtolower(app('translator')->getLocale());
	}
}

if(! function_exists( 'get_current_theme' ) )
{
	function get_current_theme($getPath = FALSE)
	{
		global $app;

		$hints = View::getFinder()->getHints();
		if (array_key_exists('Current', $hints))
			$themeViewPath = $hints['Current'][0];
		else
			$themeViewPath = View::getFinder()->getPaths()[0];

		if($getPath)
			return realpath(rtrim($themeViewPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '..');

		$themeViewPathExploded 	= explode(DIRECTORY_SEPARATOR, $themeViewPath);
		$themeName 				= $themeViewPathExploded[count($themeViewPathExploded) - 2];

		if($themeName != 'resources')
			return ucfirst($themeName);

		return '';
	}
}

if(! function_exists('lang_route') )
{
	function lang_route($route, $lang, $params = [])
	{
		$params['locale'] = $lang;

		$uri = lang("url_$route", [], $lang);
		$uri = preg_replace_callback('/\{(.*?)(:.*?)?(\{[0-9,]+\})?\}/', function ($m) use (&$params) {
			return isset($params[$m[1]]) ? array_pull($params, $m[1]) : $m[0];
		}, $uri);

		$uri = (new Laravel\Lumen\Routing\UrlGenerator(app()))->to($lang .  "/" . $uri);

		return $uri;
	}
}


if(! function_exists('list_languages') )
{
	function list_languages()
	{
		global $app;

		if(env('MULITLINGUAL', FALSE))
			return [loc()];

		$lang_path = get_current_theme(TRUE) . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;
		$langs = [];
		foreach(glob($lang_path . '*.php') as $file)
		{
			$exploded 	= explode('/', $file);
			$file 		= end($exploded);

			$match = preg_match("/^([a-z]{2}(?:_[a-z]{2})?).php$/", $file, $matches);
			if($match !== FALSE && $match > 0)
				$langs[] = $matches[1];
		}

		return $langs;

	}
}