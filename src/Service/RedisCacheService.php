<?php

namespace App\Service;

use Predis\Client;

class RedisCacheService
{
    private $redis;

    public function __construct(string $redisUrl)
    {
        $this->redis = new Client($redisUrl);
    }

    public function get(string $key)
    {
        return $this->redis->get($key);
    }

    public function set(string $key, $value, int $expiration = null)
    {
        if ($expiration) {
            $this->redis->setex($key, $expiration, $value);
        } else {
            $this->redis->set($key, $value);
        }
    }

    public function delete(string $key)
    {
        $this->redis->del($key);
    }
}
