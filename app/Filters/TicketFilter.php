<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class TicketFilter extends AbstractEloquentFilter
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }
    public function apply(Builder $builder) : Builder
    {
        return $builder->where('tags_id', 'like', "{＄this->status}%");
    }
}
