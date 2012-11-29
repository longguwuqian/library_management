<?php
function check_login()
{
    if(!isset ($_SESSION['reader'])) {
        header('Location:login.php');
        exit;
    } else {
        if(is_array($_SESSION['reader'])) {
            return true;
        } else {
            header('Location:login.php');
            exit;
        }
    }
}

function check_admin_login()
{
    if(!isset ($_SESSION['admin'])) {
        header('Location:admin_login.php');
        exit;
    } else {
        if(is_array($_SESSION['admin'])) {
            return true;
        } else {
            header('Location:admin_login.php');
            exit;
        }
    }
}

?>
