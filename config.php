<?php

// Installation configuration file example
// Actual file name: config.php
// NOTE: The file config.php may be automatically generated and overwritten.

class Config {

	// The (virtual) domain name which hosts this installation.
	// NOTE: If not set, under Apache 2, `UseCanonicalName` must be set
	// to `On`, and the virtual host must have a defined `ServerName`, to prevent spoofing.
	static $domain;

	// The URL relative to the domain, must begin with a slash and must end with a slash.
	static $base_url = "/";

	// The visible name of the site.
	static $site_name = "Tonerkopen";
	
	// Visible below the logo.
	static $site_slogan = "Originele en compatible outlet cartridges";
	
	// E-mail address shown on contact page, and on order page.
	// Please refer to the contact template for editing the contact page.
	static $site_contact_email = "info@tonerkopen.nl";
	
	// [Technical] Endpoint for Dropcart API
	//static $dropcart_api_endpoint = "https://api.staging.dropcart.nl";
	static $dropcart_api_endpoint = "http://api.dropcart.dev";
	
	// [Technical] Public key for Dropcart API
	static $dropcart_api_key = "e5312706be8ae2aba08dcd1b3fb9274a438afdee4cdfe074ff3287c93038ee72";
	
	// [Technical] Whether or not URL rewriting is enabled.
	static $has_rewriting = false;
	
	// [Technical] Whether all pages are accessible only over HTTPS
	static $force_https_all = false;
	
	// [Technical] Whether only checkout related pages and customer details are accessible only over HTTPS
	static $force_https_checkout = true;
	
	// [Technical] Disable HTTPS all together for local testing
	static $force_https_off = true;

}
