<?php

//require_once "PeopleDB.php";

function my_autoloader($class) {
    echo "Вызов функции автозагрузки<br>";
    include $class . ".php";
}
 
spl_autoload_register("my_autoloader");

class ListPeople {
    public $arrId = [];

    function __construct()
    {
        $conn = new mysqli("localhost", "root", "", "DB");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM infoPeople";
        if($result= $conn->query($sql)){
            foreach($result as $row){
                $this->arrId[] = (int) $row["id"];
            }
        } else{
            echo "Ошибка: " . $conn->error;
        }
        $conn->close();
    }

    function getArrayPeople($arrayId) {
        $conn = new mysqli("localhost", "root", "", "DB");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $person = new PeopleDB();
        foreach($arrayId as $i){
            $sql = "SELECT * FROM infoPeople WHERE id = '$i'";
            $person = new PeopleDB();
            if($result= $conn->query($sql)){
                foreach($result as $row){
                    $person->setId($row["id"]);
                    $person->name = $row["name"];
                    $person->surname = $row["surname"];
                    $person->dateOfBirth = $row["dateOfBirth"];
                    $person->sex = $row["sex"];
                    $person->cityOfBirth = $row["cityOfBirth"];
                }
        } else{
            echo "Ошибка: " . $conn->error;
        }
        //var_dump($person);
        $arrayObject[] = $person;
        }
        $conn->close();
        return $arrayObject;
    }

    function deleteArray($arrayId){
        $conn = new mysqli("localhost", "root", "", "DB");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            foreach($arrayId as $i){
                $sql = "DELETE FROM infoPeople WHERE id = '$i'";
                if($result= $conn->query($sql)){
                }
                else{
                echo "Ошибка: " . $conn->error;
                }
            }
            $conn->close();
    }

    function deleteArray2($arrayObject){
        foreach($arrayObject as $i){
            $i->deletePerson();
        }
    }
    
}

?>
