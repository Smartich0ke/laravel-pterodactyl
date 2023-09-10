<?php

namespace Artichoke\Pterodactyl;

class Allocation
{

    public $id;
    public $ip;
    public $alias;
    public $ports;
    public Node $node;

    public function __construct(Node $node)
    {
        $this->node = $node;
    }


    public function fromApiData(array $data)
    {
        $this->id = $data['id'];
        $this->ip = $data['ip'];
        $this->alias = $data['alias'];
        $this->port = $data['port'];
    }

    public function create() {
        $response = Pterodactyl::post('/nodes/'.$this->node->id.'/allocations', [
            'ip' => $this->ip,
            'alias' => $this->alias,
            'ports' => $this->ports,
        ]);
//        $this->fromApiData($response['attributes']);
    }

    public function delete() {;
        $response = Pterodactyl::delete('/nodes/'.$this->node->id.'/allocations/'.$this->id);
        return $response;
    }


}