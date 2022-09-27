<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TicketReplies;
use App\Http\Controllers\General\Filters\QueryFilter;

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
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tags', 'taggable');
      }

      public function assignee()
      {
          return $this->belongsTo('App\Models\User', 'assigned_to');
      }
           
 /**
  * Get all of the comments for the Ticket
  *
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  */
 public function replies()
 {
  return $this->hasMany(TicketReplies::class)->orderBy('created_at', 'desc');
  
 }
/**
 * @param Builder $builder
 * @param QueryFilter $filter
 */
public function scopeFilter(Builder $builder, QueryFilter $filter)
{
    $filter->apply($builder);
}
     
    
}
