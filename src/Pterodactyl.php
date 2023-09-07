<?php

namespace Artichoke\Pterodactyl;

class Pterodactyl
{

    protected static $api_key;
    protected static  $api_url;

    public static function init() {
        self::$api_key = config('pterodactyl.api_key');
        self::$api_url = config('pterodactyl.api_url');
    }

}
