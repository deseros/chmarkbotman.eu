<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientTelegramID;
use App\Models\User;
use App\Models\Ticket;
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_client',
        'bx_id_group',
        'bx_id_user',
        'channel_chat_id',
        'invait_link_channel',
        'key_license_telegram',
    ];
    protected $table = "clients";

public function users()
{
    return $this->belongsToMany(User::class, 'client_entries', 'client_id');
}
public function ticket(){
    return $this->hasMany(Ticket::class, 'client_id');
}
}
