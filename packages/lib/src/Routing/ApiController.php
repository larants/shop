<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2018-12-11
 */

namespace Leading\Lib\Routing;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Leading\Lib\Http\Resources\CollectionResource;

/**
 * Class ApiController
 * @package Leading\Lib\Routing
 */
class ApiController extends Controller
{
    use DispatchesJobs;

    /**
     * @param $resource
     * @param string|null $collects
     * @return JsonResponse
     */
    protected function toPagination($resource, $collects = null)
    {
        return (new CollectionResource($resource, $collects))->response();
    }

    /**
     * @param $resource
     * @param string|null $collects
     * @return JsonResponse
     */
    protected function toCollection($resource, $collects = null)
    {
        return (new CollectionResource($resource, $collects))->response();
    }

    /**
     * @param $resource
     * @return JsonResponse
     */
    protected function toItem($resource)
    {
        if ($resource instanceof JsonResource) {
            return $resource->response();
        }

        return (new JsonResource($resource))->response();
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function toArray(array $data)
    {
        return response()->json(['data' => $data]);
    }


    /**
     * 为了返回结构一致
     *
     * @return JsonResponse
     */
    protected function noContent()
    {
        return response()->json([]);
    }

}