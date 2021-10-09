<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Front Page</title>



    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">



    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->


    <link rel="stylesheet" href="../css/frontPage.css">


    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/mdb.min.js"></script>
    <!-- Plugin file -->
    <script src="../js/addons/datatables.min.js"></script>
</head>


<?php

include_once ('../classes/ManageTable.php');
include_once ('../classes/ManageLayout.php');
include_once ('./test.php');

$table = new ManageTable(); //

$layoutTable = new ManageLayout();


$alltables = $table->showTable(); // retrieve an array of all tables
$alllayouttables = $layoutTable->showTable(); // retrieve an array of all the layout tables


;?>

<!-- TOP HEADER (JUMBOTRON)-->

<div class="jumbotron jumbotron-fluid" id="jumbo" style="text-align: center">
    <div class="container">
        <h2 class="display-4">MYCSV</h2>
        <p class="lead">Manage your csv data in the easiest way possible!</p>
    </div>
</div>





<!------------------------------------------------------------------------------------------------>
<!--    TREEVIEW    -->

        <div class="row-col-1" style="float: left">
            <div class="treeview-animated w-20 border mx-4 my-4">
                <h6 class="pt-3 pl-3">Content</h6>
                <hr>
                <ul class="treeview-animated-list mb-3">
                    <li class="treeview-animated-items">
                        <a class="closed">
                            <i class="fas fa-angle-right"></i>
                            <span><i class="fas fa-table ic-w mr-1"></i>Tables</span>
                        </a>
                        <ul class="nested">

                            <?php foreach ($alltables as $table1): ?> <!-- all tables -->
                            <li>
                                <div class="treeview-animated-element"><i class="fas fa-table ic-w mr-1"></i><?php echo $table1 ?> <!--     display tables     -->
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="treeview-animated-items">
                        <a class="closed">
                            <i class="fas fa-angle-right"></i>

                            <span><i class="fas fa-th-list ic-w mx-1"></i>Layouts</span>
                        </a>
                        <ul class="nested">
                            <?php foreach ($alllayouttables as $laytb): ?><!--    Display Layout      -->
                            <li>
                                <div class="treeview-animated-element"><a type="submit" href="tablesPage.php?table=<?php echo $laytb ?>" style="text-decoration: none" >
                                        <i class="fas fa-th-list ic-w mx-1"></i><?php echo $laytb ?></a>
                            </li>
                            <?php endforeach; ?>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>

<!--    RUNNING THE TREEVIEW-->
    <script>
        // Treeview Initialization
        $(document).ready(function() {
            $('.treeview-animated').mdbTreeview();
        });
    </script>


<!------------------------------------------------------------------------------------------------------->

<!--    DISPLAY TABLES SECTION  -->


<script>
    var checkedDataJsArr = []; // Array of all the checked fields from the tables

    function show(id , checkbox){

        if(checkbox.checked){

            checkedDataJsArr.push(id); // PUSH THE ID OF THE CHECKED CHECKBOX INTO THE ARRAY
        }else {
            checkedDataJsArr.pop(); // POP THE DATA FROM THE ARRAY
        }
        console.log(checkedDataJsArr);


    }
</script>



    <form method="post" action="">


<!--    --><?php //$expArr = []; ?>
<!--SHOW ALL TABLES-->

<!-- Card group -->
<!--<div style="align-items: center; justify-content: center; display: flex;">-->

    <div class="card row-col-11">
            <div class="row row-cols-2 row-cols-md-2" style="width: 100%">
                <?php foreach ($alltables as $tableValues): ?> <!-- ALL TABLES ARRAY -->


                    <!-- Card -->

                    <div class="card mb-1" style=" padding: 10px; ">

                        <!-- Card image -->
                        <div class="view overlay">


                            <div class="tableimg table-responsive"> <!-- IMAGE OF TABLE -->
                                <table class="card-img-top table table-bordered" >
                                    <thead >
                                    <tr>

                                        <?php $tableColumns = $table->showColumns($tableValues); ?> <!-- TABLE COLUMNS -->

                                        <form method="post" action="">

                                        <?php foreach ($tableColumns as $tc): ?> <!-- TABLE COLUMNS -->

                                            <th scope="col">

                                                <div class='form-check' style='float: right; position: relative'>
                                                    <input class='form-check-input checkbox-inline' type='checkbox' id='<?php echo $tc ?>' name='check<?php echo $tc ?>' onchange="show(this.id , this)" /> <!-- onchange it will add the id of the checkbox to array -->
                                                    <?php echo $tc ?>
                                                </div>

                                            </th>

                                        <?php endforeach; ?>

                                        </form>

                                    </tr>
                                    </thead>
                                    <tbody>

