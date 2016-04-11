<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIKE
 * Date: 2/27/16
 * Time: 2:02 PM
 * To change this template use File | Settings | File Templates.
 */

include dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

require_once '../model/HotelGroup.php';


/**
 * Class DAOExcelHotelGroup
 * class which allows us to read information from the XLS file and put the information into Php arrays and objects
 * (in this case in HotelGroup objects)
 *
 */
class DAOExcelHotelGroup {

    /**
     * Method reading information in a XLS file and returns an array of HotelGroup objects (for convenience, easier to parse)
     * @param $fileName
     * @return array
     */
    public function loadFromExcel($fileName){

        $hotelGroupsFromExcel = array();
        $document = PHPExcel_IOFactory::load('uploads/'.$fileName);
        $activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
        for($i=2; $i<7; $i++){
                // echo '<td>'.$activeSheetData[$i][$letter].'</td>';
                $hotelGroup = array('id' => $activeSheetData[$i]['A'], 'group_name'=>$activeSheetData[$i]['B']);
                $hotelGroupsFromExcel[]= $hotelGroup;

        }
        return $hotelGroupsFromExcel;
    }


    /**
     * @param $fileName the name of the XLS file which will be used (from the uploads directory)
     * the file must have already been uploaded
     * the function reads the XLS file line by line and returns a Php array representing the information in the Excel document
     * @return array
     */
    public function loadInfoFromExcel($fileName, $limit = 100){
        $document = PHPExcel_IOFactory::load('uploads/'.$fileName);
        $activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
        $everything = array();
        $letters = range('A', 'K');

        for($i=2; $i<$limit; $i++){
               if(isset($activeSheetData[$i])){
                $line = array();
                foreach($letters as $letter){
                    $line[] = $activeSheetData[$i][$letter];
                }
                $everything[] = $line;
                }
        }

        return $everything;
    }

    /**
     * @param $row The row which will be transformed from a simple array into a HotelGroup object
     * @return HotelGroup a HotelGroup object
     */
    public function getGroupFromExcelROW($row){
        // echo 'ROW::::';
        // print_r($row);
        $group = new HotelGroup();
        $group->id = $row[0];
        $group->name = $row[1];
        return $group;
    }
}