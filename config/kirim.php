<?php 
    
    function send($registration_ids, $message) {
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => array('data' => $message)
        );
        return sendPushNotification($fields);
    }
    
    function sendPushNotification($fields) {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
    
        $headers = array(
            'Authorization: key=AAAA1266BDE:APA91bFHEeqW6nEjoXA22V_ThEJP3noAS5s5rUNBdcacBB3NV8Hd5utDWfL1JbWSbK6Eaik56ZdV2R2eJ-VdYX2-lwGlWFl5PI-BdZkyXn-yFa5XoWbsq2M3sVYiMCYDOXbVlCkbI4aY',
            'Content-Type: application/json'
        );
     
        $ch = curl_init();
     
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING,  '');
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        curl_close($ch);
 
        return $result;
    }
    
?>
