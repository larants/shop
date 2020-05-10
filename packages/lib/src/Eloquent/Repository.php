<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/3
 */

namespace Leading\Lib\Eloquent;


use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use Leading\Lib\Contracts\RepositoryInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class Repository
 * @package Leading\Lib\Eloquent
 * @mixin Model
 */
abstract class Repository implements RepositoryInterface
{
    use ForwardsCalls;

    /**
     * @param ParameterBag $bag
     * @return LengthAwarePaginator
     */
    public function paginate(ParameterBag $bag = null)
    {
        $input = [];
        if ($bag instanceof ParameterBag) {
            $input = $bag->all();
        }

        return $this->filter($input)->paginate($bag->get('pageSize', 20));
    }

    /**
     * @param ParameterBag|null $bag
     * @param array $columns
     * @return Collection
     */
    public function all(ParameterBag $bag = null, $columns = ['*'])
    {
        $input = $bag ? $bag->all() : [];

        return $this->filter($input)->get($columns);
    }

    /**
     * @param $id
     * @param ParameterBag|null $bag
     * @return Model|mixed
     */
    public function show($id, ParameterBag $bag = null)
    {
        $input = $bag ? $bag->all() : [];

        return $this->filter($input)->whereKey($id)->firstOrFail();
    }

    /**
     * @param ParameterBag $bag
     * @return Model|mixed
     */
    public function store(ParameterBag $bag)
    {
        return $this->create($bag->all());
    }

    /**
     * @param $id
     * @param ParameterBag $bag
     * @return Model|mixed
     */
    public function update($id, ParameterBag $bag)
    {
        $model = $this->find($id);
        $model->fill($bag->all());
        $model->save();

        return $model;
    }

    /**
     * @param $id
     * @return bool|mixed|null
     * @throws Exception
     */
    public function destroy($id)
    {
        return $this->find($id)->delete();
    }


    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->newModel(), $method, $parameters);
    }

}