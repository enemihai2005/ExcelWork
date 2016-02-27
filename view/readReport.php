<?php
include '../Classes/Sys.php';

require_once '../DataAccessObjects/DAOMySQLHotelGroup.php';
require_once '../DataAccessObjects/DAOExcelHotelGroup.php';


?>
<h2>Add new report</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<h2>XLS Reports available</h2>
<?php
$dir = "uploads/";
if (is_dir($dir)){
    if ($dh = opendir($dir)){
        echo '<ul>';
        while (($file = readdir($dh)) !== false){
            if(strlen($file) < 3){

            }else{
                echo "<li><a href='?view=$file'>filename:" . $file . "</a></li>";
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
        echo 'ISSET';
        $filename = $_REQUEST['view'];
        $daoExcel = new DAOExcelHotelGroup();
        $everything = $daoExcel->loadInfoFromExcel($filename); // ugly stuff Excel working stuff
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

    }



echo '<hr/>';
echo '<h2>Groups from DB(MySQL)</h2>';
$dao = new DAOMySQLHotelGroup();
$allHotelGroupsMySQL = $dao->selectAll(); // ugly stuff SQL / MySQL
foreach($allHotelGroupsMySQL as $gp){
    echo $gp['id'].' '.$gp['group_name'].'<br/>';
}

// print_r($allHotelGroupsMySQL);
?>

