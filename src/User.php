<?php

namespace Artichoke\Pterodactyl;

class User
{

    public $id;
    public $external_id;
    public $uuid;
    public $username;
    public $email;
    public $first_name;
    public $last_name;
    public $language;
    public $root_admin;
    public $multi_factor_auth;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        //
    }

    public function fromApiData(array $data)
    {
        $this->id = $data['id'];
        $this->external_id = $data['external_id'];
        $this->uuid = $data['uuid'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->language = $data['language'];
        $this->root_admin = $data['root_admin'];
        $this->multi_factor_auth = $data['2fa'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

    public function create() {
        $response = Pterodactyl::post('/users', [
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);
        $this->fromApiData($response['attributes']);
    }

}