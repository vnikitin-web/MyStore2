<?php

namespace MyStore2\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Request
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function putEntity(string $entity, string $entity_id, array $data)
    {
        try{
            $response = $this->client->request(
                "PUT",
                $_ENV['MYSTORE_API_URL'].$entity."/".$entity_id,
                [
                    'headers' => [
                        'Authorization' => "Basic " . $_ENV['MYSTORE_AUTH_ENCODE'],
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $data
                ]
            )->getBody();

            return json_decode($response, true);
        }

        catch (RequestException $e){
            //echo Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                $error_response = Psr7\Message::toString($e->getResponse());
                echo $error_response;
                file_put_contents($_ENV['PUT_LOG_PATH'], $error_response."\n \n", FILE_APPEND);
            }
        }
    }

    public function getEntity($entity, $entity_id, $query = '')
    {
        try {
            $response = $this->client->request(
                "GET",
                $_ENV['MYSTORE_API_URL'] . "{$entity}/{$entity_id}{$query}",
                [
                    'headers' => [
                        'Authorization' => "Basic " . $_ENV['MYSTORE_AUTH_ENCODE']
                ]
            ])->getBody();

            return json_decode($response, true);
        }

       catch (RequestException $e){
           //echo Psr7\Message::toString($e->getRequest());
           if ($e->hasResponse()) {
               $error_response = Psr7\Message::toString($e->getResponse());
               echo $error_response;
               file_put_contents($_ENV['GET_LOG_PATH'], $error_response."\n \n", FILE_APPEND);
           }
       }

    }

    public function postEntity($entity, $data)
    {
        try{
            $response = $this->client->request(
                "POST",
                $_ENV['MYSTORE_API_URL'].$entity,
                [
                    'headers' => [
                        'Authorization' => "Basic " . $_ENV['MYSTORE_AUTH_ENCODE'],
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $data
                ]
            )->getBody();

            return json_decode($response, true);
        }

        catch (RequestException $e){
            //echo Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                $error_response = Psr7\Message::toString($e->getResponse());
                echo $error_response;
                file_put_contents($_ENV['POST_LOG_PATH'], $error_response."\n \n", FILE_APPEND);
            }
        }
    }

    public function postCRM($url, $data)
    {
        try{
            $response = $this->client->request("POST", $url, [
                'json' => $data
            ])->getBody();
            return json_decode($response, true);
        }

        catch (RequestException $e){
            echo Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                $error_response = Psr7\Message::toString($e->getResponse());
                echo $error_response;
                file_put_contents($_ENV['POST_CRM_LOG_PATH'], $error_response."\n \n", FILE_APPEND);
            }
        }
    }





}