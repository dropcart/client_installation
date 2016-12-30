<?php

// Installation configuration file
// NOTE: This file may be automatically generated and overwritten.

class Config {

	// The (virtual) domain name which hosts this installation.
	// NOTE: If not set, under Apache 2, `UseCanonicalName` must be set
	// to `On`, and the virtual host must have a defined `ServerName`, to prevent spoofing.
	static $domain;

	// The URL relative to the domain, must begin with a slash.
	static $base_url = "/";

	// The visible name of the site.
	static $site_name = "Tonerkopen";
	
	// Visible below the logo.
	static $site_slogan = "Originele en compatible outlet cartridges";
	
	// E-mail address shown on contact page, and on order page.
	// Please refer to the contact template for editing the contact page.
	static $site_contact_email = "info@tonerkopen.nl";
	
	// [Technical] Whether or not URL rewriting is enabled.
	static $has_rewriting = false;

}

// Static functions

// Default configuration properties
if (!Config::$domain) {
	Config::$domain = $_SERVER['SERVER_NAME'];
}

function config($name) {
	return Config::$$name;
}
