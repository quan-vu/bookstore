<?php

namespace App\Services;

use App\Models\Book;
use Carbon\Carbon;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Support\Facades\Log;

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

    public function indexBook(Book $book): ?array
    {
        // Format book for index
        $params = [
            'id' => $book->id,
            'index' => 'books',
            'body'  => [
                'title' => $book->title,
                'summary' => $book->summary,
                'publisher' => $book->publisher->name,
                'authors' => $book->authors->pluck('name'),
            ]
        ];

        try {
            $response = $this->client()->index($params);
            $book->update(['indexed_at' => Carbon::now()->toDateTimeString()]);
            return $response->asArray();  // response body content as array
        } catch (ClientResponseException $e) {
            // manage the 4xx error
            Log::warning("[ELASTIC][ERROR][ClientResponseException] Index Book: {$e->getTraceAsString()} ");
        } catch (ServerResponseException $e) {
            // manage the 5xx error
            Log::warning("[ELASTIC][ERROR][ServerResponseException] Index Book: {$e->getTraceAsString()} ");
        } catch (Exception $e) {
            // eg. network error like NoNodeAvailableException
            Log::warning("[ELASTIC][ERROR][NoNodeAvailableException] Index Book: {$e->getTraceAsString()} ");
        }
        return null;
    }

}
