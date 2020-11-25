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
  CURLOPT_URL => "https://oxforddictionaryapi.herokuapp.com/?define=$dict&lang=en",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8,hi;q=0.7",
        "Host: oxforddictionaryapi.herokuapp.com",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: cross-site",
        ],
]);


  $dictionary = curl_exec($curl);
  curl_close($curl);

$out = json_decode($dictionary, true);
$word = $out[0]['word'];
$noun= $out[0]['meaning']['noun'][0]['definition'];
$noun1= $out[0]['meaning']['noun'][1]['definition'];
$noun2= $out[0]['meaning']['noun'][2]['definition'];
$verb = $out[0]['meaning']['verb'][0]['definition'];
$adjective = $out[0]['meaning']['adjective'][0]['definition'];
$adverb = $out[0]['meaning']['adverb'][0]['definition'];
$pronoun = $out[0]['meaning']['pronoun'][0]['definition'];

if ($word = $dict) {
        send_message($chat_id, "
Word: $word 
Noun : 
1:$noun

2:$noun1

3:$noun2
Pronoun: $pronoun 
Verb : $verb 
Adjective: $adjective 
Adverb: $adverb 
Checked By @$username ");
    }
    else {
        send_message($chat_id, "Invalid Input");
    }
}

    
    
//Send Messages(Global)
      function send_message($chat_id, $message){
       $apiToken = "Your Bot API Token";
        $text = urlencode($message);
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&text=$text");
    }
    
?>
