<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class SocialAuth extends Controller
{
    public function validate_telegram($auth_data){
        $check_hash = $auth_data['hash'];
  unset($auth_data['hash']);
  $data_check_arr = [];
  foreach ($auth_data as $key => $value) {
    $data_check_arr[] = $key . '=' . $value;
  }
  sort($data_check_arr);
  $data_check_string = implode("\n", $data_check_arr);
  $secret_key = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
  $hash = hash_hmac('sha256', $data_check_string, $secret_key);
  if (strcmp($hash, $check_hash) !== 0) {
    throw new \Exception('Данные НЕ из Telegram');
  }
  if ((time() - $auth_data['auth_date']) > 86400) {
    return redirect(route('login'));
  }
  return $auth_data;
    }
   public function saveTelegramUserData($auth_data) {
        $auth_data_json = json_encode($auth_data);
        setcookie('tg_user', $auth_data_json);
      }
    public function telegram_auth(Request $request){
    $profile = $this->validate_telegram($request->all());
    $this->saveTelegramUserData($profile);
     $check_user = User::where('telegram_id', '=', $profile['id'])->first();
     if($check_user){
        Auth::login($check_user);
        return redirect(route('homeAdmin'));
     }
     else{
         dd('Пользователь не найден');
     }
}

}