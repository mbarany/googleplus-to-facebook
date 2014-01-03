<?php
ini_set('display_startup_errors', 0);
ini_set('display_errors', 0);

set_include_path(dirname(__FILE__) . '/classes' . PATH_SEPARATOR . get_include_path());
set_include_path(dirname(__FILE__) . '/vendor/google-api-php-client/src' . PATH_SEPARATOR . get_include_path());

require_once dirname(__FILE__) . '/private/config.php';
require_once 'Barany/GooglePlusToFacebook/KeyValueFileCache.php';
require_once 'Barany/GooglePlusToFacebook/GooglePlus.php';
require_once 'Barany/GooglePlusToFacebook/Facebook.php';

use Barany\GooglePlusToFacebook\KeyValueFileCache;
use Barany\GooglePlusToFacebook\GooglePlus;
use Barany\GooglePlusToFacebook\Facebook;

if (!isset($google_config, $facebook_config)) {
    throw new RuntimeException('Missing Configs!');
}

$cache = new KeyValueFileCache(dirname(__FILE__) . '/cache');
$google_plus = new GooglePlus($google_config, $cache);
$posts = $google_plus->getNewPosts();

if ($posts) {
    $facebook = new Facebook($facebook_config);
    $facebook->postFromGooglePlus($posts);
}

$google_plus->commitLastUpdated();
