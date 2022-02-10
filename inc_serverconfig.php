<?php // Parkers- emptyTheme: server configuration


define('domainNameDevelop','localhost');
define('domainNameLive','pantlin.eu');

if ($_SERVER['SERVER_NAME'] == domainNameDevelop) {
   define('SITE_LIVE', false);
   define('WP_SITEURL', 'http://'.domainNameDevelop);
   define('WP_HOME', 'http://'.domainNameDevelop);
   define('FS_METHOD', 'direct'); // 'ssh' is also an option, but did not work for my setup
   define('FTP_BASE', dirname(__FILE__)); // set this to your docroot
   define('FTP_CONTENT_DIR', FTP_BASE.'/wp-content/');
   define('FTP_PLUGIN_DIR ', FTP_CONTENT_DIR.'/wp-content/plugins/');
   define('FTP_HOST', 'localhost:22'); // or whatever port you're using for SSH
   define('WP_DEBUG', true);
   define('WP_DEBUG_DISPLAY', true); // Turn forced display ON
   define( 'WP_DEBUG_LOG', true ); // enable logging
   @ini_set('display_errors',1);
   define('WP_ALLOW_REPAIR', true);
   define('WP_POST_REVISIONS', 5);
   define('GOOGLEMAP_API_KEY', '');
} elseif (strpos($_SERVER['SERVER_NAME'], "staging"))  {
   define('SITE_LIVE', false);
   define('WP_SITEURL', 'http://staging.'.domainNameLive);
   define('WP_HOME', 'http://staging.'.domainNameLive);
   define('WP_DEBUG', false);
   define('WP_DEBUG_DISPLAY', false); // Turn forced display OFF
   define('WP_ALLOW_REPAIR', true);
   define('WP_POST_REVISIONS', 5);
   define('GOOGLEMAP_API_KEY', '');
 
 } else {
   define('SITE_LIVE', false);
   define('WP_SITEURL', 'http://'.domainNameLive);
   define('WP_HOME', 'http://'.domainNameLive);
   define('WP_DEBUG', false);
   define('WP_DEBUG_DISPLAY', false); // Turn forced display OFF
   define('WP_ALLOW_REPAIR', true);
   define('WP_POST_REVISIONS', 5);
   define('GOOGLEMAP_API_KEY', '');
 }
 ?>