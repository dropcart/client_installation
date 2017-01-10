<?php

function config($name, $or = null) {
	if(isset(Config::$$name))
		return Config::$$name;

	return (is_null($or) ? null : $or);
}
function getLanguage()
{
	return config('default_language');
}
function content($name, $else = '')
{
	$language = getLanguage();
	if(file_exists("lang_$language.php"))
		$content = include("lang_$language.php");
	else
		$content = include("lang_nl.php");

	return (isset($content[$name]) ? parseContent($content[$name]) : $else);
}
function parseContent($content)
{
	preg_match_all('/%([^\s])%/mi', $content, $matches);
	foreach($matches[0] as $match)
	{
		$conf = strtolower(trim($match, '%'));
		str_replace($match, config($conf, ''), $content);

	}
	return $content;

}
function view($name) {
	$name = preg_replace('/[^A-Za-z0-9_\-]/', '', $name);
	include("includes/header.php");
	include("includes/views/$name.php");
	include("includes/footer.php");
}
function redirect($name, $params = []) {
	header("HTTP/1.1 302 Found");
	header("Location: " . route($name, $params));
	exit();
}
function force_ssl() {
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		// All is fine.
	} else {
		// Redirect current location to HTTPS
		$domain = parse_url(config('domain'));

		header("HTTP/1.1 307 Temporary Redirect");
		header("Location: https://" . $domain['host'] . $_SERVER['REQUEST_URI']);
		exit();
	}
}
function route($name, $params = [], $absolute = true) {
	if ($absolute) {
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
			$proto = "https";
		} else {
			$proto = "http";
		}
		$domain = parse_url(config('domain'));
		$url = $proto . "://" . $domain['host'];
	} else {
		$url = "";
	}
	$url .= config('base_url');
	if ((bool) config('has_rewriting')) {
		$url .= urlencode($name);
		foreach ($params as $key => $param) {
			if (is_int($key)) {
				$url .= "/";
				$url .= urlencode($param);
			}
		}
		$has_query = false;
		foreach ($params as $key => $param) {
			if (!is_int($key)) {
				if (!$has_query) {
					$url .= "?";
				} else {
					$url .= "&";
				}
				$url .= urlencode($key) . "=";
				$has_query = true;
				$url .= urlencode($param);
			}
		}
	} else {
		$url .= "?act=" . urlencode($name);
		if (!is_array($params)) {
			$params = [$params];
		}
		foreach ($params as $key => $param) {
			if (is_int($key)) {
				$url .= "&p" . ($key + 1) . "=" . urlencode($param);
			}
		}
		foreach ($params as $key => $param) {
			if (!is_int($key)) {
				$url .= "&". urlencode($key) . "=" . urlencode($param);
			}
		}
	}
	return $url;
}
function relroute($params = []) {
	// Construct original params from $_GET superglobal (assume max. 8 params)
	$name = $_GET['act'];
	$original_params = [];
	for ($index = 1; $index < 9; $index++) {
		if (isset($_GET["p$index"])) {
			$original_params[] = $_GET["p$index"];
		} else {
			break;
		}
	}
	foreach ($original_params as $key => $value) {
		if (!isset($params[$key])) {
			$params[$key] = $value;
		}
	}
	return route($name, $params);
}
function roman_number($integer) {
	$table = array('x'=>10, 'ix'=>9, 'v'=>5, 'iv'=>4, 'i'=>1);
	$return = '';
	while($integer > 0) {
		foreach($table as $rom=>$arb) {
			if($integer >= $arb) {
				$integer -= $arb;
				$return .= $rom;
				break;
			}
		}
	}
	return $return;
}
function acopy($from, &$to, $fields) {
	foreach ($fields as $from_key => $to_key) {
		if (is_int($from_key)) $from_key = $to_key;
		if (isset($from[$from_key]))
			$to[$to_key] = $from[$from_key];
	}
}
function compute_pages($curr, $total) {
	$result = [];
	for ($page = 1; $page <= $total; $page++) {
		$result[] = $page;
	}
	return $result;
}
function logger($level, $error) {
	$fd = @fopen(dirname(__FILE__) . "/error.log", "a");
	if (!$fd) return;

	if(is_object($error))
	{
		$str = "[" . date("Y/m/d h:i:s", time()) . "] " . $level . ": ";
		do {
			$str =  "\n\t" . print_r($error->getMessage(), true);
		} while($error = $error->getPrevious());
	}
	else {
		$str = "[" . date("Y/m/d h:i:s", time()) . "] " . $level . ": " . $error;
	}
	@fwrite($fd, $str . "\n");
	@fclose($fd);
}
