<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 *
 * (c) www.companyname.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace App\Services\Core\Guzzle;

/**
 * Trait para bg payments
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait GuzzleClientTrait
{
    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * $guzzleClient
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  guzzleClient $guzzleClient
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setGuzzleClient(GuzzleClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
        $this->guzzleClient->initialize([
            "handler" => null,
        ]);
    }
}
