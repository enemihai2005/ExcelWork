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