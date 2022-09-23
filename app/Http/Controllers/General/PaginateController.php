<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateController extends Controller
{
    /**
  *
  *
  * @param array|Collection      $items
  * @param int   $perPage
  * @param int  $page
  * @param array $options
  *
  * @return LengthAwarePaginator
  */
public function paginate($items, $perPage, $page = null, $options = [])
{
	$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

	$items = $items instanceof Collection ? $items : Collection::make($items);

	return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}
}
