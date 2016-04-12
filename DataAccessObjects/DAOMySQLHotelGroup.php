<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIKE
 * Date: 2/27/16
 * Time: 2:02 PM
 * To change this template use File | Settings | File Templates.
 */

require_once '../service/DBUtil.php';
require_once '../model/HotelGroup.php';
require_once '../model/Reservation.php';

/**
 * Class DAOMySQLHotelGroup
 * class which allows us to read and write information to / from MySQL database
 * in order to see which database is used,visit DBUtil.php (the file which allows us to connect to the database)
 */
class DAOMySQLHotelGroup {



    /***
     * SELECT all informaton pertaining to groups from MySQL's 'groups' table and return an array
     * @return array
     */
    public  function selectAll(){
        $conn = getConnection();
        $groupsCursor = $conn->query("SELECT * FROM groups");
        $groupsArray = array();
        while(($group = $groupsCursor->fetch_assoc()) != null){
            $groupsArray[] = $group;
        }
        return $groupsArray;
    }

    /**
     * Save a hotel group object to MySQL
     * (i.e. transform a HotelGroup object into a MySQL row)
     * @param HotelGroup $group
     */
    public function saveHGToDB(HotelGroup $group){
        $conn = getConnection();
        $groupName = $group->name;
        $query = "INSERT INTO groups(group_name) VALUES('$groupName')";
        $conn->query($query);
    }

    /**
     * Same as the above, however also insert a value for the ID (useful when reading Excel documents which already
     * have IDs assigned)
     * @param HotelGroup $group
     */
    public function saveHGToDB_withID(HotelGroup $group){
        $conn = getConnection();
        $groupName = $group->name;
        $groupId = $group->id;
        $query = "INSERT INTO groups(id, group_name) VALUES($groupId, '$groupName')";
        $conn->query($query);
    }

    public function excelDateToMySQLDate($d){
        $dateInt = (int)$d;
        return date('Y-m-d',strtotime('1899-12-31+'.($dateInt-1).' days'));

    }

    // $1,476.11 to 1476
    public function getMoneyFromExcelColumn($excelMoney){
        echo 'ABOUT TO CONVERT TO A DOUBLE VALUE(ceva.ceva) THE SUM: '.$excelMoney.'<br/>';
        if(isset($excelMoney)){
            $excelMoney = str_replace("$", "", $excelMoney);

            $bigMoney = explode(".", $excelMoney);
            print_r($bigMoney);
            $dollars = $bigMoney[0];
            $cents = $bigMoney[1];
            $noCommas = str_replace(",", "", $dollars);

            $moneyAsDouble = (double)"$noCommas.$cents";
            echo 'CONVERTED TO DOUBLE: '.$moneyAsDouble.'<br/><br/>';
            return $moneyAsDouble;
        }
        return 0;
    }

    public function saveReservationToDB(Reservation $reservation){
        $conn = getConnection();
        $arrival = $this->excelDateToMySQLDate($reservation->arrival);
        $departure = $this->excelDateToMySQLDate($reservation->departure);
        $group_name = $reservation->groupName;
        $alloc = $reservation->alloc;
        $revenue_alloc = $reservation->revenueAlloc;  // money
        $revenue_alloc = $this->getMoneyFromExcelColumn($revenue_alloc);
        $pick_up = $reservation->pickUp;
        $drop_date = $this->excelDateToMySQLDate($reservation->dropDate);
        $revenue_pick_up = $reservation->revenuePickUp;  // money
        $revenue_pick_up = $this->getMoneyFromExcelColumn($revenue_pick_up);
        $left_  = $reservation->left;
        $dropped = $reservation->dropped;

        $query = "INSERT INTO reservations(arrival, departure, group_name, alloc, revenue_alloc, pick_up, drop_date, revenue_pick_up, left_, dropped)
                VALUES ('$arrival', '$departure', '$group_name', $alloc, $revenue_alloc, $pick_up, '$drop_date', $revenue_pick_up, $left_, $dropped)";
        echo 'ABOUT TO EXECUTE QUERY: ';
        print_r($query);
        $conn->query($query);
    }

    /**
     * Method which deletes a row from the 'groups' table in MySQL
     * The row is identified by an ID (in this case the value of the $id parameter)
     * @param $id the id of the MySQL row to delete
     */
    public function deleteGroup($id){
        $conn = getConnection();
        $query = "DELETE FROM groups WHERE id = $id";
        $conn->query($query);
    }
}