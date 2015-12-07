<?php
/*
Plugin Name: Shortshort
Plugin URI: https://bitbucket.org/abaumg/yourls-shortshort
Description: This plugin for YOURLS checks if a long URL is in fact already shortened (e.g. t.co, bit.ly, youtu.be) etc. The purpose is to avoid nested shortened links.
Version: 0.1
Author: abaumg
Author URI: http://www.andreas.bz.it/
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_filter('shunt_add_new_link', 'abaumg_shortshort_check_and_bypass');

function abaumg_shortshort_check_and_bypass($is_short, $url)
{
	$hostnames_to_bypass = array	(
										't.co',
										'twitter.com',
										'bit.ly',
										'youtu.be'
									);

	$urltoshorten_hostname = parse_url($url, PHP_URL_HOST);

	if (in_array(strtolower($urltoshorten_hostname), $hostnames_to_bypass))
	{
		# Don't shorten the URL!
		$return = array();
		$return['status']    = 'fail';
		$return['code']      = 'error:bypass';
		$return['message']   = yourls__( 'shortshort: URL is a shortened URL');
		$return['errorCode'] = '400';
		return $return;
	}
}
?>
