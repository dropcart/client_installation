<?php
/*******************************
 * DropCart Configuration File *
 *******************************
You can set some settings here.
If you don't know what you are doing
please use the website generator in
the DropCart Admin.
 */

class Config
{


	static $default_language = "nl";


	static $store_name = "Superwinkel";


	static $company_chamber_of_commerce_no = "12345678";


	static $company_vat_id = "NL344590046B06";


	static $company_customer_email = "support@emailadres.nl";


	static $address = "Straatnaam 23A, 1133 IZ Nuenen, Nederland";


	static $company_customer_phone = "(+31)(0) 72 1234 567";

	// The (virtual) domain name which hosts this installation.
	// NOTE: If not set, under Apache 2, `UseCanonicalName` must be set
	// to `On`, and the virtual host must have a defined `ServerName`, to prevent spoofing.
	// NOTE: this must be a fully qualified domain name with protocol
	static $domain = "https://api.staging.dropcart.nl";
	
	// The URL relative to the domain, must begin with a slash and must end with a slash.
	static $base_url = "/";
	
	// The visible name of the site.
	static $site_name = "Tonerkopen";
	
	// E-mail address shown on contact page, and on order page.
	// Please refer to the contact template for editing the contact page.
	static $site_contact_email = "support@emailadres.nl";

	// [Technical] Endpoint for Dropcart API
	static $dropcart_api_endpoint = "https://api.staging.dropcart.nl";

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
