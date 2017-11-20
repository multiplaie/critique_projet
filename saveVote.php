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
}


$db = new Database();
if (isset($_POST)&&!empty($_POST)) {
    $db->insertNew($_POST);
}

 ?>
