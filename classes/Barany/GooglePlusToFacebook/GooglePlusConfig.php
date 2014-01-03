<?php
namespace Barany\GooglePlusToFacebook;

use Google_Auth_AssertionCredentials;

class GooglePlusConfig {
    private static $SCOPES = array(
        'https://www.googleapis.com/auth/plus.login'
    );

    private $user_id;
    private $client_id;
    private $service_account_name;
    private $private_key_file;
    private $private_key_secret;

    public function __construct($user_id, $client_id, $service_account_name, $private_key_file, $private_key_secret) {
        $this->user_id = $user_id;
        $this->client_id = $client_id;
        $this->service_account_name = $service_account_name;
        $this->private_key_file = $private_key_file;
        $this->private_key_secret = $private_key_secret;
    }

    public function getUserId() {
        return $this->user_id;
    }

    /**
     * @return Google_Auth_AssertionCredentials
     */
    public function getCredentials() {
        return new Google_Auth_AssertionCredentials(
            $this->service_account_name,
            self::$SCOPES,
            file_get_contents($this->private_key_file),
            $this->private_key_secret
        );
    }
}