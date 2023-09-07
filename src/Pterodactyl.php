<?php

namespace Artichoke\Pterodactyl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class Pterodactyl
{

    protected static $api_key;
    protected static  $api_url;

    public static function init() {
        self::$api_key = config('pterodactyl.api_key');
        self::$api_url = config('pterodactyl.api_url');
    }

    public static function users() {
        $data = self::get('/users');
        $users = [];
        foreach ($data['data'] as $userData) {
            $user = new User();
            $user->fromApiData($userData['attributes']);
            $users[] = $user;
        }

        return new Collection($users);

    }

    public static function get($endpoint) {
        $url = self::$api_url.'/api/application'.$endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get($url);
        return $response->json();

    }

}
