<?php

namespace App\Traits;

use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;

trait Nanoids
{
    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $client = new Client();
                $key = $client->formattedId($alphabet = '0123456789abcdefghijklmnopqrstuvwxyz', $size = 21);
                $model->{$model->getKeyName()} = $key->toString();
            }
        });
    }
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
