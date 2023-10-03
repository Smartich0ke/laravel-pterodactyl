<?php

namespace Artichoke\Pterodactyl;

use Illuminate\Support\Collection;

class Server
{

    public $id;
    public $external_id;
    public $uuid;
    public $identifier;
    public $name;
    public $description;
    public $suspended;
    public $limits;
    public $feature_limits;
    public $user;
    public $node;
    public $allocation;
    public $nest;
    public $egg;
    public $pack;
    public $container;
    public $updated_at;
    public $created_at;

    public function __construct(Node $node, User $user, Allocation $allocation)
    {
        $this->node = $node;
        $this->user = $user;
        $this->allocation = $allocation;
    }

    public function fromApiData($data) {
        $this->id = $data['id'];
        $this->external_id = $data['external_id'];
        $this->uuid = $data['uuid'];
        $this->identifier = $data['identifier'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->suspended = $data['suspended'];
        $this->limits = $data['limits'];
        $this->feature_limits = $data['feature_limits'];
//        $this->user = $data['user'];
//        $this->node = $data['node'];
//        $this->allocation = $data['allocation'];
        $this->nest = $data['nest'];
        $this->egg = $data['egg'];
        $this->container = $data['container'];
        $this->updated_at = $data['updated_at'];
        $this->created_at = $data['created_at'];

// Packs is an unfinished feature that the API does not seem to return despite the API reference saying it does
//        $this->pack = $data['pack'];
    }

    public function allocations() {
        $response = Api::get('/servers/' . $this->id, ['allocations']);
        $allocations = [];
        foreach ($response['attributes']['relationships']['allocations']['data'] as $allocationData) {
            $allocation = new Allocation($this->node);
            $allocation->fromApiData($allocationData['attributes']);
            $allocations[] = $allocation;
        }
        return new Collection($allocations);
    }

    public function node() {
        $response = Api::get('/servers/' . $this->id, ['node']);
        $node = new Node();
        $node->fromApiData($response['attributes']['relationships']['node']['attributes']);
        $this->node = $node;
        return $node;
    }

    public function user() {
        $response = Api::get('/servers/' . $this->id, ['user']);
        $user = new User();
        $user->fromApiData($response['attributes']['relationships']['user']['attributes']);
        $this->user = $user;
        return $user;

    }

    public function subusers() {
        $response = Api::get('/servers/' . $this->id, ['subusers']);
        $subusers = [];
        foreach ($response['attributes']['relationships']['subusers']['data'] as $subuserData) {
            $subuser = new User();
            $subuser->fromApiData($subuserData['attributes']);
            $subusers[] = $subuser;
        }
        return new Collection($subusers);
    }

    public function location() {
        $response = Api::get('/servers/' . $this->id, ['location']);
        $location = new Location();
        $location->fromApiData($response['attributes']['relationships']['location']['attributes']);
        $this->location = $location;
        return $location;
    }


}