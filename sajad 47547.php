<?php
/*
    CODER :  coderIQ
    Channel :  b7_78
*/
ob_start();
$API_KEY = "1958377342:AAEFm3uVHvabDKSHEz3w_M3MomabsmAaKxo";
define('API_KEY','1958377342:AAEFm3uVHvabDKSHEz3w_M3MomabsmAaKxo');
echo "https://api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME'];

define('NO', '❌');
define('YES', '✅');
define("API_KEY", $API_KEY);
#                     SAJAD                       #
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
#                     SAJAD                       #
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $message->message_id;
$reply = $message->reply_to_message;
$user = '@'.$message->from->username;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$get = json_decode(file_get_contents('data.json'),true);
if($user == null){
	$user = $message->from->first_name;
}
$userid = $message->from->id;
$GLOBALS['id'] = $chat_id;
$get = file_get_contents("https://api.telegram.org/bot$API_KEY/getChatMember?chat_id=$chat_id&user_id=".$userid);
$info = json_decode($get, true);
$you = $info['result']['status'];
#                     SAJAD                       #
function lock($media,$type = 'del'){
    $id = $GLOBALS['id'];
    $get = json_decode(file_get_contents('data.json'),true);
    if ($type == 'del') {
        $get[$id][$media]['del'] = NO;
        $get[$id][$media]['ban'] = YES;
        $get[$id][$media]['warn'] = YES;
    }
    if ($type == 'ban') {
        $get[$id][$media]['del'] = YES;
        $get[$id][$media]['ban'] = NO;
        $get[$id][$media]['warn'] = YES;
    }
    if ($type == 'warn') {
        $get[$id][$media]['del'] = YES;
        $get[$id][$media]['ban'] = YES;
        $get[$id][$media]['warn'] = NO;
    }
    file_put_contents('data.json', json_encode($get));
}
function open($media){
    $id = $GLOBALS['id'];
    $get = json_decode(file_get_contents('data.json'),true);
    $get[$id][$media]['del'] = YES;
    $get[$id][$media]['ban'] = YES;
    $get[$id][$media]['warn'] = YES;
    file_put_contents('data.json', json_encode($get));
}
function check($media){
    $id = $GLOBALS['id'];
    $get = json_decode(file_get_contents('data.json'),true);
    foreach ($get[$id][$media] as $key => $value) {
        if ($get[$id][$media][$key] == NO) {
            return $key;
        }
    }
}
#                     SAJAD                       #

