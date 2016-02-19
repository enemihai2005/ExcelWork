<?php
// include 'path/to/PHPExcel/IOFactory.php';
// require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
include dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';
include '../Classes/Sys.php';
// Let IOFactory determine the spreadsheet format
$document = PHPExcel_IOFactory::load('report.xls');

// Get the active sheet as an array
$activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);

// var_dump($activeSheetData);
// print_r($activeSheetData);
//echo 'The total is: '.$activeSheetData[8]['E'].'<br/>';



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
    if(isset($_REQUEST['view'])){
        echo 'ISSET';
        $filename = $_REQUEST['view'];
        $document = PHPExcel_IOFactory::load('uploads/'.$filename);
        $activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
        $letters = range('A', 'K');
        echo '<table border="1">';
        echo '<tr>';
        foreach($letters as $letter){
            echo '<th>'.$letter.'</th>';
        }
        echo '</tr>';

        for($i=1; $i<7; $i++){
            echo '<tr>';
            foreach($letters as $letter){
                echo '<td>'.$activeSheetData[$i][$letter].'</td>';
            }
            echo '</tr>';
        }




        echo '</table>';

    }
?>

