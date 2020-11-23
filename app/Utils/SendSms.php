<?php

namespace App\Utils;

use Config;
use App\Models\{Message};
use Illuminate\Support\Facades\Http;

class SendSms
{
  private $message;

  public function __construct(Message $message)
  {
      $this->message = $message;
  }

  public function deliverMessage()
  {
    $username = Config::get('customvariables.sendpk_username');
    $password = Config::get('customvariables.sendpk_password');
    $mobile = '92' . substr($this->message->phone_number, 1);
    $sender = Config::get('customvariables.sendpk_sender');
    $textMessage = $this->message->description;

    $url = 'https://sendpk.com/api/sms.php?username=' . $username . '&password=' . $password . '&sender=' . $sender . '&mobile=' . $mobile . '&message=' . $textMessage;

    $response = Http::get($url);

    return $response->status() == 200 ? true : false;
  }

}
