<?php

namespace App\Services\Notification\Push;

use App\Services\Notification\Push\BasePush;
use JMS\Serializer\SerializationContext;
use App\Entity\M\User\Notification;
use App\Entity\M\User\MobileDevice;

/**
 * Notificaciones instantaneas para IOS por google
 * Firebase
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class FCMForIOS extends BasePush {

    public function send(Notification $notification, array $ids, $topic = null) {
        $serializationContext = SerializationContext::create();
        $serializationContext->setGroups(
                [
                    'b.id',
                    'un.push',
        ]);
        $data = null;
        if ($topic !== null || count($ids) > 0) {
            $data = $this->serialzer->serialize($notification, 'json', $serializationContext);
        }
        if ($topic !== null) {
            $fields = array(
                'to' => '/topics/' . $topic,
                'data' => ['notification' => $data],
            );
        } else if (count($ids) > 0) {
            $fields = array(
                'registration_ids' => $ids,
                "time_to_live" => 600,
            );
            $fields["notification"] = [
//                "category" => "recharge",
                "body" => $notification->getContent(),
                "title" => $notification->getTitle(),
                "badge" => 0,
                "priority" => "high",
//                "content_available" => true,
            ];
            $sound = $notification->getExtraData("sound",null);
            if (!empty($sound)) {
                $fields["notification"]["sound"] = $sound;
            }
        } else {
            $this->looger->info("GoogleCloudMessaging for iOS: No hay destinatarios para enviar el mensaje.");
            return;
        }

        $fields["data"] = [
            "data_detail" => $data,
        ];
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
        return MobileDevice::TYPE_IOS;
    }

}
