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

    function getArrayPeople($array) {
        $conn = new mysqli("localhost", "root", "", "DB");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $x = new PeopleDB();
        foreach($array as $i){
            $sql = "SELECT * FROM infoPeople WHERE id = '$i'";
            $x = new PeopleDB();
            if($result= $conn->query($sql)){
                foreach($result as $row){
                    $x->setId($row["id"]);
                    $x->name = $row["name"];
                    $x->surname = $row["surname"];
                    $x->dateOfBirth = $row["dateOfBirth"];
                    $x->sex = $row["sex"];
                    $x->cityOfBirth = $row["cityOfBirth"];
                }
        } else{
            echo "Ошибка: " . $conn->error;
        }
        //var_dump($x);
        $y[] = $x;
        }
        $conn->close();
        return $y;
    }

    function deleteArray($array){
        $conn = new mysqli("localhost", "root", "", "DB");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            foreach($array as $i){
                $sql = "DELETE FROM infoPeople WHERE id = '$i'";
                if($result= $conn->query($sql)){
                }
                else{
                echo "Ошибка: " . $conn->error;
                }
            }
            $conn->close();
    }

    function deleteArray2($array){
        foreach($array as $i){
            $i->deletePerson();
        }
    }
    
}

?>
