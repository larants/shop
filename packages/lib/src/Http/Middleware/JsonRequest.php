<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/5
 */

namespace LarAnt\Lib\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * 保证API相应格式为JSON
 *
 * Class JsonRequest
 * @package LarAnt\Lib\Http\Middleware
 */
class JsonRequest
{

    /**
     * @var array
     */
    protected $invalid = ['undefined'];

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        $this->handleQueries($request->query);
        $response = $next($request);
        // 返回解析
        if ($response instanceof JsonResponse) {
            /* @var array $data */
            $data = $response->getData(true);
            $data['success'] = $response->isSuccessful();
            $response->setData($data);
        }

        return $response;
    }

    /**
     * 处理Query参数
     *
     * @param ParameterBag $bag
     */
    protected function handleQueries(ParameterBag $bag)
    {
        // 过滤无效数据
        $params = collect($bag->all())->filter(function ($value) {
            $value = trim($value);
            return $value && !in_array($value, $this->invalid);
        });
        $data = [
            'with' => $params->get('with'),
            'withCount' => $params->get('withCount'),
            'sorter' => $params->get('sorter'),
            'page' => $params->get('current', 1),
            'pageSize' => $params->get('pageSize'),
            'filters' => $params->except(['with', 'withCount', 'sorter', 'current', 'pageSize'])->toArray()
        ];

        $bag->replace($data);
    }
}