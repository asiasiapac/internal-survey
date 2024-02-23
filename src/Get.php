<?php 
namespace AsiAsiapac\InternalSurvey;

use GuzzleHttp\Client;
use AsiAsiapac\InternalLogger\SysLogger;

class Get{

    /*
        *Penjelasan

        ASI_SURVEY_HOST_ADDR : domain API Survey
    */
    public static function questions($survey_code){
        $client = new Client(['base_uri' => $_ENV['ASI_SURVEY_HOST_ADDR'] ]);

        // Send a request to api
        $response = $client->request('GET', $survey_code);

        $data = [];
        $status = $response->getStatusCode();
        $message = '';

        if($response->getStatusCode() == 200){
            try {
                $contents = $response->getBody()->getContents();

                $data = json_decode($contents, true);
            } catch (Exception $e) {
                $message = $e->getMessage();

                SysLogger::save(SysLogger::ERROR, $_SERVER['REQUEST_URI'], 'internal-survey.Get.questions', 'Gagal mendapatkan pertanyaan, survey_code : '.$survey_code.' - '.$message);
            }
        }

        return [
            'status'    => $status,
            'message'   => $message,
            'response'  => $data
        ];
    }

    public static function result($survey_code){
        $client = new Client(['base_uri' => $_ENV['ASI_SURVEY_HOST_ADDR'] ]);

        // Send a request to api
        $response = $client->request('GET', $survey_code.'/result');

        $data = [];
        $status = $response->getStatusCode();
        $message = '';

        if($response->getStatusCode() == 200){
            try {
                $contents = $response->getBody()->getContents();

                $data = json_decode($contents, true);
            } catch (Exception $e) {
                $message = $e->getMessage();

                SysLogger::save(SysLogger::ERROR, $_SERVER['REQUEST_URI'], 'internal-survey.Get.result', 'Gagal mendapatkan hasil survey, survey_code : '.$survey_code.' - '.$message);
            }
        }

        return [
            'status'    => $status,
            'message'   => $message,
            'response'  => $data
        ];
    }
}