<?php

declare(strict_types=1);

namespace App\Entity\M\OAuth2;

use Doctrine\ORM\Mapping as ORM;
use League\Bundle\OAuth2ServerBundle\Model\AbstractClient;

#[ORM\Entity]
#[ORM\Table(name: 'oauth2_client')]
class Client extends AbstractClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: 'string', length: 32)]
    protected $identifier;
}