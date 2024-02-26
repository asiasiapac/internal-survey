<?php 
namespace AsiAsiapac\InternalSurvey;

use AsiAsiapac\InternalSurvey\Component;

class Answer extends Component
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
	public function save($survey_code, $data)
	{
        $response = $this->_execute('POST', $survey_code, $data);

        return [
            'status'    => $response['status'],
            'message'   => $response['message'],
            'request'  	=> $data,
            'error'     => $response['response']['error'],
        ];
	}
}