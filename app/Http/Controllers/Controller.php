<?php

namespace App\Http\Controllers;

use App\Concerns\ApiResponse;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Controller
{
    // use ApiResponse;

    protected function paginationMeta(LengthAwarePaginator $items)
    {
        return [
            'page_number' => $items->currentPage(),
            'page_size' => $items->perPage(),
            'total_pages' => $items->lastPage(),
            'total_count' => $items->total(),
            'has_prev_page' => $items->currentPage() > 1,
            'has_next_page' => $items->hasMorePages(),
        ];
    }

    protected function perPage(): int
    {
        $model = new $this->model;

        $default = $model->getPerPage();
        $max = defined("$this->model::MAX_PER_PAGE") ? $this->model::MAX_PER_PAGE : 100;

        $perPage = request()->integer('per_page', $default);

        return min($perPage, $max);
    }
}
