<?php

namespace App\Tests\Services\Core\Sms;

use App\Tests\BaseTestCase;

/**
 * Test de sms
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class SmsServiceTest extends BaseTestCase
{
    /**
     * Test envio de mensajes
     *  
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @return Assert
     */
    public function testSend()
    {
        $smsService = $this->getContainer()->get("maximosojo_tools.notifier.texter_manager");
        // $response = $smsService->send("4243376377","Texto de prueba");
        
        $this->assertTrue($response);
    }
}
