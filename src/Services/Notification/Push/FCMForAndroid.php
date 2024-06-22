<?php

namespace App\Services\Notification\Push;

use App\Services\Notification\Push\BasePush;
use App\Entity\M\User\MobileDevice;
use App\Entity\M\User\Notification;
use JMS\Serializer\SerializationContext;
use Tecnoready\Common\Util\StringUtil;

/**
 * mensajes push andriod
 * Firebase
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FCMForAndroid extends BasePush
{
    public function send(Notification $notification, array $ids, $topic = null) {
        $serializationContext = SerializationContext::create();
        $serializationContext->setGroups(
        [
                    'b.id',
                    'un.push',
        ]);
        $data = null;
        if($topic !== null || count($ids) > 0){
            $data = $this->serialzer->serialize($notification, 'json', $serializationContext);
        }
        if ($topic !== null) {
            $fields = array(
                'to' => '/topics/' . $topic,
                'data' => ['notification' => $data],
            );
        }else if (count($ids) > 0) {
            $fields = array(
                'registration_ids' => $ids,
                'data' => [
                    'notification' => $data,
                    "sound" => "sound_alert.wav",
                ],
            );
        }else{
            $this->looger->info("GoogleCloudMessaging: No hay destinatarios para enviar el mensaje.");
            return;
        }
        
        $channel = $notification->getExtraData("channel","my_notification_channel");
        $sound = $notification->getExtraData("sound",null);
        $fields["notification"] = [
            "title" => $notification->getTitle(),
            "body" => StringUtil::truncate($notification->getContent(), 150),
            "android_channel_id" => $channel,
            "priority" => "high",
//            "click_action" => "OPEN_ACTIVITY_1",//Categoria para los botones
        ];
        //Android menor que 8.0
        if(!empty($sound)){
            $fields["notification"]["sound"] = $sound;
        }
//        var_dump($fields);die;
        $headers = array(
            'Authorization' => "key=" . self::GOOGLE_API_KEY,
            'Content-Type' => 'application/json'
        );
        $success = $this->sendPost(self::URL, [
                'headers' => $headers,
                'json' => $fields,
            ]);
        
        return $success;
    }
    
    public function getType() {
        return MobileDevice::TYPE_ANDROID;
    }
}
