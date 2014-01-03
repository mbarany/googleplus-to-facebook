<?php
require_once 'Barany/GooglePlusToFacebook/GooglePlusConfig.php';
require_once 'Barany/GooglePlusToFacebook/FacebookConfig.php';

use Barany\GooglePlusToFacebook\GooglePlusConfig;
use Barany\GooglePlusToFacebook\FacebookConfig;

$google_config = new GooglePlusConfig(
    'user_id',
    'client_id',
    'service_account_name',
    dirname(__FILE__) . '/path_to_private_key.p12',
    'private_key_secret'
);
$facebook_config = new FacebookConfig(
    'user_id',
    'app_id',
    'app_secret'
);