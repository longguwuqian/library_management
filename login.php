<?php
include('include/init.php');

$error='';
if(isset ($_REQUEST['act'])&&$_REQUEST['act']=='login')
{
    if($clscurerentreader->login($_REQUEST['reader_name'],$_REQUEST['reader_pwd'])==false) {
        $error='用户名或密码错误!';
    } else {
        header("Location:index.php");
        exit;
    }
}
if(isset ($_REQUEST['act'])&&$_REQUEST['act']=='logout')
{
    $clscurrentreader->logout();
    header("Location:login.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>图书管理系统管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
    body{
        text-align: center;
        background-color: #278296;
        color: #ffffff;
        font-weight: 600;
        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
}
form{
     margin: 0px;
     padding: 0px;
     margin-top: 150px;
}
table{
    margin: 0px;
    padding: 0px;
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
    margin-bottom: auto;
    width: 100%;
}
input{
    width: 142px;
}
#caption{
    font-size: 36px;
    font-family: Arial Black;
    line-height: 35px;
    margin-bottom: 20px;
}
tr{
    line-height: 30px;
}
</style>
</head>

<body>
    <form action="login.php" method="post">
        <table border="0" cellpadding="0" cellspacing="0">
            <tr><td  colspan="2" id="caption" align="center">图书管理系统管理中心</td></tr>
            <tr><td  colspan="2" style="color: #ff0000;" align="center"><?php echo $error?></td></tr>
            <tr><td width="50%" align="right">用户名：</td><td align="left"><input type="text" name="reader_name"/></td></tr>
            <tr><td width="50%" align="right">密码：</td><td align="left"><input type="password" name="reader_pwd"/></td></tr>
            <tr><td width="50%" align="right">&nbsp;<input type="hidden" value="login" name="act"/></td><td align="left"><input type="submit" value="进入管理中心"/></td></tr>
        </table>
    </form>
</body>
</html>