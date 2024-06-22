<?php

namespace App\Tests\Services\Core;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
use Maximosojo\ToolsBundle\Service\Mailer\TwigSymfonyMailer;
use App\Entity\M\User;

/**
 * Servicio para enviar correo con una plantilla twig
 *
 * @author Máximo Sojo <maxojo13@gmail.com>
 */
class EmailServiceTest extends \App\Tests\BaseTestCase
{
	public function testSend()
	{
        // Prueba de template
		$user = new User();
		$user->setEmail("maxsojo13@gmail.com");
		$user->setConfirmationToken(1);
		$this->assertTrue($this->register($user));
		// $this->assertTrue($this->resetting($user));
	}

    /**
     * Prueba correo cuando se suben los requerimientos
     *
     * @param   User  $user
     * @return  
     */
    private function register(User $user)
    {
        $container = static::getContainer();

        $context = [
            "entity" => $user
        ];

        try {
            $twigSymfonyMailer = $container->get(TwigSymfonyMailer::class);
            $twigSymfonyMailer->email('security_register_1', $user->getEmail(), $context);
            return true;
        } catch (TransportExceptionInterface $e) {
			return false;
		}
    }

    /**
     * Prueba correo cuando se suben los requerimientos
     *
     * @param   User  $user
     * @return  
     */
    private function resetting(User $user)
    {
        $container = static::getContainer();

        $context = [
            "fullname" => (string)$user,
            "link" => "https://google.com",
            "nameApp" => "Prueba"
        ];

        try {
            $twigSymfonyMailer = $container->get(TwigSymfonyMailer::class);
            $twigSymfonyMailer->email('security_resetting', $user->getEmail(), $context);
            return true;
        } catch (TransportExceptionInterface $e) {
			return false;
		}
    }
}
