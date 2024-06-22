<?php

namespace App\Tests\Behat;

use Maximosojo\ToolsBundle\Features\Context\BaseOAuth2Context;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;
use App\Entity\M\User\Transaction;
// use App\Entity\M\User\Requirement;

/**
 * Context para probar la api con oauth2
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class OAuth2Context extends BaseOAuth2Context
{
    /**
     * Initializes context.
     */
    public function __construct(FileLocator $fileLocator)
    {
        // Initialize your context here
        parent::__construct($fileLocator);
        $this->parameters = [
            "token_url" => "/token",
            "oauth2" => [
                "client_id" => "a2713b944e243c0f38090a4a44b2c863",
                "client_secret" => "f090be6eeb8d1f036dd86fad6e15e156b580981b7652cf87912f71514f784197828bc0f518c6ad0ca0fca65fe7ae6553d21be5a845471ee8a13f88a79cbe2eef",
                "username" => "test@example.com",
                "password" => "abc.12345",
            ],
            "recommended" => [
                "expires_in" => true,
            ],
            "optional" => [
                "refresh_token" => true,
                "error_description" => true,
                "scope" => true,
            ]
        ];
        $this->accessTokenClass = \League\Bundle\OAuth2ServerBundle\Entity\AccessToken::class;
    }

    /** @BeforeScenario */
    public function gatherContexts(\Behat\Behat\Hook\Scope\BeforeScenarioScope $scope)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        $environment = $scope->getEnvironment();
        $this->setDataContext($environment->getContext(DataContext::class));
    }

    /**
     * Registra un usuario
     * @Given a global client with :email
     * @Given a global client with :email and :password
     */
    public function aGlobalClientWith($email, $password=null)
    {
        $this->dataContext->iDeleteUserForTest($email);

        if($password === null){
            $password = $this->dataContext->getPassword($email);
            $this->dataContext->setScenarioParameter("%password%", $password);
        }

        echo "Email: ".$email." Password: ".$password;

        $parameters = [
            "form_security_registration" => [
                "firstname" => "Nombre",
                "lastname" => "Apellido",
                "email" => $email,
                "country" => $this->dataContext->getScenarioParameter("%countryId%"),
                // "phone" => "4240000001",
                "plainPassword" => $password
            ]
        ];

        $this->iRequest("POST /api/register.json", $parameters);
        $this->theResponseStatusCodeIs("200");
    }

    /**
     * Se loguea con un usuario en la api
     * @Given I am logged in api as :username
     */
    public function iAmLoggedInApiAs($username, $usePassword = null)
    {
        $this->dataContext->flush();
        $this->iCreateOAuth2Request();
        if ($usePassword !== null) {
            $password = $usePassword;
        } else {
            $password = $this->dataContext->getPassword($username);
        }

        $this->dataContext->setRequestBody("grant_type", "password");
        $this->dataContext->setRequestBody("username", $username);
        $this->dataContext->setRequestBody("password", $password);

        $this->iMakeAAccessTokenRequest();
        if ($usePassword === null) {
            $this->theResponseStatusCodeIs("200");
        }
        
        if ((string) $this->response->getStatusCode() === "200") {
            $token = $this->getPropertyValue("access_token");
            $this->dataContext->getClient()->setServerParameter("HTTP_AUTHORIZATION", sprintf("Bearer %s", $token));
            $user = $this->dataContext->findUser($username);
            $user->setPlainPassword($password);
            $this->dataContext->setCurrentUser($user);
            
            $this->dataContext->flush();
            $qb = $this->dataContext->findQueryBuilder(\App\Entity\M\OAuth\AccessToken::class,"at");
            $qb
                ->andWhere("at.token = :token")
                ->setParameter("token",$token)
                ;
            $t = $qb->getQuery()->getOneOrNullResult();
            // assertNotNull($t,  sprintf("El token de acceso '%s' no existe en la base de datos.",$token));
        }
    }

    /**
     * Valida el usuario logueado
     * Ejemplo: And I added 200.00 to "available" balance
     * @Given I validate user
     * @Given I validate user with username :username
     */
    public function iValidateUser($username = null)
    {
        $user = null;
        if ($username === null) {
            $user = $this->dataContext->getCurrentUser();
        }

        if (is_null($user)) {
            throw new Exception("Método de busqueda por nombre de usuario no soportado o no presenta usuario logueado.");
        }

        $em = $this->getDoctrine()->getManager();
        $requirementManager = $this->getContainer()->get("App\Service\User\RequirementManager");
        foreach ($user->getRequirements() as $requirement) {
            $requirement->setStatus(Requirement::STATUS_IN_PROGRESS);
            $requirementManager->validated($requirement);    
            $em->flush();
        }
    }

    /**
     * Prepara un archivo y lo añade a un parametro para ser enviado por POST
     * @Given a file locate :filepath name :nameParameter
     */
    public function aFileName($filepath, $nameParameter)
    {
        $filename = $this->fileLocator->locate(__DIR__."/../../".$filepath);
        $file = new \Symfony\Component\HttpFoundation\File\File($filename);
        if (!$file->isFile() || !$file->isReadable()) {
            throw new Exception(sprintf("The file '%s' is not exist or is not readable", $filename));
        }
        $tmpFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file->getBasename();
        $fs = new \Symfony\Component\Filesystem\Filesystem();
        $fs->copy($filename, $tmpFile);
        if (!$fs->exists($tmpFile)) {
            throw new Exception(sprintf("The tmp file '%s' is not exist", $tmpFile));
        }

        $file = new UploadedFile(
                $tmpFile, $file->getFilename(), $file->getMimeType(), $file->getSize()
        );
        $this->dataContext->setScenarioParameter($nameParameter, $file);
    }

    /**
     * Agrega un dispositivo
     * @Given a mobile device default
     * @Given a mobile device with data :parameter
     */
    public function aMobileDeviceWithData($parameter = "%defaultDeviceId%")
    {
        $deviceId = $this->dataContext->getScenarioParameter($parameter);
        $this->dataContext->initRequestBody([
            "form_user_mobile_device" => [
                "type" => "android",
                "deviceId" => $deviceId,
                "osVersion" => 1,
                "model" => 1,
                "deviceInfo" => "android",
                "registerId" => "android",
                "dataRegister" => "android",
                "appVersion" => 1
            ],
        ]);
        $this->iRequest("POST /api/user/mobile-device/register.json");
        $this->theResponseStatusCodeIs("200");
    }
}
