<?php

class PeopleDB {
    private $id;
    public $name, $surname, $dateOfBirth, $sex, $cityOfBirth;
    //public static $sex;

    function __construct(...$peopleInfo)
    {
        if (count($peopleInfo) === 1){
            $id = $peopleInfo[0];

            $conn = new mysqli("localhost", "root", "", "DB");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM infoPeople WHERE id = '$id'";
            if($result= $conn->query($sql)){
                foreach($result as $row){
                    $this->id = (int) $row["id"];
                    $this->name = $row["name"];
                    $this->surname = $row["surname"];
                    $this->dateOfBirth = $row["dateOfBirth"];
                    $this->sex = $row["sex"];
                    $this->cityOfBirth = $row["cityOfBirth"];
                }
            } else{
                echo "Ошибка: " . $conn->error;
            }
            $conn->close();
        } else if (count($peopleInfo) === 5) {

            if (ctype_alpha($peopleInfo[0]) and ctype_alpha($peopleInfo[1]) and 
            ((int) $peopleInfo[3] === 0 or (int) $peopleInfo[3] === 1)) {

                $this->name = $peopleInfo[0];
                $this->surname = $peopleInfo[1];
                $this->dateOfBirth = $peopleInfo[2];
                $this->sex = (int) $peopleInfo[3];
                $this->cityOfBirth = $peopleInfo[4];
                
                $conn = new mysqli("localhost", "root", "", "DB");
                if($conn->connect_error){
                    die("Ошибка: " . $conn->connect_error);
                }
                $sql = "INSERT INTO infoPeople (name, surname, dateOfBirth, sex, cityOfBirth) 
                VALUES ('$this->name', '$this->surname', '$this->dateOfBirth', '$this->sex', '$this->cityOfBirth')";
                if($conn->query($sql)){
                    //echo "Данные успешно добавлены";
                    $this->id = $conn->insert_id; //помещает в id создавшейся записи в поле класса id, не забыть сделать гетер
                } else{
                    echo "Ошибка: " . $conn->error;
                }
                $conn->close();
            } else {
                echo "Не верные данные"; //для проверки русских букв нужно изменить настройки локали (setlocale) // setlocale(LC_ALL, 'ru_RU.CP1251');
            }
        } else {
            //echo "Не верное количество данные, их должно быть 1 или 5";
        }
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    //предполагается, что этот метод используется для уже созданных записей, к примеру в объекте изменили несколько значений и теперь нужно сохранить изменения в БД
    //если этот метод нужен был для сохранения новых записей, то реализация была бы как в констроре
    function savePerson() {
        if(ctype_alpha($this->name) and ctype_alpha($this->surname) and 
            ((int) $this->sex === 0 or (int) $this->sex === 1)) {
            $conn = new mysqli("localhost", "root", "", "DB");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            $sql = "UPDATE infoPeople SET name = '$this->name', surname = '$this->surname', dateOfBirth = '$this->dateOfBirth',  
            sex = '$this->sex', cityOfBirth = '$this->cityOfBirth' WHERE id = '$this->id'";
            if($conn->query($sql)){
                //echo "Данные успешно добавлены";
            } else{
                echo "Ошибка: " . $conn->error;
            }
            $conn->close();
        } else {
            echo "Не верные данные";
        }
    }

    function deletePerson() {
        $conn = new mysqli("localhost", "root", "", "DB");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $sql = "DELETE FROM infoPeople WHERE id = '$this->id'";
        if($conn->query($sql)){
            //echo "Данные успешно добавлены";
        } else{
            echo "Ошибка: " . $conn->error;
        }
        $conn->close();
    }

    static function sexSwith($person){
        if ($person->sex === 0) {
            $person->sex = "Муж";
        } else if ($person->sex == 1) {
            $person->sex = "Жен";
        }
       
    }

    public static function findOutAge($person){
        $person->dateOfBirth = floor( ( time() - strtotime($person->dateOfBirth) ) / (60 * 60 * 24 * 365.25) );
    }

    function formattingPerson() {
        $obj = new stdClass;
        $obj->id = $this->id; 
        $obj->name = $this->name;
        $obj->surname = $this->surname;
        $obj->dateOfBirth = $this->dateOfBirth;
        $obj->sex = $this->sex;
        $obj->cityOfBirth = $this->cityOfBirth;
        $this->sexSwith($obj);
        $this->findOutAge($obj);
        echo "yyyyyyyyyyyyyyyyyyyyyyyyyyyyy";
        return $obj;
    }
}

?>