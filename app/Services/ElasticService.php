<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticService
{
    private $client;

    public function __construct()
    {

    }

    /**
     * @throws AuthenticationException
     */
    protected function client(): Client
    {
        if(!$this->client) {
            $this->client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_URL')])
                ->build();
        }
        return $this->client;
    }

    public function getInfo()
    {
        return $this->client()->info()->asObject();
    }

}
