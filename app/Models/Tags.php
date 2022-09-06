<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    

    protected $table = 'tags';
    public $timestamps = false;
    
    protected $fillable = [
        'name_tags',
        'type_tags',
        'notif_text',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function ticket(){
      return $this->morphedByMany(Ticket::class, 'taggable');
    }
}
