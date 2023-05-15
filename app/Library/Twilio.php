<?php

namespace App\Library;

use Twilio\Rest\Client;

class Twilio
{
   //
    protected static $sid = "AC0b25fdd8c0a88fd3a9d274db612bfb8f";
    protected static $auth_token = "6b35932a458ef08dcf86f910cddacec0";
    protected static $from = "+14842638179";
    protected static $bearer_token = "QUMwYjI1ZmRkOGMwYTg4ZmQzYTlkMjc0ZGI2MTJiZmI4Zjo2YjM1OTMyYTQ1OGVmMDhkY2Y4NmY5MTBjZGRhY2VjMA==";

    public function __construct()
    {
        //$this->sid = env("TWILIO_ACCOUNT_SID");
        //$this->auth_token = env("TWILIO_AUTH_TOKEN");
    }

    public static function createTwilioObj()
    {
        $sid = env("TWILIO_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilioObj = new Client($sid, $token);
        return $twilioObj;
    }

    public static function sendMessage($messageData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        $twilioObj = self::createTwilioObj();

        try {
            $message = $twilioObj->messages
                ->create($messageData['to'], // to
                    ["body" => $messageData['message'], "from" => self::$from]
                );


            $message = $message->toArray();

            $response['data'] = $message;
            $response['success'] = TRUE;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public static function sendMessageCurl($messageData = [])
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $curl = curl_init();

            $url = "https://api.twilio.com/2010-04-01/Accounts/" . env("TWILIO_SID") . "/Messages.json";

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => "Body=" . $messageData['message'] . "&From=" . env("TWILIO_NUMBER") . "&To=" . $messageData['to'],
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . env("TWILIO_AUTH_TOKEN"),
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $twilioResponse = curl_exec($curl);

            curl_close($curl);

            $twilioResponse = json_decode($twilioResponse, TRUE);

            $response['data'] = $twilioResponse;
            $response['success'] = TRUE;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $response;
    }
}

?>
