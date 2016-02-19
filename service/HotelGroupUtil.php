<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIKE
 * Date: 2/13/16
 * Time: 10:38 AM
 * To change this template use File | Settings | File Templates.
 */

include '../model/HotelGroup.php';

function computeTotal($arrayGroups){
    $totalAllocated = 0;
    foreach($arrayGroups as $hg){
        $totalAllocated += $hg->alloc;
    }

    echo 'Total allocated: '.$totalAllocated.'<br/>';
}

// test

$hg1 = new HotelGroup();
$hg1->id = 2110;
$hg1->alloc = 30;
$hg1->name = 'Mindfulness Meditation';

$hg2 = new HotelGroup();
$hg2->id = 2302;
$hg2->alloc = 22;
$hg2->name = '2Portsmouth Yacht 16';

$groups = array($hg1, $hg2);
computeTotal($groups);