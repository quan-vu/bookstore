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

    public function searchBook(string $keyword, int $limit = 10, int $page = 1)
    {
        $offset = ($page - 1) * $limit;
        $params = [
            'index' => 'books',
            'body'  => [
                "from" => $offset,
                "size" => $limit,
                "track_total_hits" => true,
                'query' => [
                    // Search match title field only: total records = 222254, the same with search in MySQL database on sample database
                    /*'match_phrase' => [
                        'title' => $keyword
                    ],*/
                    // Search match title, publisher, author field: total records = 417621 on sample database
                    "multi_match" => [
                        "query" => $keyword,
                        "fields" => ["title", "publisher", "authors"],
                        "operator" => "or",
                    ],
                ]
            ]
        ];

        $response = $this->client()->search($params);

        $total = $response['hits']['total']['value'] ?? 0;

        $items = $response['hits']['hits'] ?? [];
        if (count($items)) {
            $itemsFormat = collect($items)->map(function ($item, $key) {
                return ['id' => intval($item['_id'])] + $item['_source'];
            })->toArray();
        }


        return [
            'total' => $total,
            "current_page" => $page,
            "per_page" => $limit,
            "last_page" => ceil($total / $limit),
            "prev_page_url" => null,
            "next_page_url" => null,
            'items' => $itemsFormat,
            'spent_time' => "{$response['took']} ms",
        ];

        // return $response->asArray();
        // printf("Total docs: %d\n", $response['hits']['total']['value']);
        // printf("Max score : %.4f\n", $response['hits']['max_score']);
        // printf("Took      : %d ms\n", $response['took']);
        // print_r($response['hits']['hits']); // documents
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