<!--                                    PRINT 3 EMPTY ROWS AS A SAMPLE OF THE TABLE-->
                                    <tr>
                                        <?php foreach ($tableColumns as $tc): ?>
                                            <td></td>
                                        <?php endforeach; ?>

                                    </tr>
                                    <tr>
                                        <?php foreach ($tableColumns as $tc): ?>
                                            <td></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($tableColumns as $tc): ?>
                                            <td></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>


                        </div>
                            <form method="post" action="">

                        <!-- Card content -->
                        <div class="card-body">

                            <!-- Title -->
                            <h4 class="card-title"><?php echo $tableValues ?></h4>

                                <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

                                <button type="submit" disabled name="delTable<?php echo $tableValues ?>" class="btn btn-danger btn-md">Delete</button> <!-- DELETE BUTTON -->



                        </div>
                        <!-- Card content -->
                            </form>
                    </div>
                    <!-- Card -->


                        <!-- DELETE SUBMIT --->
                        <?php if (isset($_POST["delTable$tableValues"])){
                            $table->deleteTable($tableValues);
                        } ?>

                    <?php endforeach; ?>

                </div>
                <button type="button" class="btn btn-success" name="submit" onclick="addArr()">Submit</button> <!-- SUBMITTING THE DATA (PREPARE FOR LAYOUT CREATION) -->
            </div>
        </div>
    </form>




<?php
$temp = "";
?>




<script>

    function addArr(){

        document.getElementById('addRow').style.display = 'block'; // display the add row button


        var index = 0; // INDEX OF THE ELEMENT

        var thead = "<thead> <tr> <th >Columns</th><th>Option</th></tr></thead>"; // TABLE HEAD


        for (let i = 0; i < checkedDataJsArr.length; i++) {

            index++;
            var colrow = $('<tr>' , {
                id: 'row' + i
            });



            colrow.append($('<td ></td>' ,  { // ADD THE DATA TO THE COLUMN FROM THE CHECKED ARRAY
                html: checkedDataJsArr[i],
                id: 'header' + i,

            }));

            colrow.append($('<button type="button" class="btn btn-elegant" id="'+i+'" onclick="moveColumn(this.id)" ><i class="fas fa-sort"></i></button>')); // MOVE COLUMN


            $('#data_table').append(colrow);



            colrow.append($('<input >' , { // INPUT BUTTON FOR EDITING THE DATA
                id: 'edit_button' + i,
                class: 'edit btn btn-elegant' ,
                type: 'button',
                value: 'Edit',

            }));

            $('#edit_button' + i).on('click' , function(){ // FUNCTION FOR EDITING THE DATA
                edit_row(i);
            })
            colrow.append($("<input>" , { // INPUT FOR SAVING THE DATA
                type: 'button',
                id: 'save_button' + i,
                class: 'save btn btn-elegant',
                value: 'Save'
            }));

            $('#save_button' + i).on('click' , function(){ // SAVE BUTTON FUNCTION
                save_row(i);
            })

            colrow.append($("<input >" , { // DELETE BUTTON
                id: 'delete_button' + i,
                type: 'button',
                value: 'Delete',
                class: 'delete btn btn-elegant'
            }));

            $('#delete_button' + i).on('click' , function(){ // DELETE BUTTON FUNCTION
                delete_row(i);
                index--;
            })


            $('#add_button' + i).on('click' , function(){ // ADD ROW FUNCTION
                add_row(i);
            })



        document.getElementById("edit_button"+i).style.display="block"; // SHOW THE EDIT BUTTON
        document.getElementById("save_button"+i).style.display="none"; // HIDE THE SAVE BUTTON
        }

        $("body").on("click",".deleteRow",function(ev) { // DELETE FUNCTION

            delete_row(index);
        })

    }
