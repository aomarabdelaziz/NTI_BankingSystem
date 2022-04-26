<?php

if(!isset($_SESSION['user'])){


    header("Location: User/auth/login.php");


    exit();
}
else
{

    $role = $_SESSION['user']['role'];
    $serverUrl = $_SERVER['REQUEST_URI'];
    if($role == 'admin' && strpos($serverUrl , 'User')) {
        $url = url('Admin/index.php');
        header("Location: $url");
        exit();
    }
    else {
        $url = url('index.php');
        $fullUrl ='http://'.$_SERVER['HTTP_HOST'] . $serverUrl;

        if($role == 'admin' && $url == $fullUrl){
            $url = url('Admin/index.php');
            header("Location: $url");
            exit();
        }

    }



}


?>