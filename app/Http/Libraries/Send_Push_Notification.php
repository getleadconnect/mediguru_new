<?php

namespace App\Http\Libraries;

use Session;
use Validator;

class Send_Push_Notification
{

	public function __construct()
	{
		//--- code here -----//
	}
  
    /**
     * Function to send notification to influencer
     *
     * @param mixed $token
     * @param string $title
     * @param string $message
     * @param string $click
     * @param string $page
     * @return void
     */
	 
    public function sendNotificationToInfluencer($token, $title, $message, $click = null, $page = null)
    {
        try {
            if ($token) {
                $message = array(
                    'body'     => $message,
                    'title'    => $title,
                    'icon'    => 'myicon',
                    'sound' => 'default'
                );
				
                $fields = array(
                    'to'           => $token,
                    'notification' => $message,
                    /*'data'         => [
                        "click_action" => $click,
                        "page"         => $page,
                    ]*/
                );

                $headers = array(
                    'Authorization: key=' . config('firebase-token.fcm_server_key'),
                    'Content-Type: application/json'
                );
				
                #Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);

                return $result;
            }
        } 
		catch (\Exception $e)
		{
            return $e->getMessage();
        }
	}
		
}