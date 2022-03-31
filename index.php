<?php
/////**@Cheksizlik**\\\\\
//Xvest\\
//●●●●2019-yil●●●●//
$token = "1958377342:AAEFm3uVHvabDKSHEz3w_M3MomabsmAaKxo";
$admin = "5177196243";   
$botim = "Kirdi_chiqdi_gr_robot";   ///////*@*Belgisini yozmang
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".$token."/".$method;
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
$message = $update->message;
$chat_id = $message->chat->id;
$mid = $message->message_id;
$cid = $message->chat->id;
$uid= $message->from->id;
$ty = $message->chat->type;
$title = $message->chat->title;

/// Botni ishlayotganini tekshirish uchun /////
if($tx == "bot"){
	if($tx = $admin){
bot('deleteMessage',[
'chat_id'=>$message->chat->id,
'text'=>"On Bot",
]);
}
}
if($tx == "Admin" or $tx == "admin"){
	bot('replyMessage',[
'chat_id'=>$message->chat->id,
'text'=>"👨🏻‍💻Creator: @Telba_554",
]);
}

if(isset($message->new_chat_member) or isset($message->left_chat_member)){
    bot('deleteMessage',[
        'chat_id'=>$message->chat->id,
        'message_id'=>$message->message_id,
    ]);
}
///////Lichkaga start uchun
if($tx=="/start"){
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"Bu bot gruppangizni kirdi-chiqdilarini tozalaydi!
📢Channel: @Adabiyot_va_ona_tili",
'parse_mode'=>"markdown",
'reply_markup' => json_encode([
                'inline_keyboard'=>[
                   [['text'=>"➕ Gruppaga Qoʻshish➕",'url'=>'t.me/$botim?startgroup=new'],
]
]
])
]);
}


/// Gruppaga start
if($ty=="supergroup" or $ty == "group"){
if(strpos($tx == "/start" or $tx=="/start@$botim" ) !==false){
 $cr=bot('getchatmember',[
	'chat_id'=>$cid,
	'user_id'=>$uid
	]);
$cr = $cr->result->status;
if($cr=="creator"or $cr=="administrator"){    
$yes = file_get_contents("data/gruppalar.dat");
if($yes){
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"Bu bot $title gruppasida qayta ishga tushirildi!",
'parse_mode'=>"markdown"
]);

}else{

bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"Bu bot $title gruppasida qayta ishga tushirildi!",
'parse_mode'=>"markdown"
]);
file_put_contents("data/gruppalar.dat","ok");
}
}
}
}







//●●●●●●●●} Members and Group {●●●●●●●●//  
//●●●●●●●●} Statika {●●●●●●●●//  


       $baza = file_get_contents("data/gruppalar.dat"); 
if(mb_stripos($baza, $chat_id) !== false){ 
}else{ 
file_put_contents("data/gruppalar.dat", "$baza\n$chat_id");
} 


 if($callback_data == 'stat') {
     $kun = date('d.m.Y | H:i:s', strtotime('5 hour'));
$baza = file_get_contents("data/gruppalar.dat"); 
$baza1 = substr_count($baza,"\n"); 
$gruppa = substr_count($baza,"-"); 
$odam = $baza1 - $gruppa; 
            
        $text = "Bot foydalanuvchilari: \n 
   🌎Hammasi: $baza1
   👤Foydalanuvchilar: $odam
   👥Gruppada: $gruppa

📆 So'nggi yangilanish: $kun";
                  $res = ('editmessagetext', [
            'chat_id' => $chat_id,
            'message_id' => $mid,
            'text' => $text,
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
       [ ['text' => '♻Yangilash♻', 'callback_data' => "stat"] ],
       [ ['text' => '📢Channel', 'url' => 'https://t.me/Adabiyot_va_ona_tili'] ]
                   
                ]
            ])
        ]);
    }


if($mtext == "/Stat" or $mtext == "/stat"){ 
$baza = file_get_contents("data/gruppalar.dat"); 
$baza1 = substr_count($baza,"\n"); 
$gruppa = substr_count($baza,"-"); 
$odam = $baza1 - $gruppa; 

     ('sendMessage',[ 
     'chat_id'=>$chat_id, 
     'text'=>"Bot foydalanuvchilari: \n 
   🌎Hammasi: $baza1
   👤Foydalanuvchilar: $odam
   👥Gruppada: $gruppa

📆 So'nggi yangilanish: $kun",
     'parse_mode'=>'markdown', 
  'reply_markup'=>json_encode([   
   'inline_keyboard'=>[   
        [['text'=>'♻Yangilash♻', 'callback_data' => "/Stat"]],
        
[['text'=>'👨🏻‍💻Creator','url'=>'https://t.me/Telba_554']]
]   
])   
]); 
} 
