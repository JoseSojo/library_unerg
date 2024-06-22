<?php

namespace App\Services\User;

use App\Services\BaseService;
use Maxtoan\Common\Util\MathUtil;
use App\Entity\M\User;
use Symfony\Component\Console\Command\LockableTrait;
use App\Services\Util\AppUtil;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use PragmaRX\Google2FA\Google2FA;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use App\Entity\M\Master\User\Security\Method;
use App\AppEvents;

/**
 * Manejador de cuentas
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class UserManager extends BaseService implements \App\Services\User\UserManagerInterface
{
    use LockableTrait;
    
    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    private $session;

    /**
     * Encriptador de password
     * @var NativePasswordHasher
     */
    private $hasher;

    public function __construct(
            private \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage,
            private \FOS\UserBundle\Model\UserManagerInterface $userManagerMaster,
            private \FOS\UserBundle\Util\TokenGeneratorInterface $tokenGenerator
        )
    {}

    public function createUser()
    {
        $user = $this->userManagerMaster->createUser();
        return $user;
    }

    /**
     * Actualiza un usuario
     * @param   User  $user
     */
    public function postRegister(User $user)
    {
        $user->setEnabled(true);
        // Generar un token para la url de confirmación de email
        $this->generateConfirmationToken($user);
        // Per guardamos
        $this->doPersist($user,false);
        // Ejecuta evento pre
        $this->dispatch(AppEvents::APP_SECURITY_REGISTER_PRE_SUCCESS,$this->newGenericEvent($user));
        // Persiste registro de usuario
        $this->updateUser($user);
        // Ejecuta evento post
        $this->dispatch(AppEvents::APP_SECURITY_REGISTER_POST_SUCCESS,$this->newGenericEvent($user));
    }

    public function updateUser(User $user)
    {
        $this->userManagerMaster->updateUser($user);
    }

    /**
     * Genera token para operaciones especiales
     *
     * @param   User  $user
     */
    public function generateConfirmationToken(User $user): bool
    {
        $user->setConfirmationToken($this->tokenGenerator->generateToken());

        return true;
    }

    /**
     * Crea un bloqueo para el usuario con sesión
     * 
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   String $name
     * @param   null   $blocking
     *
     * @return  Boolean
     */
    public function createLock($name = null, $blocking = false)
    {
        return $this->lock($name,$blocking);
    }

    /**
     * Crea un bloqueo para el usuario con sesión
     * 
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   String $name
     * @param   null   $blocking
     *
     * @return  Boolean
     */
    public function createLockUser($name = null, $blocking = false)
    {
        $name = md5($this->getUser()->getId() . '-' . $name);
        return $this->lock($name,$blocking);
    }

    /**
     * Release de bloqueos
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     */
    public function releaseLock()
    {
        $this->release();
    }

    /**
     * Resuelve el usuario actual para setearlo en aprobaciones por ejemplo
     * @return type
     * @throws RuntimeException
     */
    public function getCurrentUser()
    {
        $user = $this->getUser();
        if ($user === null || AppUtil::isCommandLineInterface()) {
            $username = "command";
            $user = $this->getRepository(User::class)->findOneByUsername($username);
            if (!$user) {
                throw new \RuntimeException(sprintf("El usuario '%s' no existe. Para establecer en php-cli", $username));
            }
        }
        if (!$user) {
            throw new \RuntimeException("No se pudo resolver el usuario actual.");
        }
        return $user;
    }

    public function findUserByConfirmationToken($token)
    {
        return $this->userManagerMaster->findUserByConfirmationToken($token);
    }

    /**
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * 
     * @return NativePasswordHasher
     */
    private function getHasher()
    {
        if ($this->hasher === null) {
            $this->hasher = new NativePasswordHasher();
        }

        return $this->hasher;
    }

    /**
     * Codifica un plainPassword
     * @param User $user
     * @param type $pin
     * @return type
     */
    public function passwordHash($plainPassword)
    {
        return $this->getHasher()->hash($plainPassword);
    }

    /**
     * Verifica un plainPassword
     * @param User $user
     * @param type $pin
     * @return type
     */
    public function passwordVerify($hashedPassword, $plainPassword)
    {
        return $this->getHasher()->verify($hashedPassword,$plainPassword);
    }

    /**
     * Verifica el secreto
     * 
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   $code
     * @return  Boolean
     */
    public function twoGoogle2FAVerifyKey($code)
    {
        $user = $this->getUser();
        $google2fa = new Google2FA();
        $secret = $this->twoGoogle2FAGetSecret();
        $isValid = $google2fa->verifyKey($secret, $code, 4);
        // Añadido para pruebas y desarrollo
        if (\App\Services\Util\EnvironmentUtil::isEnvironmentProd() === false) {
            if ($code == "123456") {
                $isValid = true;
            }
        }
        // Valida codigo
        if ($isValid === true) {
            if (!$user->getExtraInfo()->getTwoFactorSecret()) {
                $user->getExtraInfo()->setTwoFactorSecret($secret);
            }
        }

        return $isValid;
    }

    /**
     * Busca el secreto
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @return  String
     */
    public function twoGoogle2FAGetSecret()
    {
        $user = $this->getUser();
        $google2fa = new Google2FA();
        $secret = $user->getExtraInfo()->getTwoFactorSecret();
        // if(!$secret){
        //     if ($this->session->get('2fa_secret')) {
        //         $secret = $this->session->get('2fa_secret');
        //     } else {
        //         $secret = $google2fa->generateSecretKey();
        //         $this->session->set('2fa_secret', $secret);
        //     }
        // }

        return $secret;
    }

    /**
     * Genera un código QR
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @return  QrCode
     */
    public function twoGoogle2FAGenerateQR()
    {
        $user = $this->getUser();
        $google2fa = new Google2FA();
        $secret = $this->twoGoogle2FAGetSecret();

        $data = [
            "secret" => $secret,
            "qrcode" => $this->generateQrCode($google2fa, $user, $secret)
        ];

        return $data;
    }

    /**
     * Genera un QR Para afiliar la Cuenta
     *
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   Google2FA  $google2FA
     * @param   User       $user
     * @param   string     $secret
     * @return  string
     */
    private function generateQrCode(Google2FA $google2FA, User $user, string $secret): string
    {
        $g2faUrl = $google2FA->getQRCodeUrl(
            "WALLET",
            $user->getUsername(),
            $secret
        );

        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($g2faUrl)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
//            ->setBackgroundColor(new Color(255, 255, 255))
                ;
//        $qrString = $writer->write($qrCode)->getDataUri();
        $qrString = base64_encode($writer->write($qrCode)->getString());
//        var_dump($qrString);die;
        return $qrString;
    }

    // /**
    //  * Registra session
    //  * 
    //  * @author Máximo Sojo <maxsojo13@gmail.com>
    //  * @param   SessionInterface  $session
    //  * @required
    //  */
    // public function setSessionInterface(SessionInterface $session)
    // {
    //     $this->session = $session;
    // }

    /**
     * Retorna los métodos validados de un usuario
     * 
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   $user
     * @param   null
     * @return  Methods
     */
    public function getUserSecurityMethods(User $entity = null)
    {
        if(is_null($entity)) {
            $entity = $this->getUser();
        }
        
        $extraInfo = $entity->getExtraInfo();

        $methods = [];
        $methods[Method::TYPE_METHOD_PASSWORD] = [
            "validated" => true,
            "title" => $this->trans("label.password"),
            "sub_title" => $this->trans("label.password"),
            "uri_action" => "/settings/security/password/update",
            "uri_icon" => \App\Controller\Controller::ICON_EDIT
        ];

        // $methods[Method::TYPE_METHOD_PHONE] = [
        //     "validated" => $extraInfo->isPhoneIsValidated(),
        //     "title" => $this->trans("label.phone"),
        //     "sub_title" => $extraInfo->isPhoneIsValidated()?$this->trans("label.validated"):$this->trans("label.unvalidated"),
        //     "uri_action" => $extraInfo->isPhoneIsValidated()?null:"/settings/security/validate/phone",
        //     "uri_icon" => \App\Controller\Controller::ICON_ACTION
        // ];

        // $methods[Method::TYPE_METHOD_EMAIL] = [
        //     "validated" => $extraInfo->isEmailIsValidated(),
        //     "title" => $this->trans("label.email"),
        //     "sub_title" => $extraInfo->isEmailIsValidated()?$this->trans("label.validated"):$this->trans("label.unvalidated"),
        //     "uri_action" => $extraInfo->isEmailIsValidated()?null:"/settings/security/validate/email",
        //     "uri_icon" => \App\Controller\Controller::ICON_ACTION
        // ];

        return $methods;
    }

    /**
     * Get a user from the Security Context
     * @return mixed
     * @throws LogicException If SecurityBundle is not available
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->tokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        return $token->getUser();
    }
}