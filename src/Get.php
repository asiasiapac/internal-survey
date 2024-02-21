<?php 
namespace AsiAsiapac\InternalSurvey;

use GuzzleHttp\Client;

class Get{

    public static function questions(){
        /*$client = new Client(['base_uri' => $_ENV['ASI_SURVEY_HOST_ADDR'] ]);
        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', 'test');
        return $response;
        */
        $resp = [
             
            "project_code"=> "CDP",
            "project name"=> "'LMS Feedback",
            "survey_label"=> "Penilaian terhadap materi/ modul pembelajaran",
            "questions"=> [ 
                    ["id"=>1,"item"=>"Materi disampaikan secara urut."],
                    ["id"=>2,"item"=>"Materi pembelajaran mudah dipahami."],
                    ["id"=>3,"item"=>"Relevansi materi dengan topik pembelajaran."] 
            ]
                
        ];
            return json_encode($resp); 
    }
}