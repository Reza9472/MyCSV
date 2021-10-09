<?php
session_start();

if(isset($_POST['data'])){
    $checkedData = $_POST['data'];

    $_SESSION['checkedArr'] = $checkedData;
}

?>

