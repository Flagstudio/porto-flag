<?php

namespace App\Ship\Captain\Abstracts\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class Repository extends BaseRepository
{
    public function all($columns = ['*'])
    {
        $return = parent::all($columns);

        $this->resetCriteria();

        return $return;
    }

    public function count(array $where = [], $columns = '*'): int
    {
        $return = parent::count($where, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function get($columns = ['*'])
    {
        $return = parent::get($columns);

        $this->resetCriteria();

        return $return;
    }

    public function first($columns = ['*'])
    {
        $return = parent::first($columns);

        $this->resetCriteria();

        return $return;
    }

    public function firstOrNew(array $attributes = [])
    {
        $return = parent::firstOrNew($attributes);

        $this->resetCriteria();

        return $return;
    }

    public function firstOrCreate(array $attributes = [])
    {
        $return = parent::firstOrCreate($attributes);

        $this->resetCriteria();

        return $return;
    }

    public function limit($limit, $columns = ['*'])
    {
        $return = parent::limit($limit, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function paginate($limit = null, $columns = ['*'], $method = 'paginate')
    {
        $return = parent::paginate($limit, $columns, $method);

        $this->resetCriteria();

        return $return;
    }

    public function simplePaginate($limit = null, $columns = ['*'])
    {
        $return = parent::simplePaginate($limit, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function find($id, $columns = ['*'])
    {
        $return = parent::find($id, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function findByField($field, $value = null, $columns = ['*'])
    {
        $return = parent::findByField($field, $value, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        $return = parent::findWhere($where, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $return = parent::findWhereIn($field, $values, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $return = parent::findWhereNotIn($field, $values, $columns);

        $this->resetCriteria();

        return $return;
    }

    public function findWhereBetween($field, array $values, $columns = ['*'])
    {
        $return = parent::findWhereBetween($field, $values, $columns);

        $this->resetCriteria();

        return $return;
    }
}
