<?php

namespace Artichoke\Pterodactyl;

use Illuminate\Support\Facades\Http;

class Api
{

    public static $api_key;
    public static $api_url;

    public static function init()
    {
        self::$api_key = config('pterodactyl.api_key');
        self::$api_url = config('pterodactyl.api_url');
    }

    public static function get($endpoint, $params = [])
    {
        $url = self::$api_url . '/api/application' . $endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get($url, [
            'include' => implode(',', $params),
        ]);
        return $response->json();

    }

    public static function delete($endpoint)
    {
        $url = self::$api_url . '/api/application' . $endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->delete($url);
        return $response->json();
    }

    public static function post($endpoint, $data)
    {
        $url = self::$api_url . '/api/application' . $endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, $data);
        return $response->json();
    }

    public static function patch($endpoint, $data)
    {
        $url = self::$api_url . '/api/application' . $endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch($url, $data);
        return $response->json();
    }
}