<?php

namespace App\Services\Notification;

use RuntimeException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Services\Notification\PushNotificationInterface;
use App\Entity\M\User;
use App\Entity\M\User\Notification;
use App\Services\Notification\Push\BasePush;
use App\Services\Notification\Push\FCMForAndroid;
use App\Services\Notification\Push\FCMForIOS;
use App\Services\BaseService;

/**
 * Administrador de notificaciones
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class NotificationManager extends BaseService
{
    private $pushers = [];
    private $options;

    // public function __construct(LoggerInterface $logger, SerializerInterface $serializer, array $options = [])
    // {
    //     $resolver = new OptionsResolver();
    //     $resolver->setDefaults([
    //         "disable_delivery" => false,
    //     ]);
    //     $options = $resolver->resolve($options);
    //     $this->options = $options;

    //     $this->addPusher(new FCMForAndroid());
    //     $this->addPusher(new FCMForIOS());
    // }

    /**
     * Envia una notificacion
     * @param int $type Notification::TYPE_*
     * @param type $title Titulo
     * @param type $source entidad origen
     * @param User $user
     * @return Notification
     */
    public function send($users, array $options = array())
    {
        if (!is_array($users)) {
            $users = [$users];
        }

        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'title' => "",
            'content' => "",
            'extraData' => []
        ]);

        $resolver->setRequired(["source"]);

        $options = $resolver->resolve($options);

        $notifications = [];
        foreach ($users as $user) {
            if(false){
                $user = new User();
            }
            $notification = new Notification();
            $notification->setTitle($options["title"]);
            $notification->setContent($options["content"]);
            $notification->setSource($options["source"]);
            foreach ($options["extraData"] as $key => $value) {
                $notification->setExtraData($key, $value);
            }

            $notification->setUser($user);
            $notifications[] = $notification;

            $this->doPersist($notification,false);
        }

        $this->sendNotification($notifications);

        return $notifications;
    }

    /**
     * Envia un mensaje a un usuario
     * @param User $user
     * @param Notification $notification
     */
    private function sendNotification($notifications)
    {
        return;
        if ($this->options["disable_delivery"] === true) {
            $this->looger->warning("The notifications push is disable delivery");
        }

        $em = $this->getEntityManager();
        $notifications = (array) $notifications;
        $notificationsFinal = [];

        $ids = [];
        $mobileDevicesByTypes = [];
        foreach ($notifications as $notification) {
            $user = $notification->getUser();
            foreach ($user->getMobileDevices() as $mobileDevice) {
                if (!isset($mobileDevicesByTypes[$mobileDevice->getType()])) {
                    $mobileDevicesByTypes[$mobileDevice->getType()] = [];
                    $ids[$mobileDevice->getType()] = [];
                    $notificationsFinal[$mobileDevice->getType()] = [];
                }
                if (empty($mobileDevice->getRegisterId()) || in_array($mobileDevice->getRegisterId(), $ids[$mobileDevice->getType()])) {
                    continue;
                }
                $ids[$mobileDevice->getType()][] = $mobileDevice->getRegisterId();
                $mobileDevicesByTypes[$mobileDevice->getType()][] = $mobileDevice;
                $notificationsFinal[$mobileDevice->getType()][] = $notification;
            }
        }

        foreach ($mobileDevicesByTypes as $type => $mobileDevices) {
            $pushers = $this->getPushers($type);
            if ($pushers !== null && is_array($pushers)) {
                foreach ($pushers as $pusher) {
                    if ($this->options["disable_delivery"] === false) {
                        //De la notificacion solo se muestra el texto
                        $response = $pusher->send($notification, $ids[$type]);
                        if (is_string($response)) {
                            $response = json_decode($response, true);
                            $results = $response["results"];
                            for ($i = 0; $i < count($results); $i++) {
                                $result = $results[$i];
                                $notification = $notificationsFinal[$type][$i];
                                if (!empty($result["error"])) {
                                    $error = $result["error"];
                                    $notification->setSendStatus(Notification::SEND_STATUS_ERROR);
                                    $notification->setExtraData(Notification::EXTRA_ERROR_FIELD, $error);
                                    if ($error === "NotRegistered") {
                                        $mobileDevicesByTypes[$type][$i]->setRegisterId(null);
                                        $em->persist($mobileDevicesByTypes[$type][$i]);
                                    } else if ($error === "InvalidRegistration") {
                                        $mobileDevicesByTypes[$type][$i]->setRegisterId(null);
                                        $em->persist($mobileDevicesByTypes[$type][$i]);
                                    }
                                } else {
                                    $notification->setSendStatus(Notification::SEND_STATUS_SEND);
                                    $notification->setExtraData(Notification::EXTRA_MESSAGE, $result["message_id"]);
                                    $user = $notification->getUser();
                                    $user->setHasNotification(true);
                                    $em->persist($user);
                                }
                                $em->persist($notification);
                            }
                        } else {
                            foreach ($notificationsFinal[$type] as $notification) {
                                $notification->setSendStatus(Notification::SEND_STATUS_ERROR);
                                $notification->setExtraData(Notification::EXTRA_ERROR_FIELD, "Error enviando a google.");
                                $em->persist($notification);
                            }
                        }
                    } else {
                        foreach ($notificationsFinal[$type] as $notification) {
                            $notification->setSendStatus(Notification::SEND_STATUS_SEND);
                            $notification->setExtraData(Notification::EXTRA_MESSAGE, "Simulando envio.");
                            $user = $notification->getUser();
                            $user->setHasNotification(true);
                            $em->persist($user);
                            $em->persist($notification);
                        }
                    }
                }
                $em->flush();
            }
        }
    }

    /**
     * @param type $type
     * @return PushNotificationInterface
     */
    public function getPushers($type)
    {
        $pushers = null;
        if (isset($this->pushers[$type])) {
            $pushers = $this->pushers[$type];
        }
        return $pushers;
    }

    /**
     * Agrega un pusher
     * @param PushNotificationInterface $pushers
     * @return NotificationManager
     * @throws RuntimeException
     */
    public function addPusher(BasePush $pushers)
    {
        if (empty($pushers->getType())) {
            throw new RuntimeException(sprintf("The pusher type '%s' is invalid.", $pushers->getType()));
        }
        if (!isset($this->pushers[$pushers->getType()])) {
            $this->pushers[$pushers->getType()] = [];
        }
        $pushers->setLooger($this->looger);
        $pushers->setSerialzer($this->serialzer);
        $this->pushers[$pushers->getType()][] = $pushers;
        return $this;
    }
}