if($text == '/start') {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"- هيلاو ؛  😔",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
              [['text'=>'- ?كودر ،','url'=>"https://t.me/coderIQ"]],
         ]])
    ]);
}
// بدايه القفل والفتح
if ($you == "creator" or $you == "administrator") {
    if($text == 'تفعيل الترحيب'){
    		
    	 bot('sendmessage',[
              'chat_id'=>$chat_id,                   'text'=>" • تم تفعيل الترحيب - ✅
- الترحيب الحالي : ".$get[$chat_id]['wel']
                    ]);
                    $get[$chat_id]['_wel'] = true; 	file_put_contents('data.json',json_encode($get));
    }
    if($text == 'تعطيل الترحيب'){
    		
    	 bot('sendmessage',[
              'chat_id'=>$chat_id,                   'text'=>" • تم تعطيل الترحيب - ".NO."
- الترحيب الحالي : ".$get[$chat_id]['wel']
                    ]);
                    $get[$chat_id]['_wel'] = false; 	file_put_contents('data.json',json_encode($get));
    }
    if($reply and $text == 'طرد' or $text == 'حظر'){
	bot('kickchatmember',[
		'chat_id'=>$chat_id,
		'user_id'=>$reply->from->id
	]);
	bot('sendMessage',[
		'chat_id'=>$chat_id,
		'text'=>" - العضو : @".$reply->from->username." ، ⚜
• تم حظره بنجاح - 🚫 ",
		'reply_markup'=>json_encode([
		'inline_keyboard'=>[
		[['text'=>" - الغاء حظر ⁉️ • ",'callback_data'=>"unban#".$reply->from->id ]]
		]
		])
	]);
}
if(preg_match('/unban .*/',$data)){
	$data = str_replace('unban#','',$data);
	bot('unbanchatmember',[
		'chat_id'=>$chat_id2,
		'user_id'=>$data
	]);
	bot('editmessagetext',[
		'char_id'=>$chat_id2,
		'text'=>" - العضو : $data ، ⚜
• تم الغاء حظره بنجاح - ✅ "
	]);
}
if($reply and $text == 'تثبيت'){
	bot('pinchatmessage',[
		'chat_id'=>$chat_id,
		'message_id'=>$reply->message_id
	]);
}
if($reply and $text == 'الغاء التثبيت'){
	bot('unpinchatmessage',[
		'chat_id'=>$chat_id,
		'message_id'=>$reply->message_id
	]);
}
if(preg_match('/ضع اسم .*/',$text)){
	$text = str_replace('ضع اسم ','',$text);
	bot('setchattitle',[
		'chat_id'=>$chat_id,
		'title'=>$text
	]);
}

if(preg_match('/ضع ترحيب .*/',$text)){
	 $text = str_replace('ضع ترحيب ','',$text);
	 
	 bot('sendmessage',[
	 		'chat_id'=>$chat_id,
	 		'text'=>" • تم وضع الترحيب - ✅ 
$text "
	 ]);
	 $get[$chat_id]['wel'] = $text; file_put_contents('data.json',json_encode($get));
}

    if (preg_match('/(قفل)(.*)(.*)/', $text)) {
        $text = trim(str_replace('قفل', '', $text));
        $text = explode(' ', $text);
        if (isset($text[0])) {
            if ($text[0] == 'الصور' or $text[0] == 'الفيديو' or $text[0] == 'البصمات' or $text[0] == 'الصوت' or $text[0] == 'المتحركه' or $text[0] == 'الروابط' or $text[0] == 'الجهات' or $text[0] == 'الملفات' or $text[0] == 'الماركدون' or $text[0] == 'التوجيه' or $text[0] == 'الملصقات' or $text[0] == 'المعرف' or $text[0] == 'البوتات' and $text[1] == 'بالحذف' or $text[1] == 'بالطرد' or $text[1] == 'بالتحذير'){
                switch ($text[0]) {
                    case 'الصور':$m = 'photo';break;
                    case 'الفيديو':$m = 'video';break;
                    case 'البصمات':$m = 'voice';break;
                    case 'الصوت':$m = 'audio';break;
                    case 'المتحركه':$m = 'gif';break;
                    case 'الروابط':$m = 'link';break;
                    case 'الجهات':$m = 'contact';break;
                    case 'الملفات':$m = 'doc';break;
                    case 'الماركدون':$m = 'mark';break;
                    case 'التوجيه':$m = 'fwd';break;
                    case 'الملصقات':$m = 'sticker';break;
                    case 'المعرف':$m = 'user';
                    case 'البوتات':$m='bots';
                           if($text[1] == null){
              	$text[1] = 'بالحذف';
              }
                }
                switch ($text[1]) {
                    case 'بالحذف':$t='del';break;
                    case 'بالطرد':$t='ban';break;
                    case 'بالتحذير':$t='warn';break;
                    default:
                        $t='del';
                        break;
                }
      
                lock($m,$t);
                bot('sendmessage',[
                    'chat_id'=>$chat_id,
                    'text'=>"- تم قفل ".$text[0]." • 🔒 \n خاصيه : ".$text[1]." ؛  🔱 "
                ]);
            }
        }
    }
    #                     SAJAD                       #
    if (preg_match('/(فتح)(.*)(.*)/', $text)) {
        $text = trim(str_replace('فتح', '', $text));
        $text = explode(' ', $text);
        if (isset($text[0])) {
            if ($text[0] == 'الصور' or $text[0] == 'الفيديو' or $text[0] == 'البصمات' or $text[0] == 'الصوت' or $text[0] == 'المتحركه' or $text[0] == 'الروابط' or $text[0] == 'الجهات' or $text[0] == 'الملفات' or $text[0] == 'الماركدون' or $text[0] == 'التوجيه' or $text[0] == 'الملصقات' or $text[0] == 'المعرف' or $text[0] == 'البوتات'){
                switch ($text[0]) {
                    case 'الصور':$m = 'photo';break;
                    case 'الفيديو':$m = 'video';break;
                    case 'البصمات':$m = 'voice';break;
                    case 'الصوت':$m = 'audio';break;
                    case 'المتحركه':$m = 'gif';break;
                    case 'الروابط':$m = 'link';break;
                    case 'الجهات':$m = 'contact';break;
                    case 'الملفات':$m = 'doc';break;
                    case 'الماركدون':$m = 'mark';break;
                    case 'التوجيه':$m = 'fwd';break;
                    case 'الملصقات':$m = 'sticker';break;
                    case 'المعرف':$m = 'user';break;
                    case 'البوتات':$m='bots';
                }
                open($m);
               switch(check($m)){
               	case 'del':$t='بالحذف';
               	case 'warn':$t='بالتحذير';
               	case 'ban':$t='بالطرد';
               	default:$t='بالحذف';
               } bot('sendmessage',[
                    'chat_id'=>$chat_id,
                    'text'=>"- تم فتح ".$text[0]." • 🔓 \n - خاصيه : $t ؛ 🔱 "
                ]);
            }
        }
    }
    
}
// نهايه القفل والفتح
if ($you != "creator" and $you != "administrator") {
    if($message->photo){    #                     SAJAD                       #
        if (check('photo') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('photo') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=>"• ممنوع ارسال الصور #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('photo') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->video){
        if (check('video') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('video') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال فيديو #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('video') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->contact){
        if (check('contact') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('contact') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال الجهات #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('contact') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->sticker){
        if (check('sticker') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('sticker') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال الملصقات #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('sticker') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->forward_from or $message->forward_from_chat){
        if (check('fwd') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('fwd') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال التوجيه #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('fwd') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->document){
        if (check('doc') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('doc') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال الملفات #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('doc') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if(preg_match('/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me|(.*)telesco.me|telesco.me(.*)/i',$text)){
        if (check('link') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('link') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال الروابط #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('link') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->new_chat_member->is_bot == true){
        if (check('bots') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$ $message->new_chat_member->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('bots') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع اضافه البوتات #:  ".$user." - ".NO
            ]);
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$ $message->new_chat_member->id
                ]);
        }
        if (check('bots') == 'del') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$ $message->new_chat_member->id
                ]);
        }
    }
    if($message->entities){
        if (check('mark') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('mark') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال الماركدوان #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('mark') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if(preg_match('/^(.*) | (.*)|(.*) (.*)|(.*)#(.*)|#(.*)|(.*)#/',$text)){
        if (check('user') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('user') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال المعرفات #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('user') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->voice){
        if (check('voice') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('voice') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال البصمات #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('voice') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    if($message->audio){
        if (check('audio') == 'ban') {
            bot('kickChatMember',[
                'chat_id'=>$chat_id,
                'user_id'=>$message->from->id
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('audio') == 'warn') {
            bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=> "• ممنوع ارسال الصوتيات #:  ".$user." - ".NO
            ]);
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
        if (check('audio') == 'del') {
            bot('deleteMessage',[
                'chat_id'=>$chat_id,
                'message_id'=>$message->message_id
            ]);
        }
    }
    
}
/// نهايه المسح


/// بدايه الاوامر

if($text =='الاوامر'){
	bot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>" - اليك اوامر القفل والفتح • ✨

- استخدم امر ( قفل ) للقفل •🔒،
- استخدم امر ( فتح ) للفتح •🔒؛

اليك المتوفر - ✅ :
- الصور • 📷
️
- الفيديو • 📹
️
- الملصقات • 🎆
️
- الروابط • 🔗
️
- التوجيه • 🔀
️
- الجهات • 👥
️
- المعرف • #⃣
️
-  المتحركه • 🎞
️
- الملفات  • 🗂
️
- الصوت • 🎶
️
- البصمات 🔉 ؛ 

كل الاوامر تعمل مع ( بالحذف ، بالطرد ، بالتحذير ) ؛ 🔱
مثل : قفل الروابط بالطرد 
",
		'reply_markup'=>json_encode([
		'inline_keyboard'=>[
		[['text'=>'- عرض المزيد ','callback_data'=>'more']]
		]
		])
	]);
}
if($data == 'more'){
	bot('editmessagetext',[
		'chat_id'=>$chat_id2,
		'message_id'=>$message_id,
		'text'=>' • اليك الاوامر الاضافيه ✨ ،
- هذه الاوامر متاحه للادمن والمنشئ ✅

- طرد ( بالرد ) • ⚠️
- تثبيت ( بالرد ) • 🔰
- الغاء التثبيت • ❗️
- ضع اسم + الاسم • 📜
- ضع وصف + الوصف • 🗒
- ضع ترحيب + الترحيب • ?
- (تفعيل ، تعطيل) الترحيب • 📝
- الرابط • 🔗
		'
	]);
}
if($message->new_chat_member){
if($get[$chat_id]['_wlc']==true){
	bot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>$get[$chat_id]['wlc']
	]);
}
}