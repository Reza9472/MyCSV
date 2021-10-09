<?php

include_once ('db_connection.php');


class ManageTable
{

    public $pdo;
//-------------------------------------------------------------------------------------------------------------------
//    CONSTRUCTOR FOR CONNECTION
    function __construct(){
        $dbConnection = new dbConnection();
        $this->pdo = $dbConnection->connect('ass3a');
    }


//-------------------------------------------------------------------------------------------------------------------
//    CREATE TABLE FUNCTION
    function createTb($db , $tb , $checkedArr){


        $newarr = []; // FOR CREATING THE QUERY STRING TO PASS TO THE TABLE CREATION QUERY
        for($i = 0 ; $i < count($checkedArr) ; $i++){

            array_push($newarr , "`$checkedArr[$i]` VARCHAR(25) NOT NULL" ); // PUSH THE CHECKED COLUMN NAMES TO THE ARRAY
        }

        $q = implode("," , $newarr); // MAKE IT A STRING TO PASS TO THE QUERY


        $stmt = $this->pdo->prepare("CREATE TABLE $db.$tb ($q) "); // TABLE CREATION QUERY
        $stmt->execute();
        $stmt = null;

        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/frontPage.php')</script>"; // REFRESH THE PAGE TO DISPLAY THE CHANGE

    }


//-------------------------------------------------------------------------------------------------------------------
//    DISPLAY TABLES FUNCTION
    function showTable(){
        $stmt = $this->pdo->prepare("SHOW TABLES FROM ass3a");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt = null;
    }

//-------------------------------------------------------------------------------------------------------------------
//    DISPLAY COLUMNS FUNCTION
    function showColumns($tb){
        $stmt = $this->pdo->prepare("DESCRIBE $tb ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt = null;
    }
//-------------------------------------------------------------------------------------------------------------------
//    DELETE TABLE FUNCTION
    function deleteTable($tb)
    {

        $stmt = $this->pdo->query("DROP TABLE $tb");
        $stmt = null;
        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/frontPage.php')</script>";

    }
//-------------------------------------------------------------------------------------------------------------------
//    DELETE LAYOUT TABLE FUNCTION
    function deleteLayout($tb)
    {

        $dbConnection = new dbConnection(); // TO CONNECT TO THE OTHER DATABASE FIRST (THE LAYOUTS HAVE THEIR OWN DATABASE)
        $newpdo = $dbConnection->connect('ass3alayout');


        $stmt = $newpdo->query("DROP TABLE $tb");

        $stmt = null;
        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/frontPage.php')</script>";

    }

//    function showDataList($tb){
//        $result = $this->pdo->prepare("SELECT * FROM $tb");
//        $result->execute();
//        return $result->fetchAll();
//        $stmt = null;
//    }

}