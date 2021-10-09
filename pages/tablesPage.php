<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tables</title>



    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>



    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>

    <script type="text/javascript" src="../js/mdb.min.js"></script>

    <link rel="stylesheet" href="../css/tablePage.css">
</head>
<body>

<?php


include_once ('../classes/ManageLayout.php');
$table = new ManageLayout();
session_start();


$allColumns = $table->showColumns($table->setQueryString('table')); // all columns

$dataquery = $table->showDataList($table->setQueryString('table')); // all tables

?>


<a type="button" class="btn btn-info" href="frontPage.php">Back</a> <!-- GOING BACK TO THE FONT PAGE -->

<button type="button" class="btn btn-outline-default wave-effect" data-toggle="collapse" aria-expanded="false" data-target="#addColCollapse" aria-controls="addColCollapse">Add Column</button> <!--  ADD COLUMN BUTTON  -->

<!------------------------------------->
<!--ADD COLUMN COLLAPSE-->

<div class="collapse card" id="addColCollapse" style="padding: 20px; margin: 10px; width: 50%">


    <form action="" method="post">

        <div class="row g-4">
            <div class="col-sm">
                <label for="col_name">Name</label><br><!--  NAME  -->
                <input class="form-control" id="col_name" type="text" name="col_name" >
            </div>


            <div class="col-sm">
                <label for="col_types">Type</label><br> <!--  TYPE  -->
                <select  name="col_types" class="form-control" id="col_types">
                    <option value="int">INT</option>
                    <option value="varchar" >VARCHAR</option>
                    <option value="text">TEXT</option>
                </select>
            </div>

            <div class="col-sm">
                <label for="col_length">Length</label><br><!--  LENGTH  -->
                <input type="text" class="form-control" name="col_length" id="col_length">
            </div>

            <div class="col-sm">
                <br><button type="submit" class="btn btn-success" name="submitaddcol">Submit</button><!--  SUBMIT BUTTON  -->
            </div>


        </div>

    </form>
</div>

<!--ADD COLUMN SUBMISSION-->
<?php if(isset($_POST['submitaddcol'])){
    $table->addColumn($table->setQueryString('table'));
} ?>

<!-------------------------------------------------------------------------->
<!--EXTRACT DATA SECTION-->
<form method="post" action="">

<div class="row" style="margin: 10px">

<label for="popDataNum">Number of records to extract: </label>
<input type="number" id="popDataNum" class="form-control" name="popDataNum" style="width: 10%; margin-left: 10px" > <!-- NUMBER OF RECORDS INPUT -->
    <button type="submit" name="extract" class="btn btn-md btn-info">Extract</button>

</div>

</form>



<!--    Move Column SECTION  -->
<!--------------------------------------------------->
<form method="post" action="">
    <input type='button' name='move' value='Move Column' class="btn btn-outline-default wave-effect" data-toggle="collapse" href="#moveCol" aria-expanded="false" aria-controls="moveCol">
</form>


<form method="post" action="">

    <div class="collapse card" id="moveCol" style="padding: 20px; margin: 10px; width: 30%"> <!--  FIRST COLUMN  -->
        Move <select class="browser-default custom-select" name="moveCol1">
            <?php foreach ($allColumns as $moveColumns): ?>
                <option ><?php echo $moveColumns ?></option>
            <?php endforeach; ?>

        </select> After

        <select class="browser-default custom-select" name="moveCol2"> <!--  SECOND COLUMN  -->
            <?php foreach ($allColumns as $moveColumns): ?>
                <option ><?php echo $moveColumns ?></option>
            <?php endforeach; ?>

        </select>
        <button type="submit" class="btn" name="moveSubmit">Submit</button>
    </div>
</form>

<!--MOVE COLUMN SUBMIT-->
<?php if (isset($_POST["moveSubmit"])){
    $table->moveColumn($table->setQueryString('table') , $_POST["moveCol1"] , $_POST["moveCol2"]);
} ?>






<!------------------------------------------------------------>
<!--DATA TABLE SECTION-->


<?php $alltables = $table->showTable2();
//print_r($alltables)?>

<form method="post" action="">
    <div class="table-responsive card" style="margin: 10px; padding: 10px">
        <table id="mainTable" class="table table-hover table-bordered table-responsive" >

            <thead>
            <tr>
                <?php $delColumn = "";
                $exchangeCol1 = ""; // EXCHANGE COLUMNS
                $foundTables = []; // ARRAY FOR MATCHING TABLES BETWEEN LAYOUT AND TABLES
                for ($j = 0 ; $j < count($allColumns) ; $j++):
//        foreach ($allColumns as $col): ?>
                    <td style="text-align: center">
                        <strong><?php echo $allColumns[$j] ?></strong>

                        <?php $foundTable = $table->findTable($allColumns[$j]); // FIND THE COLUMN IN THE ORIGINAL TABLES
                            if(!in_array($foundTable , $foundTables)){
                                array_push($foundTables , $foundTable); // IF IT IS FOUND, ADD IT TO THE FOUDNTABLE ARRAY
                            }
                        ?>



                            <?php if (isset($_POST["exchange$j"])){ // MOVE (EXCHANGE) COLUMNS

                                if($j+1 == count($allColumns)) { // IF WE HAVEN'T REACHED THE END OF THE ARRAY

                                    $table->moveColumn($table->setQueryString('table'), $allColumns[$j], $allColumns[$j - 1]); // MOVE IT DOWN
                                }else {

                                    $table->moveColumn($table->setQueryString('table'), $allColumns[$j], $allColumns[$j + 1]); // MOVE IT UP
                                }
                            } ?>

                            <br>
