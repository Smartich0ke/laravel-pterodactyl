<?php

namespace Artichoke\Pterodactyl;

class PterodactylApiException extends \Exception
{
    protected $details;

    public function __construct($message, $details = [])
    {
        parent::__construct($message. ' '. json_encode($details));

        $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
    }

    // You can add more custom methods or override existing ones
}