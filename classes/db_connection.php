<?php




$servername = "localhost";
$username = "root";
$password = "";

//try {
//    $pdo = new PDO("mysql:host=$servername;dbname=ass2a", $username, $password);
//    // set the PDO error mode to exception
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
//} catch(PDOException $e) {
//    echo "Connection failed: " . $e->getMessage();
//}
class dbConnection
{

    function connect($db)
    {


        set_exception_handler(function ($e) {
            error_log($e->getMessage());

            exit($e->getMessage()); //something a user can understand
        });
        $dsn = "mysql:host=localhost;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        $pdo = new PDO($dsn, "root", "", $options);
        return $pdo;
    }
}
