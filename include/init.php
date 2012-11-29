<?php
 @ini_set('memory_limit',          '64M');
 @ini_set('session.cache_expire',  180);
 @ini_set('session.use_trans_sid', 0);
 @ini_set('session.use_cookies',   1);
 @ini_set('session.auto_start',    1);
 @ini_set('display_errors',        1);
 session_start();
  include('config.php');
  include('cls_mysql.php');
  include('cls_admin.php');
  include('cls_reader.php');
  include('cls_current_reader.php');
  include('cls_book.php');
  include('function_common.php');
  $GLOBALS['db']=new cls_mysql($db_host, $db_user, $db_pass, $db_name);
  $clsbook=new cls_book();
  $clsadmin=new cls_admin();
  $clsreader=new cls_reader();
  $clscurrentreader=new cls_current_reader();
?>
