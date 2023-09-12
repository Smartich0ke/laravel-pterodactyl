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


    /**
     * Get all users belonging to the application.
     *
     * @return Collection
     */
    public static function users(): Collection {
        $data = self::get('/users');
        $users = [];
        foreach ($data['data'] as $userData) {
            $user = new User();
            $user->fromApiData($userData['attributes']);
            $users[] = $user;
        }

        return new Collection($users);

    }

    /**
     * Get a user by their ID.
     *
     * @param int $id
     * @return User
     */
    public static function user(int $id): User {
        $data = self::get('/users/'.$id);
        $user = new User();
        $user->fromApiData($data['attributes']);
        return $user;
    }

    /**
     * Get a user by their external ID.
     *
     * @param int $id
     * @return User
     */
    public static function userByExternalId(int $id): User {
        $data = self::get('/users/external/'.$id);
        $user = new User();
        $user->fromApiData($data['attributes']);
        return $user;
    }

    public static function nodes(): Collection {
        $data = self::get('/nodes');
        $nodes = [];
        foreach ($data['data'] as $nodeData) {
            $node = new Node();
            $node->fromApiData($nodeData['attributes']);
            $nodes[] = $node;
        }

        return new Collection($nodes);
    }

    public static function node(int $id): Node {
        $data = self::get('/nodes/'.$id);
        $node = new Node();
        $node->fromApiData($data['attributes']);
        return $node;
    }

    public static function locations(): Collection {
        $data = self::get('/locations');
        $locations = [];
        foreach ($data['data'] as $locationData) {
            $location = new Location();
            $location->fromApiData($locationData['attributes']);
            $locations[] = $location;
        }
        return new Collection($locations);
    }

    public static function location(int $id): Location {
        $data = self::get('/locations/'.$id);
        $location = new Location();
        $location->fromApiData($data['attributes']);
        return $location;
    }

    public static function allocations(Node $node): Collection {
        $nodeId = $node->id;
        $data = self::get('/nodes/'.$nodeId.'/allocations');
        $allocations = [];
        foreach ($data['data'] as $allocationData) {
            $allocation = new Allocation($node);
            $allocation->fromApiData($allocationData['attributes']);
            $allocations[] = $allocation;
        }

        return new Collection($allocations);
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

    public static function post($endpoint, $data) {
        $url = self::$api_url.'/api/application'.$endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, $data);
        return $response->json();
    }

    public static function patch($endpoint, $data) {
        $url = self::$api_url.'/api/application'.$endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch($url, $data);
        return $response->json();
    }

    public static function delete($endpoint) {
        $url = self::$api_url.'/api/application'.$endpoint;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.self::$api_key,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->delete($url);
        return $response->json();
    }
    

}
