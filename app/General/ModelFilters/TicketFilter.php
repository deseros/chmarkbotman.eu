<?php 

namespace App\General\ModelFilters;

use EloquentFilter\ModelFilter;

class TicketFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function tags($tags)
    {

        $this->related('tags', function($query) use($tags) {
            $query->whereIn('tags_id', $tags);
        });
    }

    /**
     * @param string $title
     */
    public function subject($title)
    {
        $words = array_filter(explode(' ', $title));

        $this->where(function ($query) use ($words) {
            foreach ($words as $word) {
                $query->where('subject', 'like', "%$word%");
            }
        });
       
    }
    public function client($client_id)
    {
        $this->whereIn('client_id', $client_id);
    }
    public function assign($assign)
    {
        $this->whereIn('assigned_to', $assign);
    }
  
}
