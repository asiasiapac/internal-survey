<?php 
namespace AsiAsiapac\InternalSurvey;

use AsiAsiapac\InternalSurvey\Component;

/*
    *explain

    ASI_SURVEY_HOST_ADDR : domain API Survey

    list public function

    - questions : get the specific survey
    - alreadyDone : check the participant already done the survey or not
    - result : get the summary survey
    - history : get the list of participant who done the survey
*/

class Get extends Component{

    public function questions($survey_code){
        // Send a request to api
        return $this->_execute('GET', $survey_code);
    }

    /*
        parameter data berisi array

        - email = email dari peserta
    */
    public function alreadyDone($survey_code, $data = [])
    {
        // Send a request to api
        return $this->_execute('POST', $survey_code.'/done', $data);
    }

    public function result($survey_code){
        // Send a request to api
        return $this->_execute('GET', $survey_code.'/result');
    }

    public function history($survey_code, $link_page = '', $search = '', $limit = 10)
    {
        $default_url = $survey_code.'/history';

        if(!empty($link_page)){
            $url = $link_page;
        }else{
            $url = $default_url;
        }

        $result = $this->_execute('POST', $url, [
            'search'    => $search,
            'limit'     => $limit,
        ]);

        return $result;
    }
}