<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 15/01/18
 * Time: 18:08
 */

namespace App\MongoCache;

use Closure;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Arr;

class MongoCacheManager extends CacheManager
{
    /**
     * Create an instance of the mongodb cache driver.
     *
     * @param array $config
     * @return \Illuminate\Cache\Repository
     */
    protected function createMongodbDriver(array $config)
    {
        $connection = $this->app['db']->connection(Arr::get($config, 'connection'));
        return $this->repository(
            new MongoStore(
                $connection, $this->app['encrypter'], $config['table'], $this->getPrefix($config)
            )
        );
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->has($key);
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        return $this->pull($key, $default = null);
    }

    /**
     * Store an item in the cache.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  \DateTime|float|int $minutes
     * @return void
     */
    public function put($key, $value, $minutes)
    {
        $this->put($key, $value, $minutes);
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  \DateTime|float|int $minutes
     * @return bool
     */
    public function add($key, $value, $minutes)
    {
        return $this->add($key, $value, $minutes);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string $key
     * @param  mixed $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        return $this->increment($key, $value = 1);
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string $key
     * @param  mixed $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        return $this->decrement($key, $value = 1);
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function forever($key, $value)
    {
        $this->forever($key, $value);
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  string $key
     * @param  \DateTime|float|int $minutes
     * @param  \Closure $callback
     * @return mixed
     */
    public function remember($key, $minutes, Closure $callback)
    {
        return $this->remember($key, $minutes, $callback);
    }

    /**
     * Get an item from the cache, or store the default value forever.
     *
     * @param  string $key
     * @param  \Closure $callback
     * @return mixed
     */
    public function sear($key, Closure $callback)
    {
        return $this->sear($key, $callback);
    }

    /**
     * Get an item from the cache, or store the default value forever.
     *
     * @param  string $key
     * @param  \Closure $callback
     * @return mixed
     */
    public function rememberForever($key, Closure $callback)
    {
        return $this->rememberForever($key, $callback);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string $key
     * @return bool
     */
    public function forget($key)
    {
        return $this->forget($key);
    }
}