</script>


<!---->
<!--<table id="tabprincipal" class="table table-bordered table-hover">-->
<!--    <tbody></tbody>-->
<!--</table>-->


<!---------------------------------------------------------------------------------------------------->
<!--TABLE FOR LAYOUT CREATION-->

<div class="card " style="margin: 20px">
<button id="addRow" type="button" class="btn btn-elegant" >Add row</button>

<div id="wrapper">
    <table align='center' cellspacing=2 cellpadding=5 id="data_table" class="table table-bordered" data-reorderable-rows="true">

        <tr>

        </tr>

    </table>
</div>



<script>

    $("body").on("click","#addRow",function(ev){

        var rowCount = $('#data_table tr').length; // counting the number of rows in our table

        var newRow = "<tr class='tabrow editing' id='row"+(rowCount-1)+"'>"
            +"<th><div></div><div><input type='text' class='form-control' value=''/></div></th>"
            // +"<td><div>A"+len+"</div><div><input type='text' value='A"+len+"'/></div></td>"
            +"<th><div><button type='button' class='btn btn-elegant' id='"+(rowCount-1)+"' onclick='moveColumn(this.id)' ><i class='fas fa-sort'></i></button><button class='editRow btn btn-elegant' type='button'>Edit</button></div><div><button class='deleteRow btn btn-elegant' type='button'>Delete</button></div><div><button class='saveRow btn btn-elegant' type='button'>Save</button></div></th>"
            +"</tr>";




        $(newRow).appendTo("#data_table tbody"); // APPEND THE ROW TO THE TABLE

        counter = 0;

    console.log("Count: " , rowCount);
    });

    $("body").on("click",".deleteRow",function(ev) {
        var row = $(this).parents(".tabrow");
        let index = checkedDataJsArr.indexOf(row.find("div").attr("id"));

        console.log(index);


        delete_row(index);
    })


    // Edit the columns with data

    $("body").on("click",".editDataRow",function(ev){
        $(this).parents(".tabrow").removeClass("closed").addClass("editing");
        var row = $(this).parents(".tabrow");

        console.log(row.find("div").attr("id"));

        let index = checkedDataJsArr.indexOf(row.find("div").attr("id"));
        newIndex = index
        console.log(index);
        checkedDataJsArr = jQuery.grep(checkedDataJsArr , function (value){
            return value !== row.find("div").attr("id");
        })


        console.log(checkedDataJsArr);
    });







        $("body").on("click",".editRow",function(ev){
        $(this).parents(".tabrow").removeClass("closed").addClass("editing");
        var row = $(this).parents(".tabrow");

        // console.log($("#tabprincipal th").html());
        console.log(row.find("div").attr("id"));

        let index = checkedDataJsArr.indexOf(row.find("div").attr("id"));
        newIndex = index
        console.log(index);
        checkedDataJsArr = jQuery.grep(checkedDataJsArr , function (value){
            return value !== row.find("div").attr("id");
        })


        console.log(checkedDataJsArr);
    });

    $("body").on("click",".saveRow",function(ev){
        var row = $(this).parents(".tabrow");

        console.log("counter " + counter);

        // update the cells
        row.find("th").each(function(){
            // new value
            var newVal = $(this).find("input").val();
            if(newVal && counter == 0) {

                checkedDataJsArr.push(newVal);
            }else if(newVal && counter !== 0){
                let index = checkedDataJsArr.indexOf(newVal);
                // checkedDataJsArr[newIndex] = newVal;

                checkedDataJsArr.splice(newIndex, 0, newVal);
                console.log(newIndex);
                // console.log($(this).find("div").attr("id"));
            }
            $(this).find("div:first").html(newVal);
            $(this).find("div:first").attr("id" , newVal);

            console.log(checkedDataJsArr);
            console.log($(this).find("div").attr("id"));

            counter++;
        });


        row.removeClass("editing").addClass("closed");
    });
