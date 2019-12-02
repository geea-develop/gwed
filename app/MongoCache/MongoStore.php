<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 15/01/18
 * Time: 18:07
 */

namespace App\MongoCache;

use Closure;
use Illuminate\Cache\DatabaseStore;

class MongoStore extends DatabaseStore
{
    /**
     * Increment or decrement an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  \Closure  $callback
     * @return int|bool
     */
    protected function incrementOrDecrement($key, $value, Closure $callback)
    {
        $prefixed = $this->prefix.$key;
        $cache = $this->table()->where('key', $prefixed)->lockForUpdate()->first();
        if (is_null($cache)) {
            return false;
        }
        if (is_array($cache)) {
            $cache = (object) $cache;
        }

//        dd($cache->value);
//        $current = unserialize($cache->value);
        $new = $callback((int) $cache->value, $value);
        if (! is_numeric($cache->value)) {
            return false;
        }
        $this->table()->where('key', $prefixed)->update([
            'value' => serialize($new)
        ]);
        return $new;
    }
}