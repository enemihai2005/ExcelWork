<?php
include '../Classes/Sys.php';

require_once '../DataAccessObjects/DAOMySQLHotelGroup.php';
require_once '../DataAccessObjects/DAOExcelHotelGroup.php';


?>

<!doctype html>
<html>
<head>
    <title>Line Chart</title>
    <script src="Chart.js-master/Chart.js"></script>
</head>
<body>
<div style="width:30%">
    <div>
        <canvas id="canvas" height="450" width="600"></canvas>
    </div>
</div>


<script>
    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var lineChartData = {
        labels : ["January","February","March","April","May","June","July"],
        datasets : [
            {
                label: "My First dataset",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
            },
            {
                label: "My Second dataset",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
            }
        ]

    }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }


</script>

<?php


if(isset($_REQUEST['viewreservationsfor'])){
    $idGroup = $_REQUEST['viewreservationsfor'];

    $daoMySQL = new DAOMySQLHotelGroup();
    $reservations = $daoMySQL->selectReservationsForGroup($idGroup);


    $titles = array('Id','Arrival','Departure', 'Group Name',  'Alloc', 'Revenue Alloc', 'PickUp', 'Drop date', 'Revenue Pick Up', 'Left', 'Dropped');


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

}



?>

</body>
</html>
