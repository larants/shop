<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/14
 */

namespace Leading\Lib\Http\Resources;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


/**
 * Class CollectionResource
 * @package Leading\Lib\Http\Resources
 */
class CollectionResource extends ResourceCollection
{

    /**
     * CollectionResource constructor.
     * @param $resource
     * @param string|null $collects
     */
    public function __construct($resource, $collects = null)
    {
        $collects && $this->collects = $collects;

        parent::__construct($resource);
    }

    /**
     * Create a paginate-aware HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (!is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginationResourceResponse($this))->toResponse($request);
    }

}