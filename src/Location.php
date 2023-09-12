<?php

namespace Artichoke\Pterodactyl;

class Location
{

    public $id;

    public $short;

    public $long;

    public $updated_at;

    public $created_at;

    public function __construct()
    {
        //
    }

    public function fromApiData(array $data)
    {
        $this->id = $data['id'];
        $this->short = $data['short'];
        $this->long = $data['long'];
        $this->updated_at = $data['updated_at'];
        $this->created_at = $data['created_at'];
    }

    public function create() {
        $response = Pterodactyl::post('/locations', [
            'short' => $this->short,
            'long' => $this->long,
        ]);
    }

    public function update() {
        $response = Pterodactyl::patch('/locations/'.$this->id, [
            'short' => $this->short,
            'long' => $this->long,
        ]);
        $this->fromApiData($response['attributes']);
    }

    public function delete() {
        $response = Pterodactyl::delete('/locations/'.$this->id);
        return $response;
    }
}