<?php
class Sys{

    public $color;
    public $version;

    public static $company;

    public static function println($msg){
        echo $msg.'<br/>';
    }

    public function dc(){
        echo $this->color.'<br/>';
    }

    public function info(){
        echo $this->version.' '.$this->color.' '.self::$company.'<br/>';
    }

}

// CLASSNAME::METHOD(PARAMS)
// CLASSNAME::METHOD()

/*

Sys::println('hello');
Sys::println('world');

// Sys::$color = 'Red';

$s1 = new Sys();
$s2 = new Sys();

$s1->color = 'Blue';
$s1->version = 10.10;
$s2->color = 'Yellow';
$s2->version = 12.12;

Sys::$company = 'MICROSOFT!!!!';
Sys::$company = 'IBM';
$s1->info();
$s2->info();
*/