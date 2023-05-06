<?php 



function isCharged($value)
{
    if ($value == '' || $value == null) {
        return "0";
    } else {
        return $value;
    }
}


function isChecked($value){

    if(isset($_REQUEST[$value])){
        return 1;
    } else {
        return 0;
    }
}







?>