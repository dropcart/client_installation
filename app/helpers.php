<?php

global $app;

if(! function_exists ( 'lang' ) )
{
	$currentLanguageFile = resource_path('themes/' . env('THEME', 'default') . '/lang/' . strtolower($app['translator']->getLocale()) . '.php');
	if(file_exists($currentLanguageFile))
		$currentLanguageFile = include ( $currentLanguageFile );
	else
		$currentLanguageFile = [];

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
		
		if(!is_null($locale) && is_bool($locale))
			$app['translator']->setLocale($locale);

		return strtolower($app['translator']->getLocale());
	}
}
