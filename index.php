<?php
include('include/init.php');
check_login();
header("Location:book.php?act=list");
?>