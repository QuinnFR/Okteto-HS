<?php

error_reporting(0);
define('API_KEY','1958377342:AAEFm3uVHvabDKSHEz3w_M3MomabsmAaKxo');
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}
$update = json_decode(file_get_contents('php://input'));
$payam = $update->message;
$chat_id = $payam->chat->id;
$message_id = $payam->message_id;
$from_id = $payam->from->id;
$text = $payam->text;
$admin = '989174330';
mkdir("data");
$user = json_decode(file_get_contents("data/$from_id.json"),true);
$com = $user["com"];
$first_name = $payam->from->first_name;
$last_name = $payam->from->last_name;
$username = $payam->from->username;
$data = $update->callback_query->data;
$chatid = $update->callback_query->message->chat->id;
$reply = $payam->reply_to_message->forward_from->id;
$user2 = json_decode(file_get_contents("data/$chatid.json"),true);
$messageid = $update->callback_query->message->message_id;
//----------------------------------------------------------------------
if (strpos($data, "pas-") !== false) {
$id = str_replace("pas-",'',$data);
file_put_contents("data/id.txt","$id");
$user2["com"] = "ans";
file_put_contents("data/$chatid.json",json_encode($user2,true));
bot("editmessagetext", [
'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=>"ارسل رسالتك الآن",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"إلغاء","callback_data"=>"can-$id"]],
],
"resize_keyboard"=>true,'one_time_keyboard' => true,
])
]);
}
if (strpos($data, "can") !== false) {
$id = str_replace("can-",'',$data);
unlink("data/id.txt");
$user2["com"] = "none";
file_put_contents("data/$chatid.json",json_encode($user2,true));
bot("editmessagetext", [
'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=>"تم الإلغاء ✅
",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"إعادة الإرسال","callback_data"=>"pas-$id"]],
],
"resize_keyboard"=>true,'one_time_keyboard' => true,
])
]);
}
if (strpos($data, "ban") !== false) {
$id = str_replace("ban-",'',$data);
$user2["com"] = "none";
file_put_contents("data/$chatid.json",json_encode($user2,true));
$myfile2 = fopen("data/ban.txt", "a") or die("Unable to open file!");
fwrite($myfile2, "$id\n");
fclose($myfile2);
bot("editmessagetext", [
'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=>"تم الحظر ✅
",
'parse_mode'=>"markdown",
]);
}
if($text == '/start'){
$user["com"] = "sup";
file_put_contents("data/$from_id.json",json_encode($user,true));
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"أرسل رسالتك وسيتم تحويلها الى مالك البوت ✅",
'parse_mode'=>"HTML",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$back,
]);
}
if($com == 'sup'){
$sticker = $update->message->sticker;
$voice = $update->message->voice;
$photo = $update->message->photo;
$music = $update->message->audio;
$video = $update->message->video;
$file = $update->message->document;
$contact = $update->message->contact;
if(isset($stickerid) or isset($voiceid) or isset($photoid) or isset($musicid) or isset($videoid) or isset($fileid) or isset($contact)){
$msg_id = bot('ForwardMessage', [
'chat_id' => $admin,
'from_chat_id' =>$chat_id,
'message_id' => $message_id
])->result->message_id;
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"هذا المستخدم ارسل رسالة 🚶‍♂️
[$chat_id](tg://user?id=$chat_id)

الرسالة هي :
$text",
'parse_mode'=>"markdown",
'reply_to_message_id'=>$msg_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"رد على الرسالة 📬","callback_data"=>"pas-$chat_id"]],
[["text"=>"حظر المرسل 🚫","callback_data"=>"ban-$chat_id"]],
],
"resize_keyboard"=>true,'one_time_keyboard' => true,
])
]);
}else{
$user["com"] = "none";
file_put_contents("data/$from_id.json",json_encode($user,true));
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"هذا المستخدم ارسل رسالة 🚶‍♂️
[$chat_id](tg://user?id=$chat_id)

الرسالة هي : $text",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["text"=>"رد على الرسالة 📬","callback_data"=>"pas-$chat_id"]],
[["text"=>"حظر المرسل 🚫","callback_data"=>"ban-$chat_id"]],
],
"resize_keyboard"=>true,'one_time_keyboard' => true,
])
]);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"تم ارسال رسالتك الى مالك البوت 📬",
'parse_mode'=>"HTML",
'reply_to_message_id'=>$message_id,
'reply_markup'=>$or,
]); 
}
}
/*
تم التعريب بواسطة : @RSAIED

جميع قنواتنا : @SAIEDCH

ملاحظة : الملف ايراني 🌚
*/
?>
