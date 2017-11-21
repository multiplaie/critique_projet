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
}


$db = new Database();
if (isset($_POST)&&!empty($_POST)) {
    switch ($_POST['action']) {
        case 'insertNewAnswer':
            $db->insertNew($_POST['data']);
            break;
        case 'checkIpExist':
            var_dump("{'ip':".$db->checkIpExist($_POST['data']['ip'])."}");die();
            return "{'ip':".$db->checkIpExist($_POST['data']['ip'])."}";
            break;
    }

}

 ?>
