<?php
include '../Classes/Sys.php';

require_once '../DataAccessObjects/DAOMySQLHotelGroup.php';
require_once '../DataAccessObjects/DAOExcelHotelGroup.php';

if(isset($_REQUEST['delid'])){
    $idToDelete = $_REQUEST['delid'];
    $daoMySQL = new DAOMySQLHotelGroup();
    $daoMySQL->deleteGroup($idToDelete);
}
?>

<html>

<head>

</head>
<body>







<?php

// VIEW GROUPS 12-04-2016
if(isset($_REQUEST['viewreservationsfor'])){

    $titles = array('Id','Arrival','Departure', 'Group Name',  'Alloc', 'Revenue Alloc', 'PickUp', 'Drop date', 'Revenue Pick Up', 'Left', 'Dropped');

    $daoMySQL = new DAOMySQLHotelGroup();

    $idOfGroup = $_REQUEST['viewreservationsfor']; // idOfGroup represents the group name actually (the foreign key)

    $reservations = $daoMySQL->selectReservationsForGroup($idOfGroup);
    echo 'ALL RESERVATIONS: <br/>';

    echo '<table border="1">';
    echo '<tr>';

    foreach($titles as $t){
        echo '<th>'.$t.'</th>';
    }
    echo '</tr>';

    foreach($reservations as $res){
        echo '<tr>';
        // Array ( [0] => Array ( [id] => 77 [arrival] => 2013-05-24 [departure] => 2014-01-24 [group_name] => 2PSU-Eating Disorders [alloc] => 15 [revenue_alloc] => 1270.36 [pick_up] => 15 [drop_date] => 2013-05-24 [revenue_pick_up] => 1270.36 [left_] => 0 [dropped] => 0 ) )
        foreach($res as $col ){
            echo '<td>'.$col.'</td>';
        }
        echo '</tr>';
    }

    echo '</table>';



    echo '<br/><br/>';
    // print_r($reservations);
}

?>
</body>

</html>