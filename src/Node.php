<?php

namespace Artichoke\Pterodactyl;

use Illuminate\Support\Facades\Log;

class Node
{

    public $id;
    public $uuid;
    public $public;
    public $name;
    public $description;
    public $location_id;
    public $fqdn;
    public $scheme;
    public $behind_proxy;
    public $maintenance_mode;
    public $memory;
    public $memory_overallocate;
    public $disk;
    public $disk_overallocate;
    public $upload_size;
    public $daemon_listen;
    public $daemon_sftp;
    public $daemon_base;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        //
    }

    protected function throwError($response) {
        Log::error('Pterodactyl API Error: ', $response['errors']);
        throw new PterodactylApiException('API returned an error:', $response['errors']);
    }

    public function fromApiData(array $data)
    {
        $this->id = $data['id'];
        $this->uuid = $data['uuid'];
        $this->public = $data['public'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->location_id = $data['location_id'];
        $this->fqdn = $data['fqdn'];
        $this->scheme = $data['scheme'];
        $this->behind_proxy = $data['behind_proxy'];
        $this->maintenance_mode = $data['maintenance_mode'];
        $this->memory = $data['memory'];
        $this->memory_overallocate = $data['memory_overallocate'];
        $this->disk = $data['disk'];
        $this->disk_overallocate = $data['disk_overallocate'];
        $this->upload_size = $data['upload_size'];
        $this->daemon_listen = $data['daemon_listen'];
        $this->daemon_sftp = $data['daemon_sftp'];
        $this->daemon_base = $data['daemon_base'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

    public function configuration() {
        $response = Api::get('/nodes/' . $this->id . '/configuration');
        return $response;
    }

    public function allocations() {
        return Pterodactyl::allocations($this);
    }

    public function create() {
        $response = Api::post('/nodes', [
            'name' => $this->name,
            'description' => $this->description,
            'location_id' => $this->location_id,
            'fqdn' => $this->fqdn,
            'scheme' => $this->scheme,
            'memory' => $this->memory,
            'memory_overallocate' => $this->memory_overallocate,
            'disk' => $this->disk,
            'disk_overallocate' => $this->disk_overallocate,
            'upload_size' => $this->upload_size,
            'daemon_listen' => $this->daemon_listen,
            'daemon_sftp' => $this->daemon_sftp,
        ]);
        $this->fromApiData($response['attributes']);
    }

    public function update() {
        $response = Api::patch('/nodes/' . $this->id, [
            'name' => $this->name,
            'description' => $this->description,
            'location_id' => $this->location_id,
            'fqdn' => $this->fqdn,
            'scheme' => $this->scheme,
            'memory' => $this->memory,
            'memory_overallocate' => $this->memory_overallocate,
            'disk' => $this->disk,
            'disk_overallocate' => $this->disk_overallocate,
            'upload_size' => $this->upload_size,
            'daemon_listen' => $this->daemon_listen,
            'daemon_sftp' => $this->daemon_sftp,
        ]);
        $this->fromApiData($response['attributes']);
    }

    public function delete() {
        $response = Api::delete('/nodes/' . $this->id);
        return $response;
    }



}