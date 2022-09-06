<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Admin\Filters\QueryFilter;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
      'subject',
      'description',
      'client_id',
      'assign_to',
  ];
    public function cur_client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tags', 'taggable');
      }

      public function user(){
        return $this->belongsTo('App\Models\User', 'assign_to');
      }

      public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
