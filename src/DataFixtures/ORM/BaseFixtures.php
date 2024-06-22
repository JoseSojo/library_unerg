<?php

namespace App\DataFixtures\ORM;

use App\Traits\Core\TermTrait;
use App\Traits\DoctrineTrait;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class BaseFixtures extends Fixture implements OrderedFixtureInterface
{
    use DoctrineTrait;
    use TermTrait;
}
