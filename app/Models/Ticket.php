<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Admin\Filters\QueryFilter;
use App\Models\TicketReplies;

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

      public function assignee()
      {
          return $this->belongsTo(User::class, 'assigned_to');
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
      
      public function scopeFilter(Builder $builder, QueryFilter $filter){
        return $filter->apply($builder);
    }
}
