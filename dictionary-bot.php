<?php

///////////Bot By Reboot13
    date_default_timezone_set("Asia/kolkata");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $message_id = $upadte["message"]["message_id"];

    //Start message
    if($message == "/start"){
        send_message($chat_id, "Hey $firstname  \nUse /dict <word>   \nDictionary Bot by @reboot13 ");
    }


if(strpos($message, "/dict") === 0){
  $dict = substr($message, 6);
  $curl = curl_init();
  curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.dictionaryapi.dev/api/v2/entries/en/$dict",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "accept: */*",
    "accept-encoding: gzip, deflate, br",
    "accept-language: en-IN,en-GB;q=0.9,en-US;q=0.8,en;q=0.7",
    "origin: https://google-dictionary.vercel.app",
    "referer: https://google-dictionary.vercel.app/",
    "sec-fetch-dest: empty",
    "sec-fetch-mode: cors",
    "sec-fetch-site: cross-site",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36"
        ],
]);


  $dictionary = curl_exec($curl);
  curl_close($curl);

$out = json_decode($dictionary, true);
$definition0 = $out[0]['meanings'][0]['definitions'][0]["definition"];
$definition1 = $out[0]['meanings'][1]['definitions'][0]["definition"];

$example = $out[0]['meanings'][0]['definitions'][0]["example"];

$Voiceurl = $out[0]["phonetics"][0]["audio"];

if ($definition0 != null) {
        send_message($chat_id,$message_id, "***
Word: $dict
meanings : 
1:$definition0
2:$definition1
Example : $example
Pronunciation : $Voiceurl
Checked By @$username ***");
    }
    else {
        send_message($chat_id,$message_id, "Invalid Input");
    }
}
    
    
//Send Messages(Global)
      function send_message($chat_id, $message){
       $apiToken = "Your Bot API Token";
        $text = urlencode($message);
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&text=$text");
    }
    
?>
