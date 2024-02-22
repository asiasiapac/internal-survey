<?php 
namespace AsiAsiapac\InternalSurvey;

use GuzzleHttp\Client;
use AsiAsiapac\InternalLogger\SysLogger;

class Answer
{
	/*
        *Format

        data :
        [
            'email' => 
            'first_name' => 
            'last_name' => 
            'answer' => [
                [
                    'question_id' => 
                    'answer_value' => 
                ],
                [
                    'question_id' => 
                    'answer_value' => 
                ],
                [
                    'question_id' => 
                    'answer_value' => 
                ],
            ]
        ]
    */
	public static function save($survey_code, $data)
	{
		$client = new Client([
			'base_uri' => $_ENV['ASI_SURVEY_HOST_ADDR']
		]);

        // Send a post to api
        $response = $client->request('POST', $survey_code, ['form_params' => $data]);

        $status = $response->getStatusCode();
        $message = '';
        $error = [];
        if($response->getStatusCode() == 200){
            try {
                $contents = $response->getBody()->getContents();

                $responseHttp = json_decode($contents, true);

                $message = $responseHttp['message'];
            } catch (Exception $e) {
                $message = $e->getMessage();

                SysLogger::save(SysLogger::ERROR, $_SERVER['REQUEST_URI'], 'internal-survey.Answer.save', 'Gagal mensubmit survey, survey_code : '.$survey_code.' - '.$message);
            }
        }

        return [
            'status'    => $status,
            'message'   => $message,
            'request'  	=> $data,
            'error'     => $error,
        ];
	}
}