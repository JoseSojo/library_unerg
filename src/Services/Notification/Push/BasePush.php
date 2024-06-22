<?php

namespace App\Services\Notification\Push;

use App\Services\Notification\PushNotificationInterface;

/**
 * Base de notificaciones push
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BasePush implements PushNotificationInterface
{
    const GOOGLE_API_KEY = "AAAARJxK70A:APA91bGxC13rrGFni04g7Jc28Pu4538h3ZLjxhoPJuXXNQXxBhlVCDUm5ehFp_aecnQLPLIwKgGvNPyRMVlFk0P-doGn2Hknd8L_3QkALagS0gicU_-vYDq6rEWUzcJAbzkKucYRkPAU";
    
    const URL = "https://fcm.googleapis.com/fcm/send";
    
    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $lastResponse;
    
    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $looger;
    
    /**
     * @var \JMS\Serializer\Serializer
     */
    protected $serialzer;

    protected function sendPost($url,array $options) {
        $result = false;
        try {
            $this->lastResponse = $this->request("POST",$url,$options);
            if($this->lastResponse->getStatusCode() !== 200){
                $this->looger->critical(get_class($this),[
                    $this->lastResponse->getReasonPhrase(),
                    (string)$this->lastResponse,
                ]);
            }else{
                $result = (string)$this->lastResponse->getBody();
                $this->looger->debug("push.sendPost: ",[
                    "result" => $result,
                    "options" => $options,
                ]);
            }
        } catch (\Exception $ex) {
            $this->looger->critical($ex->getMessage(), $ex->getTrace());
//            throw $ex;
        }
        return $result;
    }
    /**
     * @return \GuzzleHttp\Client
     */
    protected function request($method, $uri = '', array $options = []) {
        $client = new \GuzzleHttp\Client();
        //$options["connect_timeout"] = 3.00;
        $timeout = 6;
        if(\Tecnoready\Common\Util\AppUtil::isCommandLineInterface()){
            $timeout = 10;
        }
        $this->looger->info("push.request: ".$uri,$options);
        $options["connect_timeout"] = $timeout;
        $response = $client->request($method,$uri,$options);
        return $response;
    }
    
    public function setLooger(\Symfony\Bridge\Monolog\Logger $looger)
    {
        $this->looger = $looger;
        return $this;
    }
    
    public function setSerialzer(\JMS\Serializer\Serializer $serialzer)
    {
        $this->serialzer = $serialzer;
        return $this;
    }
}
