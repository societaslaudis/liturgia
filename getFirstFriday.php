<?php

//print date("Ymd",get_firstFriday("01","2014"));
function get_firstFriday($month,$year){
 	for ($i=0;$i<10;$i++) {
    $num = date("w",mktime(0,0,0,$month,$i,$year));
    if($num==5) return date("Ymd",mktime(0,0,0,$month,$i,$year));
 	}
}