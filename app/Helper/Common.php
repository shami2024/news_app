<?php
namespace App\Helper;


class Common
{

    public static function apiResponse(bool $success, $message, $data = null, $statusCode = null, $paginates = null, $paginationKey = null)
    {
        if ($statusCode === null) {
            $statusCode = $success ? 200 : 422;
        }

        $paginationData = null;

        // Check if data is a collection directly or a paginated resource
        if ($paginationKey === null) {
            if ($data instanceof \Illuminate\Http\Resources\Json\AnonymousResourceCollection) {
                $resourceData = $data->resource;

                if ($resourceData instanceof LengthAwarePaginator) {
                    $paginationData = self::paginationData($resourceData);
                    $data = $resourceData->getCollection();
                }
            } elseif ($data instanceof LengthAwarePaginator) {
                $paginationData = self::paginationData($data);
                $data = $data->getCollection();
            }
        }
        // Check if data contains the pagination key and it's paginated
        elseif (isset($data[$paginationKey])) {
            $dataForPagination = $data[$paginationKey];

            if ($dataForPagination instanceof \Illuminate\Http\Resources\Json\AnonymousResourceCollection) {
                $resourceData = $dataForPagination->resource;

                if ($resourceData instanceof LengthAwarePaginator) {
                    $paginationData = self::paginationData($resourceData);
                    $data[$paginationKey] = $dataForPagination->getCollection();
                }
            } elseif ($dataForPagination instanceof LengthAwarePaginator) {
                $paginationData = self::paginationData($dataForPagination);
                $data[$paginationKey] = $dataForPagination->getCollection();
            }
        }
        if ($paginates) {

            foreach ($paginates as $paginationKey => $paginationCollection) {
                if ($paginationCollection instanceof LengthAwarePaginator) {
                    $paginationData = self::paginationData($paginationCollection);
                    $data[$paginationKey] = $paginationCollection->getCollection();
                }
            }
        }


        return response()->json(
            [
                'success'   => $success,
                'message'   => __($message),
                'data'      => $data,
                'paginates' => $paginationData,
            ],
            $statusCode
        );
    }

    // Pagination data formatting function remains unchanged
    public static function paginationData($data)
    {
        return [
            'meta' => [
                'current_page'  => $data->currentPage(),
                'from'          => $data->firstItem(),
                'last_page'     => $data->lastPage(),
                'path'          => $data->path(),
                'per_page'      => $data->perPage(),
                'to'            => $data->lastItem(),
                'total'         => $data->total(),
            ],
            'links' => [
                'first' => $data->url(1),
                'last'  => $data->url($data->lastPage()),
                'prev'  => $data->previousPageUrl(),
                'next'  => $data->nextPageUrl(),
            ],
        ];
    }

    public static function          getPaginates($collection)
    {
        return [
            'per_page' => $collection->perPage(),
            'path' => $collection->path(),
            'total' => $collection->total(),
            'current_page' => $collection->currentPage(),
            'next_page_url' => $collection->nextPageUrl(),
            'previous_page_url' => $collection->previousPageUrl(),
            'last_page' => $collection->lastPage(),
            'has_more_pages' => $collection->hasMorePages(),
            'from' => $collection->firstItem(),
            'to' => $collection->lastItem(),
        ];
    }
}


