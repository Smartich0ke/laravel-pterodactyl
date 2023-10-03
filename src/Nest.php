<?php

namespace Artichoke\Pterodactyl;

class Nest
{

    public $id;

    public $uuid;

    public $author;

    public $description;

    public $name;

    public $created_at;

    public $updated_at;

    public function __construct()
    {
        //
    }

    public function fromApiData(array $data)
    {
        $this->id = $data['id'];
        $this->uuid = $data['uuid'];
        $this->author = $data['author'];
        $this->description = $data['description'];
        $this->name = $data['name'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

}