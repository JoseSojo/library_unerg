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
use App\Model\Core\Notifier\Mailer\ModelTemplate;
use Maximosojo\ToolsBundle\Interfaces\Mailer\TemplateInterface;

/**
 * Plantilla de correo electronico
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'core_notifier_mailer_template')]
class Template extends ModelTemplate implements TemplateInterface
{
    /**
     * @var Component
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Component', inversedBy: 'bases')]
    #[ORM\JoinColumn(nullable: false)]
    protected $base;
    /**
     * @var Component
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Component', inversedBy: 'headers')]
    #[ORM\JoinColumn(nullable: false)]
    protected $header;
    /**
     * @var Component
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Component', cascade: ['persist'], inversedBy: 'bodys')]
    #[ORM\JoinColumn(nullable: false)]
    protected $body;
    /**
     * @var Component
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Core\Notifier\Mailer\Component', inversedBy: 'footers')]
    #[ORM\JoinColumn(nullable: false)]
    protected $footer;
    
}