<!--                            DELETE BUTTON -->
                            <button type="submit" class="btn btn-danger" name="<?php echo 'delcol' . $allColumns[$j] ?>" id="<?php echo 'delcol' . $allColumns[$j] ?>"  style="float: right">
                                <i class='far fa-trash-alt'  style='cursor: pointer ' ></i>
                            </button>
<!--                            EDIT BUTTON-->
                            <button type="button" class="btn btn-warning" href="#<?php echo 'coledit' . $allColumns[$j] ?>" data-toggle="collapse" type="button" aria-expanded="false" aria-controls="<?php echo 'coledit' . $allColumns[$j] ?>" style="float: right">
                                <i class="far fa-edit"></i>
                            </button>
<!--                                MOVE(EXCHANGE) BUTTON-->
                            <button type="submit" class="btn btn-success" name="exchange<?php echo $j ?>" style="float: right">

                                <i class="fas fa-exchange-alt" style="cursor: pointer" id="exch<?php $allColumns[$j] ?>"></i>
                            </button>

<!--                            EDIT LAYOUT SECTION-->
                            <br><div class="collapse card" style="padding: 10px; margin: 10px; width: 100%" id="<?php echo 'coledit' . $allColumns[$j] ?>">
                                <div class="row g-4">
                                    <div class="col-sm">
                                        <label for="ed_col_name<?php echo $j ?>">Name</label><br>
                                        <input class="form-control" id="ed_col_name<?php echo $j ?>" type="text" name="ed_col_name<?php echo $j ?>" >
                                    </div>


                                    <div class="col-sm">
                                        <label for="ed_col_types<?php echo $j ?>">Type</label><br>
                                        <select  name="ed_col_types<?php echo $j ?>" class="form-control" id="ed_col_types<?php echo $j ?>">
                                            <option value="int">INT</option>
                                            <option value="varchar" >VARCHAR</option>
                                            <option value="text">TEXT</option>
                                        </select>
                                    </div>

                                    <div class="col-sm">
                                        <label for="ed_col_length<?php echo $j ?>">Length</label><br>
                                        <input type="text" class="form-control" name="ed_col_length<?php echo $j ?>" id="ed_col_length<?php echo $j ?>">
                                    </div>

                                    <div class="col-sm">
                                        <br><button type="submit" class="btn btn-success btn-md"  name="submiteditcol<?php echo $j ?>">Submit</button>
                                    </div>


                                </div>
                            </div>



                    </td>

<!--                    EDIT COLUMN SUBMIT-->
                    <?php if (isset($_POST["submiteditcol$j"])){
                        $table->editColumn($table->setQueryString('table') , $allColumns[$j] , $j);
                    } ?>
<!--                    DELETE COLUMN SUBMIT-->
                    <?php if(isset($_POST["delcol$allColumns[$j]"])){ // dropping the column
                        $table->deleteColumn($table->setQueryString('table') , $allColumns[$j]);
                    } ?>


                    <!--                Use jquery to pass that exact columns to the variable delColumn-->

                <?php endfor; ?>


            </tr>

            </thead>
            <tbody>
            <?php

            $tabledotCols = []; // to create the format class.column for passing to query

            foreach ($allColumns as $col) {

                $colTable = $table->findTable($col); // find which table is that column from
                $col = $colTable . "." . $col;
                array_push($tabledotCols , $col);

            }


            $implodedColumns = implode(" , " , $tabledotCols); // to create a string to pass to the query
            $implodedTables = implode(" , " , $foundTables); // IMPLODE TABLES AS AN ARRAY

//            echo $implodedColumns;



            $ch = [];

            if (isset($_POST['popDataNum'])) {
                $limit = $_POST['popDataNum']; // LIMIT THE NUMBER OF DATA IN THE ARRAY
//                $selects = $table->populateData($implodedColumns , $implodedTables , $limit);
                $selects = $table->joinTables($alltables , $implodedColumns , $limit); // FUNCTION TO JOIN AND FIND THE TABLES

                $_SESSION['selectedData'] = $selects; // PASS THE ARRAY TO A SESSION TO BE USED LATER DURING EXPORT

                foreach ($selects as $data):

            ?>
<!--                DISPLAY THE DATA TO THE USER-->
                <tr>
                    <?php foreach ($allColumns as $columns): ?>
                        <td scope="row"><?php echo $data[$columns]; ?></td>
                    <?php endforeach; ?>
                </tr>

            <?php endforeach;}

            ?>

            </tbody>
        </table>
    </div>

</form>


<!--    Export Section (Collapse)    -->

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#exportCollapse"
        aria-expanded="false" aria-controls="exportCollapse">Export File</button>


<div class="collapse" id="exportCollapse">

    <form method="post" action="">

    <div class="row " style="margin: 10px">
        <label for="expFileName">Enter The CSV File Name: </label>
        <input type="text" name="expFileName" id="expFileName" class="form-control" style="width: 20%">
        <button name="exportcsv" type="submit" class="btn btn-md">Export</button>
    </div>

    </form>
</div>


</form>


<?php if (isset($_POST['expFileName'])){
//    print_r($_SESSION);
    $exportarr = $_SESSION; // exported data

    $table->exportcsv($exportarr , $_POST['expFileName']);

} ?>



<?php //$table->commonColumns('student' , 'class'); ?>






<script>
    $(document).ready(function () { // ADD THE DATATABLE FUNCTIONALITY TO THE TABLE
        $('#datatable').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
</script>

<script>
    $(document).ready(function () {
        $('#mainTable').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });
</script>


</body>
</html>