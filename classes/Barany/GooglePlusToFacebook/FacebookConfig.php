<?php
namespace Barany\GooglePlusToFacebook;

class FacebookConfig {
    private $user_id;
    private $app_id;
    private $app_secret;

    public function __construct($user_id, $app_id, $app_secret) {
        $this->user_id = $user_id;
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getAppId() {
        return $this->app_id;
    }

    public function getAppAccessToken() {
        return $this->app_id . '|' . $this->app_secret;
    }
}