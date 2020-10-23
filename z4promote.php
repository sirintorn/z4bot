<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = '+ekP3b4CEBOe6l7QXzng6LESTwP18bETOH6PS7l76ZYRxN71wYd8+N2fHZPubXY7XoIKYhEVGAFsSZubaELg1/3cl5YhtOVMV4JAcEVvrttJLezUax0eaWe6Ajqmhtq6gnx55xvrxekZIKSgOzMO3wdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'a82d4d4b0c2e5690d6be19ba0fabd1bd';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
var_export($request_array);

$jsonFlex = [
    "type": "template",
  "altText": "this is a carousel template",
  "template": {
    "type": "carousel",
    "imageSize": "contain",
    "columns": [
      {
        "thumbnailImageUrl": "https://vos.line-scdn.net/bot-designer-template-images/coupon/happy-new-year.png",
        "title": "      Promotion เดือน ตค. 63",
        "text": "   ออกรถกับพรโชคใช้เงิน 0 บาท ",
        "actions": [
          {
            "type": "message",
            "label": "กดรับโปรโมชั่น",
            "text": "Promotion"
          }
        ],
        "imageBackgroundColor": "#81DB5F"
      }
    ]
  }
  ];



if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
        error_log(json_encode($event));
        $reply_message = '';
        $reply_token = $event['replyToken'];


        $data = [
            'replyToken' => $reply_token,
            'messages' => [$jsonFlex]
        ];

        print_r($data);

        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
        
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
