<?php
include('include/init.php');
check_admin_login();
header("Location:admin_user.php?act=list");
?>