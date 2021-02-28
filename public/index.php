<?php
// Start a Session
//if( !session_id() ) @session_start();



require '../vendor/autoload.php';
require '../app/start.php';


function redirect($path)
{
    header("Location: $path");
    exit;
}
function set_status($status){
    $result='';
    if($status=='Онлайн'){
        $result='success';
    }elseif ($status=='Отошел'){
        $result='warning';
    }elseif ($status=='Не беспокоить'){
        $result='danger';
    }
    return $result;
}
function hasImage($image){
    if(empty($image)){
        echo 'noneAvatar.png';
    }else{
        echo $image;
    }
}