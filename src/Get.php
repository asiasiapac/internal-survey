<?php 
namespace AsiAsiapac\InternalSurvey;

use GuzzleHttp\Client;

class Get{

    public static function questions(){
        $client = new Client(['base_uri' => $_ENV['ASI_SURVEY_HOST_ADDR'] ]);
        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', 'test');
        return $response;
    }
}