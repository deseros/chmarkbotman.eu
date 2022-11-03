<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class TicketReplies extends Model
{
    use HasFactory;

    public function ticket()
{
    return $this->belongsTo(Ticket::class);
}
  public function files(){
   return $this->morphToMany('App\Models\File', 'files_model');
  }
}

