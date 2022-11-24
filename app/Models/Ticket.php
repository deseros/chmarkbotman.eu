<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use App\Models\TicketReplies;
use App\Http\Controllers\General\Filters\QueryFilter;
use EloquentFilter\Filterable;
use App\Models\Client;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
      'subject',
      'description',
      'provider_id',
      'assign_to',
  ];


    public function find_client($id)
    {
      return Client::find($id);

    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tags', 'taggable');
      }

      public function assignee()
      {
          return $this->belongsTo(User::class, 'assigned_to');
      }
      public function files(){
        return $this->morphToMany('App\Models\File', 'files_model');
      }
      public function user($id){

       return User::find($id);

    }
    public function provider($id){
        $user = new User();
        $provider = Ticket::find($id)->provider_id;
        $client = Client::find($user->find_clients($provider)->pivot)->first()->name_client;
        return $client;
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

//public function scopeFilter(Builder $builder, QueryFilter $filter)
//{
  //  $filter->apply($builder);
//}


}
