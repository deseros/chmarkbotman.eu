<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\TicketReplies;

class File extends Model
{
    use HasFactory;

   protected $fillable =
    [
       'bx_file_id',
       'original_name',
       'file_name',
       'file_path',
       'mime',
       'extension'
    ];

    protected $table = "file_entries";

    public function ticket(){
        return $this->morphedByMany(Ticket::class, 'files_model');
      }
      public function replies(){
        return $this->morphedByMany(TicketReplies::class, 'files_model');
      }


}
