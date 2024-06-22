<?php

namespace App\Tests\Behat;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Maximosojo\ToolsBundle\Features\Context\BaseDataContext;
use App\Entity\M\User;
use App\Entity\M\User\Bookmark;
use App\Entity\M\Business\Business;

// if(class_exists("PHPUnit\Exception")){
//     $reflection = new \ReflectionClass("PHPUnit\Exception");
//     require_once dirname($reflection->getFileName()) . '/Framework/Assert/Functions.php';
// }

/**
 * Contexto que genera data para los test
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class DataContext extends BaseDataContext
{
    /**
     * @var OAuth2Context
     */
    private $oAuth2Context;

    /**
     * Initializes context.
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->container = $this->kernel->getContainer();
        $this->requestBody = [];
        $this->userClass = User::class;
    }

    public function setOAuth2Context(OAuth2Context $oAuth2Context)
    {
        $this->oAuth2Context = $oAuth2Context;
        $self = $this;
        return $this;
    }

    /**
     * Inicializa los parametros
     */
    protected function initParameters()
    {
        $self = $this;
        $this->scenarioParameters = [
            "%client_id%" => "a2713b944e243c0f38090a4a44b2c863",
            "%client_secret%" => "f090be6eeb8d1f036dd86fad6e15e156b580981b7652cf87912f71514f784197828bc0f518c6ad0ca0fca65fe7ae6553d21be5a845471ee8a13f88a79cbe2eef",
            "%password%" => "abc.12345",
            "%defaultDeviceId%" => "device_id_".\Maxtoan\Common\Util\StringUtil::getRamdomNumber(6),
            "%pin%" => "1234",
            "%countryId%" => "VE",
            "%phone%" => "4241234567",
            "%email%" => "email@example.com",
            "%categoryId%" => "pharmacy"
        ];

        $this->scenarioParameters["%lastBusinessId%"] = function() use ($self) {
            $entity = $self->findOneElement(Business::class);
            return $entity->getId();
        };

        $this->scenarioParameters["%lastBookmarkId%"] = function() use ($self) {
            $entity = $self->findOneElement(Bookmark::class);
            return $entity->getId();
        };
    }

    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    public function getDoctrine() 
    {
        if (is_null($this->container)) {
            $this->container = $this->kernel->getContainer();
        }
        return $this->container->get("doctrine");
    }
}
