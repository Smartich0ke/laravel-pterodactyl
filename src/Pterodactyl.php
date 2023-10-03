<?php

namespace Artichoke\Pterodactyl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class Pterodactyl
{


    /**
     * Get all users belonging to the application.
     *
     * @return Collection
     */
    public static function users(): Collection {
        $data = Api::get('/users');
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
        $data = Api::get('/users/' . $id);
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
        $data = Api::get('/users/external/' . $id);
        $user = new User();
        $user->fromApiData($data['attributes']);
        return $user;
    }

    public static function servers(): Collection {
        $data = Api::get('/servers');
        $servers = [];
        foreach ($data['data'] as $serverData) {
            $node = self::node($serverData['attributes']['node']);
            $user = self::user($serverData['attributes']['user']);
            $allocations = self::allocations($node);
            $allocation = $allocations->where('id', $serverData['attributes']['allocation'])->first();
            $server = new Server($node, $user, $allocation);
            $server->fromApiData($serverData['attributes']);
            $servers[] = $server;
        }

        return new Collection($servers);
    }

    public static function nodes(): Collection {
        $data = Api::get('/nodes');
        $nodes = [];
        foreach ($data['data'] as $nodeData) {
            $node = new Node();
            $node->fromApiData($nodeData['attributes']);
            $nodes[] = $node;
        }

        return new Collection($nodes);
    }

    public static function node(int $id): Node {
        $data = Api::get('/nodes/' . $id);
        $node = new Node();
        $node->fromApiData($data['attributes']);
        return $node;
    }

    public static function nests(): Collection {
        $data = Api::get('/nests');
        $nests = [];
        foreach ($data['data'] as $nestData) {
            $nest = new Nest();
            $nest->fromApiData($nestData['attributes']);
            $nests[] = $nest;
        }

        return new Collection($nests);
    }

    public static function nest(int $id): Nest {
        $data = Api::get('/nests/' . $id);
        $nest = new Nest();
        $nest->fromApiData($data['attributes']);
        return $nest;
    }

    public static function locations(): Collection {
        $data = Api::get('/locations');
        $locations = [];
        foreach ($data['data'] as $locationData) {
            $location = new Location();
            $location->fromApiData($locationData['attributes']);
            $locations[] = $location;
        }
        return new Collection($locations);
    }

    public static function location(int $id): Location {
        $data = Api::get('/locations/' . $id);
        $location = new Location();
        $location->fromApiData($data['attributes']);
        return $location;
    }

    public static function allocations(Node $node): Collection {
        $nodeId = $node->id;
        $data = Api::get('/nodes/' . $nodeId . '/allocations');
        $allocations = [];
        foreach ($data['data'] as $allocationData) {
            $allocation = new Allocation($node);
            $allocation->fromApiData($allocationData['attributes']);
            $allocations[] = $allocation;
        }

        return new Collection($allocations);
    }


}
