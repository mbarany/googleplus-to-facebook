<?php
namespace Barany\GooglePlusToFacebook;

require_once 'Google/Client.php';
require_once 'Google/Service/Plus.php';

use Google_Client;
use Google_Service_Plus;
use Google_Service_Plus_Activity;

class GooglePlus {
    const APP_NAME = 'Google Plus to Facebook';
    const CACHE_LAST_UPDATED = 'google_last_updated';
    const COLLECTION = 'public';

    private $config;
    private $cache;
    private $last_updated;
    private $client;
    private $service;

    /**
     * @param GooglePlusConfig $config
     * @param KeyValueFileCache $cache
     */
    public function __construct(GooglePlusConfig $config, KeyValueFileCache $cache) {
        $this->config = $config;
        $this->cache = $cache;
        $this->last_updated = $this->cache->get(self::CACHE_LAST_UPDATED);
        if ($this->last_updated === null) {
            $this->last_updated = date('c');
            $this->cache->put(self::CACHE_LAST_UPDATED, $this->last_updated);
        }
        $this->client = new Google_Client();
        $this->client->setApplicationName(self::APP_NAME);
        $this->client->setAssertionCredentials($this->config->getCredentials());
        $this->service = new Google_Service_Plus($this->client);
    }

    /**
     * @return array|null
     */
    public function getNewPosts() {
        $result = $this->service->activities->listActivities($this->config->getUserId(), self::COLLECTION);
        if ($this->last_updated == $result->getUpdated() || count($result->getItems()) == 0) {
            return null;
        }
        $posts = array();
        /* @var $item Google_Service_Plus_Activity */
        foreach (array_reverse($result->getItems()) as $item) {
            if (strtotime($this->last_updated) >= strtotime($item->getUpdated())) {
                continue;
            }
            $posts[] = $item;
        }
        $this->last_updated = $result->getUpdated();
        return $posts;
    }

    public function commitLastUpdated() {
        $this->cache->put(self::CACHE_LAST_UPDATED, $this->last_updated);
    }
}