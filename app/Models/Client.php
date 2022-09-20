<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientTelegramID;
use App\Models\User;

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
/**
 * Get all of the comments for the Client
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function users()
{
    return $this->hasMany(User::class, 'client_id');
}
}
