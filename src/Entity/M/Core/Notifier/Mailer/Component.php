<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\M\Core\Notifier\Mailer;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Core\Notifier\Mailer\ModelComponent;

/**
 * Componente de correo
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'core_notifier_mailer_component')]
class Component extends ModelComponent
{
    /**
     * @var EmailTemplate
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Template', mappedBy: 'base')]
    protected $bases;
    
    /**
     * @var EmailTemplate
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Template', mappedBy: 'header')]
    protected $headers;
    
    /**
     * @var EmailTemplate
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Template', mappedBy: 'body')]
    protected $bodys;
    
    /**
     * @var EmailTemplate
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Template', mappedBy: 'footer')]
    protected $footers;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->headers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bodys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->footers = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