</script>




<div class="row " style="margin: 20px">
<h4 for="layoutName">Layout Name </h4>
<input name="layoutName" id="layoutName" type="text" class="form-control" style="width: 30%; margin-left: 10px">
<button type="submit" name="layoutCrt" class="btn btn-md btn-success" onclick="createLayout()">Create Layout</button>
</div>
</div>


<script>

    // Send the data to test.php to change it to

    function createLayout() {

        var sendData = function () { // we pass the array of columns selected to the test.php
            $.post('test.php', {
                data: checkedDataJsArr
            }, function (response) {
                console.log(response);
            });
        }
        sendData();

    }
</script>




<!-- Collapse buttons -->
<div>

    <button class="btn btn-info btn-rounded waves-effect" style="width: 99%; margin: 10px; align-items: center" type="button" data-toggle="collapse" data-target="#collapseLayout"
            aria-expanded="false" aria-controls="collapseLayout">
        Layouts
    </button>
</div>
<!-- / Collapse buttons -->

<!-- Collapsible element -->
<div class="collapse" id="collapseLayout">

<!-- / Collapsible element -->


<!-------------------------------------------------------------------------------------->

<!--    LAYOUT SECTION  -->

<form method="post" action="">

<?php $checkedData = $_SESSION['checkedArr']; ?> <!-- GETTING THE DATA FROM JAVASCRIPT ARRAY -->

<!--    CREATE TABLE FUNCTION-->
<?php if (isset($_POST['layoutName'])){
    $table->createTb("ass3alayout" , $_POST['layoutName'] , $checkedData);
}



?>


<div style="align-items: center; justify-content: center; margin: 30px">

        <div class="row row-cols-3 row-cols-md-3">
<?php foreach ($alllayouttables as $alt): ?>
<?php $alllayoutcolumns = $layoutTable->showColumns($alt); ?> <!-- ALL COLUMNS FROM LAYOUT -->

    <div class="card mb-1" style=" padding: 10px; width: 40%">
<h2><span class="badge badge-pill badge-default"><?php echo $alt ?></span></h2>

<div class="table-responsive">

    <table class="table table-bordered " >
    <thead>
    <tr>
        <a type="submit" href="tablesPage.php?table=<?php echo $alt ?>" class="btn btn-primary btn-md" >Select</a> <!-- ANCHOR TAG TO GO TO THE LAYOUT PAGE -->
        <button type="submit" class="btn btn-danger btn-md" name="delLayout<?php echo $alt ?>" >Delete</button> <!-- DELETE BUTTON -->

<!--        DELETE LAYOUT SUBMIT-->
        <?php if(isset($_POST['delLayout'.$alt])){
           $table->deleteLayout($alt);
        } ?>

        <?php foreach ($alllayoutcolumns as $column): ?> <!-- ALL COLUMNS FROM LAYOUT -->
        <th scope="col">
            <?php echo $column ?> <!-- PRINT LAYOUT -->

        </th>

<!--        DELETE COLUMNS OF THE LAYOUT        -->
        <?php if (isset($_POST["<?php echo 'delcol' . $column ?>"])){
                $layoutTable->deleteColumn($column);
            } ?>


        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>

<!--    PRINT 3 EMPTY ROWS AS A REPRESENTATION FOR THE TABLE-->
    <tr>
        <?php foreach ($alllayoutcolumns as $alt): ?>
        <th scope="row"></th>
        <?php endforeach; ?>
    </tr>
    <tr>
        <?php foreach ($alllayoutcolumns as $alt): ?>
            <th scope="row"></th>
        <?php endforeach; ?>
    </tr>
    <tr>
        <?php foreach ($alllayoutcolumns as $alt): ?>
            <th scope="row"></th>
        <?php endforeach; ?>
    </tr>
    </tbody>
</table>
</div>
            </div>


<?php endforeach; ?>

</div>
</div>


<?php if (isset($_POST['submit'])): ?>

</form>

<?php endif; ?>
</div>

</body>


<script src="frontPage.js"></script>
</html>