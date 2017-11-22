<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 *
 */
class Database
{
    private $path;
    private $data;

    function __construct(){
        $this->setPath("data/data.json");
        $this->initData();
    }

    public function insertNew($data_to_insert){
        $data = $this->getData();
        $data[] = $data_to_insert;
        file_put_contents($this->getPath(),json_encode($data));
    }

    protected function initData(){
        $this->setData(json_decode(file_get_contents($this->getPath())));
    }

    public function getPath(){
        return $this->path;
    }

    protected function setPath($value){
        $this->path = $value;
    }

    protected function setData($value = array()){
        $this->data = $value;
    }

    public function getData(){
        return $this->data;
    }

    public function checkIpExist($ip){
        $data = $this->getData();
        $find = "0.0.0.0";
        foreach ($data as $key => $value) {
            if ($value->geo->ip == $ip) {
                $find = $ip;
            }
        }
        return $find;
    }

    public function getWordStateSaved(){
        $data = $this->getData();
        $score = 127;
        $score_max = 255;
        foreach ($data as $key => $value) {
            if ($value->answer == 1 && $score + 5 <= $score_max) {
                $score += 5;
            }else if ($value->answer == 0 && $score - 5 >= $score_max) {
                $score -= 5;
            }
        }
        return $score;
    }
}


$db = new Database();
if (isset($_POST)&&!empty($_POST)) {
    $return = "ok";
    switch ($_POST['action']) {
        case 'insertNewAnswer':
            $db->insertNew($_POST['data']);
            break;
        case 'checkIpExist':

                $return = $db->checkIpExist($_POST['data']['ip']);
            break;
        case 'getWordStateSaved':
            $return = $db->getWordStateSaved();
            break;
    }
    echo json_encode(
        array("result"=>$return)
    );

}

 ?>
