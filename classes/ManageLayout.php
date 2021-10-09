<?php

include_once ('db_connection.php');


class ManageLayout
{


    public $pdo;
//-------------------------------------------------------------------------------------------------------------------
//    CONSTRUCTOR FOR CONNECTION
    function __construct(){
        $dbConnection = new dbConnection();
        $this->pdo = $dbConnection->connect('ass3alayout');
    }
//-------------------------------------------------------------------------------------------------------------------
//    DISPLAY TABLE FUNCTION
    function showTable(){
        $stmt = $this->pdo->prepare("SHOW TABLES FROM ass3alayout");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt = null;
    }

//-------------------------------------------------------------------------------------------------------------------
//    DISPLAY COLUMN FUNCTION
    function showColumns($tb){
        $stmt = $this->pdo->prepare("DESCRIBE $tb ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt = null;
    }

//-------------------------------------------------------------------------------------------------------------------
//    DELETE COLUMN FUNCTION
    function deleteColumn( $tb , $col){


        $stmt = $this->pdo->query("ALTER TABLE $tb DROP $col ");
        $stmt = null;
        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/tablesPage.php?table=$tb')</script>";

    }
//-------------------------------------------------------------------------------------------------------------------
//    RETRIEVE DATA FROM QUERY STRING FUNCTION
    function setQueryString($q){

        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        // Append the host(domain name, ip) to the URL.
        $url.= $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL
        $url.= $_SERVER['REQUEST_URI'];

        $url_components = parse_url($url);

        parse_str($url_components['query'], $params);
        return $params[$q];

    }
//-------------------------------------------------------------------------------------------------------------------
//    RETRIEVE DATA FUNCTION
    function showDataList($tb){
        $result = $this->pdo->prepare("SELECT * FROM $tb");
        $result->execute();
        return $result->fetchAll();

    }
//-------------------------------------------------------------------------------------------------------------------
//    MOVE COLUMN FUNCTION
    function moveColumn($tb , $col1 , $col2){

        $colType1 = $this->getDataInfo($tb , $col1); // FIRST COLUMN TYPE
//        $colType2 = $this->getDataInfo($tb , $col2);


        $stmt = $this->pdo->prepare("ALTER TABLE $tb CHANGE COLUMN $col1 $col1 $colType1 AFTER $col2 ;");

        $stmt->execute();
        $stmt = null;

        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/tablesPage.php?table=$tb')</script>";

    }
//-------------------------------------------------------------------------------------------------------------------
//    RETRIEVE COLUMN TYPES FUNCTION
    function getDataInfo($tb , $colName){

        $cols = $this->showColumns($tb);
        $index =  array_search("$colName" , $cols); // INDEX OF THE COLUMN

        $query = $this->pdo->query("SHOW COLUMNS FROM $tb");

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $rs =  $results[0];



        return $results[$index]["Type"]; // RETURN THE TYPE OF THE COLUMN
    }
//-------------------------------------------------------------------------------------------------------------------
//    EDIT COLUMN FUNCTION
    function editColumn($tb , $col, $i ){

        if(isset($_POST["ed_col_name$i"])){ // COLUMN NAME

            $newcolName = $_POST["ed_col_name$i"];
        }
        if(isset($_POST["ed_col_types$i"])){ // COLUMN TYPE

            $colType = $_POST["ed_col_types$i"];
        }
        if(isset($_POST["ed_col_length$i"])){ // COLUMN LENGTH

            $colLength = $_POST["ed_col_length$i"];
        }

        $stmt = $this->pdo->prepare("ALTER TABLE $tb CHANGE $col $newcolName $colType($colLength) ;");
        $stmt->execute();
        $stmt = null;

        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/tablesPage.php?table=$tb')</script>";

    }
//-------------------------------------------------------------------------------------------------------------------
//    ADD COLUMN FUNCTION
    function addColumn($tb){

        if(isset($_POST['col_name'])){ // COLUMN NAME
            $colName = $_POST['col_name'];
        }

        if(isset($_POST['col_types'])){ // COLUMN TYPE

            $colType = $_POST['col_types'];
        }

        if(isset($_POST['col_length'])){ // COLUMN LENGTH
            $colLength = $_POST['col_length'];

        }

        $stmt = $this->pdo->prepare("ALTER TABLE $tb ADD ($colName $colType($colLength)) ");

        $stmt->execute();
        $stmt = null;

        echo "<script>window.location.replace('http://localhost:63342/Assignment 3A/pages/tablesPage.php?table=$tb')</script>";

    }


//-------------------------------------------------------------------------------------------------------------------
//    DISPLAY LAYOUT TABLES FUNCTION
    function showTable2(){

        $dbConnection = new dbConnection(); // CONNECT TO THE LAYOUT DATABASE
        $newpdo = $dbConnection->connect('ass3a');

        $stmt = $newpdo->prepare("SHOW TABLES FROM ass3a");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);

    }
//-------------------------------------------------------------------------------------------------------------------
//    DISPLAY THE LAYOUT COLUMNS FUNCTION
    function showColumns2($tb){
        $dbConnection = new dbConnection(); // CONNECT TO THE LAYOUT DATABASE
        $newpdo = $dbConnection->connect('ass3a');

        $stmt = $newpdo->prepare("DESCRIBE $tb ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);

    }

//-------------------------------------------------------------------------------------------------------------------
//    FIND COLUMN FUNCTION FUNCTION
    function findTable($col){

        $dbConnection = new dbConnection();
        $newpdo = $dbConnection->connect('ass3a');

        $alltables = $this->showTable2(); // ALL LAYOUT TABLES

        foreach ($alltables as $table){
            $allColumns = $this->showColumns2($table);
            if(in_array($col , $allColumns)){ // SEARCH FOR THE COLUMN IN ALL THE TABLES

                return $table;
            }
        }
    }


//-------------------------------------------------------------------------------------------------------------------
//    EXPORT CSV FILE FUNCTION
    function exportcsv($dataArray , $fileName){


        $file = fopen("../public/$fileName.csv","w"); // WRITE TO THE FILE

        fputcsv($file , $dataArray['checkedArr']); // write the columns

        foreach ($dataArray['selectedData'] as $data){ // write the data
            fputcsv($file , $data);
        }

        echo "<div class='alert alert-success' role='alert'>Data exported Successfully!</div>";

        fclose($file);

    }


    // To Display the common columns as well
    function commonColumns($tb1 , $tb2){

        $dbConnection = new dbConnection();
        $newpdo = $dbConnection->connect('ass3a');




        $query = "  select $tb1.COLUMN_NAME
                    from INFORMATION_SCHEMA.COLUMNS $tb1 
                    join INFORMATION_SCHEMA.COLUMNS $tb2 on $tb1.COLUMN_NAME = $tb2.COLUMN_NAME
                    where $tb1.TABLE_NAME = '$tb1' and $tb2.TABLE_NAME = '$tb2';";

        $stmt = $newpdo->prepare($query);
        $stmt->execute();
//        return $stmt->fetchAll();



        $resultCheck = $stmt->rowCount();


        if ($resultCheck > 0) {
            $columnarr = [];
            echo "<table class='table table-warning table-hover' style='cursor: pointer'>";
            echo "<thead>";
            echo "<tr>";

            echo "<th scope='col'>Table 1</th>";
            echo "<th scope='col'>Table 2</th>";
            echo "<th scope='col'>COLUMN NAME</th>";
            echo "</tr>";
            while($row = $stmt->fetchAll(PDO::FETCH_COLUMN)) {
                array_push($columnarr , $row);
//                print_r($row);

                echo "<tr>";
                echo "<td scope='row'>" . $tb1 . "</td>";
                echo "<td scope='row'>" . $tb2 . "</td>";
                foreach ($row as $columnName){

                echo "<td scope='row'>" . $columnName . "</td>";
                }
                echo "</tr>";

            }
            echo "</thead>";
            echo "</table>";

            return $columnarr;
        }
    }


    function columnNames(){

        $dbConnection = new dbConnection();
        $newpdo = $dbConnection->connect('ass3a');

        $stmt = $newpdo->prepare();
        $stmt->execute();
        return $stmt->fetchAll();


        $q = $dbh->prepare("DESCRIBE tablename");
        $q->execute();
        $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
    }


    function joinTables($tables , $columns , $limit){



        $query = "SELECT $columns from $tables[0]"; // STARTING QUERY

        $q2 = ""; // FOR ADDING THE JOIN SECTION FOR COMMON FIELDS
        for ($i = 1 ; $i < count($tables) ; $i++){
          $q2 = $q2 . " join $tables[$i] ON $tables[0].sys_id = $tables[$i].sys_id ";
        }

        $query = $query . $q2; // ADD THE JOIN SECTION TO THE QUERY

        $q3 = " ORDER BY RAND() LIMIT $limit "; // LIMIT TO THE NUMBER USER REQUESTED

        $query = $query . $q3; // ADD THE LIMIT PART TO THE QUERY



        $dbConnection = new dbConnection(); // CONNECT TO THE TABLES DATABASE
        $newpdo = $dbConnection->connect('ass3a');

        $stmt = $newpdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();


    }




}