<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @return Model
     * @throws \Exception
     *
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param array $where
     * @param array $with
     * @param array $withCount
     * @param array $order
     * @param null $limit
     * @param array $whereIn
     * @param array $orWhere
     * @param array $select
     * @param array $groupBy
     * @param array $whereNotIn
     * @return mixed
     */
    public function findData(
        $where = [], $with = [], $withCount = [], $order = [], $limit = null, $whereIn = [], $orWhere = [],
        $select = [],
        $groupBy = [], $whereNotIn = []
    ) {

        $static = $this->allQuery($where, $with, $withCount, $order, $limit, $whereIn, $orWhere, $select, $groupBy,
            $whereNotIn);

        return $static->first();
    }

    /**
     * @param array $where
     * @param array $with
     * @param array $withCount
     * @param array $order
     * @param null $limit
     * @param array $whereIn
     * @param array $orWhere
     * @param array $select
     * @param array $groupBy
     * @param array $whereNotIn
     * @return mixed
     */
    public function findAllData(
        $where = [], $with = [], $withCount = [], $order = [], $limit = null, $whereIn = [], $orWhere = [],
        $select = [],
        $groupBy = [], $whereNotIn = []
    ) {
        $static = $this->allQuery($where, $with, $withCount, $order, $limit, $whereIn, $orWhere, $select, $groupBy,
            $whereNotIn);

        return $static->get();
    }

    /**
     * @param array $where
     * @param array $with
     * @param array $withCount
     * @param array $order
     * @param null $limit
     * @param array $whereIn
     * @param array $orWhere
     * @param int $paginate
     * @param array $select
     * @param array $groupBy
     * @param array $whereNotIn
     * @return mixed
     */
    public function findPaginateData(
        $where = [], $with = [], $withCount = [], $order = [], $limit = null, $whereIn = [], $orWhere = [],
        $paginate = 10,
        $select = [], $groupBy = [], $whereNotIn = []
    ) {
        ;
        $static = $this->allQuery($where, $with, $withCount, $order, $limit, $whereIn, $orWhere, $select, $groupBy,
            $whereNotIn);

        return $static->paginate($paginate);
    }

    /**
     * Create model record
     *
     * @param array $params
     * @return Model
     */
    public function createData($params = [])
    {
        $query = $this->model->newQuery();

        return $query->create($params);
    }


    /**
     * Update model record for given id
     *
     * @param array $where
     * @param $params
     * @return Builder|Builder[]|Collection|Model
     */
    public function updateData($params, $where = [])
    {
        $query = $this->model->newQuery();

        $query->where($where)
            ->update($params);

        return $this->findData($where);
    }

    /**
     * @param array $where
     * @return bool|mixed|null
     */
    public function deleteData($where = [])
    {
        $query = $this->model->newQuery();

        return $query->where($where)
            ->delete();
    }

    /**
     * @param $where
     * @param $with
     * @param $withCount
     * @param $order
     * @param $limit
     * @param $whereIn
     * @param $orWhere
     * @param $select
     * @param $groupBy
     * @param $whereNotIn
     * @return mixed
     */
    public function allQuery(
        $where = [], $with = [], $withCount = [], $order = [], $limit = null, $whereIn = [], $orWhere = [],
        $select = [], $groupBy = [], $whereNotIn = []
    ) {

        $static = $this->model->newQuery();

        if (count($where) > 0) {
            $static = $static->where($where);
        }

        if (count($select) > 0) {
            $static = $static->select($select);
        }

        if (count($with) > 0) {
            $static = $static->with($with);
        }

        if (count($withCount) > 0) {
            $static = $static->withCount($withCount);
        }

        if (count($order) > 0) {
            foreach ($order as $orders) {
                $static = $static->orderBy($orders['key'], $orders['value']);
            }
        }

        if ($limit !== null) {
            $static = $static->limit($limit);
        }

        if (count($whereIn) > 0) {
            foreach ($whereIn as $whereIns) {
                $static = $static->whereIn($whereIns['key'], $whereIns['value']);
            }
        }
        if (count($orWhere) > 0) {
            $static = $static->orWhere($orWhere);
        }

        if (count($groupBy) > 0) {
            $static = $static->groupBy($groupBy);
        }

        if (count($whereNotIn) > 0) {
            foreach ($whereNotIn as $whereNotIns) {
                $static = $static->whereNotIn($whereNotIns['key'], $whereNotIns['value']);
            }
        }

        return $static;
    }
}
