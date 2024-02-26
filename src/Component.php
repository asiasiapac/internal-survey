<?php
namespace AsiAsiapac\InternalSurvey;

use AsiAsiapac\InternalLogger\SysLogger;
use GuzzleHttp\Client;

class Component
{
	protected $client;

	function __construct()
	{
		$this->client = new Client(['base_uri' => $_ENV['ASI_SURVEY_HOST_ADDR'] ]);
	}

	/*
        execute the api and get the response
    */
    protected function _execute($METHOD, $params, $data = [], $full_path = false)
    {

        $message = '';
        $error = [];

        $trace = debug_backtrace();

        $back_func  = $trace[1]['function'];
        $class      = $trace[1]['class'];

        $back_func_2  = $trace[2]['function'];
        $class_2      = $trace[2]['class'];

        $class_refer = sprintf('%s\%s -> %s\%s', $class_2, $back_func_2, $class, $back_func);

        try {
            if($full_path){
                $client = new Client(['base_uri' => $params]);

                if($METHOD == 'GET'){
                    $response = $client->request('GET', '');
                }else if($METHOD == 'POST'){
                    $response = $client->request('POST', '', ['form_params' => $data]);
                }
            }else{
                $client = $this->client;

                if($METHOD == 'GET'){
                    $response = $client->request('GET', $params);
                }else if($METHOD == 'POST'){
                    $response = $client->request('POST', $params, ['form_params' => $data]);
                }
            }

            $statusCode = $response->getStatusCode();
            if($statusCode == 200){
                try {
                    $contents = $response->getBody()->getContents();

                    $responseContent = json_decode($contents, true);
                } catch (Exception $e) {
                    $message = $e->getMessage();

                    SysLogger::save(SysLogger::ERROR, $_SERVER['REQUEST_URI'], $class_refer, 'problem with api function, params : '.$params.' - '.$message);
                }
            }else{
                $responseContent = '';
            }
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseContent = $response->getBody()->getContents();

            SysLogger::save(SysLogger::ERROR, $_SERVER['REQUEST_URI'], $class_refer, 'problem with api function callback, params : '.$params.' - '.$responseContent);
        }

        return [
            'status'   => $statusCode,
            'message'  => $message,
            'response' => $responseContent
        ];
    }
}