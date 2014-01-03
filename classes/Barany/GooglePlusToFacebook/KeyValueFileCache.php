<?php
namespace Barany\GooglePlusToFacebook;

use InvalidArgumentException;

class KeyValueFileCache {
    private $cache_dir;

    /**
     * @param string $cache_dir
     * @throws InvalidArgumentException
     */
    public function __construct($cache_dir) {
        if (!is_writable($cache_dir)) {
            throw new InvalidArgumentException('Supplied cache_dir is not writable!');
        }
        $this->cache_dir = $cache_dir;
    }

    private function validateKey($key) {
        if (preg_match('/^[a-zA-Z0-9_]*$/', $key) !== 1) {
            throw new InvalidArgumentException('Invalid key! Only use uppercase and lowercase letters, numbers, and underscores');
        }
    }

    /**
     * @param string $key
     * @throws InvalidArgumentException
     * @return null|string
     */
    public function get($key) {
        $this->validateKey($key);

        $file = $this->cache_dir . DIRECTORY_SEPARATOR . $key;
        if (!file_exists($file) || !is_readable($file)) {
            return null;
        }
        return file_get_contents($file);
    }

    /**
     * @param string $key
     * @param string $data
     * @throws InvalidArgumentException
     * @return bool
     */
    public function put($key, $data) {
        $this->validateKey($key);

        $file = $this->cache_dir . DIRECTORY_SEPARATOR . $key;
        if (file_exists($file) && !is_writable($file)) {
            return false;
        }
        return file_put_contents($file, $data) !== false;
    }
}