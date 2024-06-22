<?php

namespace App\Model\Base;


/**
 * Modelo de plataformas extenernas integradas
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelExternalPlatform
{
    /**
     * Origen plataforma web
     */
    const SOURCE_PLATFORM_WEB = "web_client";

    /**
     * Origen plataforma app
     */
    const SOURCE_PLATFORM_APP = "app_client";

    /**
     * Plataforma CompanyName
     */
    const EXTERNAL_PLATFORM_MAIN = "main";
}
