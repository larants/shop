<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/14
 */

namespace Leading\Lib\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Arr;

/**
 * Class PaginationResourceResponse
 * @package Leading\Lib\Http\Resources
 */
class PaginationResourceResponse extends PaginatedResourceResponse
{

    /**
     * @param Request $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginated = $this->resource->resource->toArray();

        return [
            'page' => Arr::get($paginated, 'current_page', 1),
            'total' => Arr::get($paginated, 'total', 0),
            'meta' => $this->antMeta($paginated),
        ];
    }

    /**
     * @param $paginated
     * @return array
     */
    protected function antMeta($paginated)
    {
        return Arr::only($paginated, ['current_page', 'per_page', 'total', 'to', 'from']);
    }
}