<?php

namespace App\Helpers;

class OneSignal {

    private $appId;

    public function __construct() {
        $this->init();
    }

    private function init() {
        $this->appId = env("ONE_SIGNAL_APP_ID");
    }

    /**
     * @param $data
     * @return bool
     */
   

    public function trigger($data = array()) {
        $message = $data['message'];
        $user_id = $data['notifier_id'];
        $app_id = env("ONE_SIGNAL_APP_ID");
        $auth_key = env("ONE_SIGNAL_AUTH_KEY");
        $app_id ="4beb1622-1cff-41c5-a84a-af6b8420d79b";
        $auth_key = "ZjNhNTMzZTEtZWFkOC00MTVhLThiYmMtZDdiNDk1YjM3NWFh";

        $content = array(
            "en" => "$message"
        );

        $headings = array(
            'en' => 'APPROCKS Notification'
        );


        $fields = array(
            'app_id' => $app_id,
//              'include_player_ids' => array($user_id),
//            'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
//            'include_player_ids' => array("728c42e9-22d5-475d-af9f-4eb5a41b0b8a"),
            'included_segments' => array('All'),
//            'data' => $data,
            'contents' => $content,
//            'headings' => $headings
        );


        $fields = json_encode($fields);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            "Authorization: Basic $auth_key"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
