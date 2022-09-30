<?php

namespace App\Http\Controllers\General\Filters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class TicketFilter extends QueryFilter
{
    /**
     * @param string $status
     */
    public function tags($tags)
    {

        $this->builder->whereHas('tags', function(Builder $query) use($tags) {
            $query->where('tags.id', (int) $tags);
        });
    }

    /**
     * @param string $title
     */
    public function subject(string $title)
    {
        $words = array_filter(explode(' ', $title));

        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('subject', 'like', "%$word%");
            }
        });
       
    }
    public function client(int $client_id)
    {
        $this->builder->where('client_id', $client_id);
    }
    public function datacreate(string $type){
        $this->builder->reorder('created_at', $type);
    }
   
}
