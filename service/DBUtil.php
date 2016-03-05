<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIKE
 * Date: 2/13/16
 * Time: 10:56 AM
 * To change this template use File | Settings | File Templates.
 */

define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'reservations');

//bla test 
function getConnection(){


    // Create connection
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else{
        echo ' connection succesful'.'</br>';
    }

    return $conn;

}
