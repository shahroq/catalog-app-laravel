<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;

    protected $includables = [];

    protected $sortables = ['id', 'created_at'];

    protected $defaultOrderBy = 'id';

    public function __construct(protected Request $request) {}

    public function filter($arr)
    {
        foreach ($arr as $key => $value) {
            method_exists($this, $key) && $this->$key($value);
        }
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        // dump($this->request->all());
        foreach ($this->request->all() as $key => $value) {
            method_exists($this, $key) && $this->$key($value);
        }

        return $builder;
    }

    public function sort(?string $value = null)
    {
        $value = $value ?: $this->defaultOrderBy;
        $fields = explode(',', $value);

        foreach ($fields as $field) {
            $direction = str_starts_with($field, '-') ? 'desc' : 'asc';
            $column = ltrim($field, '-');

            if (! in_array($column, $this->sortables, true)) {
                continue;
            }

            $this->builder->orderBy($column, $direction);
        }
    }

    protected function validateIncludes(string $value): array
    {
        $relations = explode(',', $value);

        return array_filter($relations, fn ($rel) => in_array($rel, $this->includables));

        // or throw error if not valid relations are provided?
    }
}
