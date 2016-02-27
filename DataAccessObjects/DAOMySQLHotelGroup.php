<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIKE
 * Date: 2/27/16
 * Time: 2:02 PM
 * To change this template use File | Settings | File Templates.
 */

require_once '../service/DBUtil.php';

class DAOMySQLHotelGroup {

    public function saveHotelGroup($hg){

    }

    public  function selectAll(){
        // SELECT * FROM groups; EUsunt back "
        $conn = getConnection();
        $groupsCursor = $conn->query("SELECT * FROM groups");
        $groupsArray = array();
        while(($group = $groupsCursor->fetch_assoc()) != null){
            $groupsArray[] = $group;
        }
        return $groupsArray;
    }
}