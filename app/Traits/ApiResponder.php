<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponder
{
    /**
     * Building success response support pagination
     * @param bool|array|Collection|LengthAwarePaginator|null $data
     * @param string $message
     * @param int $code
     * @param string|null $resourceCollection
     * @return JsonResponse
     */
    public function success(LengthAwarePaginator|bool|array|Collection $data = null, string $message = 'Successfully', int $code = 200, string $resourceCollection = null): JsonResponse
    {
        if ($data instanceof LengthAwarePaginator) {
            if($resourceCollection) {
                // Re-format pagination to use resource collection
                $resourceCollectionInstance = "\\App\\Http\\Resources\\$resourceCollection";
                $items = new $resourceCollectionInstance($data->items());
            }else{
                $items = $data->items();
            }
            $data = [
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'prev_page_url' => $data->previousPageUrl(),
                'next_page_url' => $data->nextPageUrl(),
                'items' => $items,
            ];
        }
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Building error response
     * @param $error
     * @param null $data
     * @param int $code
     * @return JsonResponse
     */
    public function error($error, $data = NULL, int $code = 500): JsonResponse
    {
        return response()->json([
            'message' => $error,
            'data' => $data,
        ], $code);
    }

}
