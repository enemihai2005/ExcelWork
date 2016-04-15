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



<h2>Add new report</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select XLS file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Excel File" name="submit">
</form>

<h2>XLS Report files available</h2>
<?php
$dir = "uploads/";
if (is_dir($dir)){
    if ($dh = opendir($dir)){
        echo '<ul>';
        while (($file = readdir($dh)) !== false){
            if(strlen($file) < 3){

            }else{
                echo "<li><a href='?view=$file'>" . $file . "</a></li>";
            }
        }
        echo '<ul>';
        closedir($dh);
    }
}

?>

<?php
    $titles = array('Group','Name','Arrival','Departure','Drop Date', 'Alloc', 'Revenue Alloc', 'PickUp', 'Revenue Pick Up', 'Left', 'Dropped');

    if(isset($_REQUEST['view'])){
        // echo 'ISSET';
        echo '<br/>';
        $filename = $_REQUEST['view'];
        $daoExcel = new DAOExcelHotelGroup();
        $everything = $daoExcel->loadInfoFromExcel($filename, 100); // ugly stuff Excel working stuff
        echo '<table border="1">';
        echo '<tr>';
        foreach($titles as $t){
            echo '<th>'.$t.'</th>';
        }
        echo '</tr>';


        foreach($everything as $line){
            echo '<tr>';

            foreach($line as $column){
                echo '<td>'.$column.'</td>';
            }
            echo '</tr>';
        }

        echo '</table>';

        echo '<hr/>';
        $group = $daoExcel->getGroupFromExcelROW($everything[0]);
        // print_r($group);

        ?>

        <h3>Save</h3>
        <form>
            <input type="text" name="file_to_db" value="<?php echo $filename ?>"/>
            <input type="submit" value="Save File Contents to DB"/>
        </form>
        <?php



    }
    if(isset($_REQUEST['file_to_db'])){
        $filename = $_REQUEST['file_to_db'];
        $daoExcel = new DAOExcelHotelGroup();
        $daoMySQL = new DAOMySQLHotelGroup();
        $everything = $daoExcel->loadInfoFromExcel($filename, 500);
        foreach($everything as $line){
            $group = $daoExcel->getGroupFromExcelROW($line);
            // print_r($group);
            $reservation = $daoExcel->getReservationFromExcelROW($line);
            $daoMySQL->saveHGToDB_withID($group);
            $reservation->groupName = $group->name;
            $daoMySQL->saveReservationToDB($reservation);


        }
        echo "<span style='color: blue;'>Information saved to MySQL, please check 'groups' table</span>";
    }



echo '<hr/>';
echo '<h2>Groups from DB (MySQL)</h2>';
$dao = new DAOMySQLHotelGroup();
$allHotelGroupsMySQL = $dao->selectAllGroups(); // ugly stuff SQL / MySQL
echo '<ul>';
// TODO: use POST --- # gets misinterpreted by the browser
foreach($allHotelGroupsMySQL as $gp){
    echo '<li>';
    echo $gp['id'].' '.$gp['group_name'].' <a href="?delid='.$gp['id'].'">Delete Group</a> &nbsp; <a href="?viewreservationsfor='.$gp['group_name'].'">View Reservations</a><br/>';
    echo '</li>';
}
echo '</ul>';


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

