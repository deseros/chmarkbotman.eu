<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientTelegramID;

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

    public function tg_id(){
        return $this->hasMany('App\Models\ClientTelegramId', 'clients_id');
    }
}
