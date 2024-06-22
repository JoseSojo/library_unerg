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

use Symfony\Component\OptionsResolver\OptionsResolver;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Exception\ServerException;

/**
 * Manejador de peticiones con guzzle para ElInmejorable
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class NativeHandler extends AbstractHandler
{
    /**
     * Ejecuta una peticion a un soap con guzzle
     * @param type $request
     * @param type $location
     * @return type
     * @throws ConnectException
     */
    public function doRequest($location, array $query = [])
    {
        $this->doInitialize();

        $method = isset($query["_method"]) ? $query["_method"] : "GET";
        unset($query["_method"]);

        $options = $this->options;

        $url = $this->host . $location;
        $client = new Client([
            "timeout" => 30,
        ]);
        $options["query"] = $query;
        if ($method == "POST") {
            unset($options["query"]);
            // $options["body"] = json_encode($query);
            $options["form_params"] = $query;
        }

        $options["headers"] = $this->headers;

        try {
            $response = $client->request($method, $url, $options);
            $body = (string) $response->getBody();
            $this->statusCode = JsonResponse::HTTP_OK;
        } catch (ConnectException $e) {
            $body = $e->getMessage();
            $this->statusCode = JsonResponse::HTTP_REQUEST_TIMEOUT;
        } catch (ServerException $e) {
            $this->statusCode = JsonResponse::HTTP_BAD_REQUEST;
            $body = $e->getMessage();
            if ($e->hasResponse()) {
                $body = (string) $e->getResponse()->getBody();
            }
        } catch (RequestException $e) {
            $this->statusCode = JsonResponse::HTTP_BAD_REQUEST;
            $body = $e->getMessage();
            if ($e->hasResponse()) {
                $body = (string) $e->getResponse()->getBody();
            }
        } catch (\Exception $e) {
            $body = $e->getMessage();
            $this->statusCode = JsonResponse::HTTP_BAD_REQUEST;
        }

        return $body;
    }
}
