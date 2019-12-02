<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 15/01/18
 * Time: 18:07
 */

namespace App\MongoCache;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;

class MongoCacheServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('cache', function ($cache) {
            /** @var $cache CacheManager */
            $cache->extend('mongodb', function ($app) {
                $manager = new MongoCacheManager($app);

                return $manager->driver('mongodb');
            });
        });
    }
}