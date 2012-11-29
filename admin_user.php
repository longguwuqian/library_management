<?php
include('include/init.php');

check_admin_login();
if(isset ($_REQUEST['act']))
{
    if(empty($_REQUEST['act'])) {
        $_REQUEST['act']='list';
    }
} else {
    $_REQUEST['act']='list';
}

if($_REQUEST['act']=='saveadd')
{
    $keys=array ('admin_name', 'admin_pwd');
    $admin=array();
    foreach($keys as $v) {
        $admin[$v]=$_REQUEST[$v];
    }
    if($clsadmin->add_admin($admin)) {
        echo "<script language=javascript>alert('已添加成功');location.href='admin_user.php?act=list'</script>";
    } else {
        echo "<script language=javascript>alert('添加失败');history.go(-1);</script>";
    }
    exit;
} elseif($_REQUEST['act']=='delete') {
    $id=$_REQUEST['id'];
    if($clsadmin->delete_admin($id)) {
        echo "<script language=javascript>alert('已删除成功');location.href='admin_user.php?act=list'</script>";
    } else {
        echo "<script language=javascript>alert('删除失败');history.go(-1);</script>";
    }
    exit;
} elseif($_REQUEST['act']=='saveedit') {
    $keys=array ('pwd');
    $id=$_REQUEST['id'];
    $admin=array();
    foreach($keys as $v) {
        $admin[$v]=md5($_REQUEST[$v]);
    }
    if($clsadmin->edit_admin($id, $admin)) {
        echo "<script language=javascript>alert('已修改成功');location.href='admin_user.php?act=list'</script>";
    } else {
        echo "<script language=javascript>alert('修改失败');history.go(-1);</script>";
    }
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>图书管理系统管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<style type="text/css">
    body{
        text-align: center;
        background-color: #278296;
        color: #ffffff;
        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
        font-size: 12px;
}
form{
     margin: 0px;
     padding: 0px;
     margin-top:0px;
}
table{
    margin: 0px;
    padding: 0px;
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
    margin-bottom: auto;
}
a{
    color: #ffffff;
    text-decoration: none;
}
a:hover{
    color: #f68704;
    text-decoration: underline;
}

#menu a{
    font-size: 16px;
}
td{
    text-align: left;
}
th a:hover{
    color: #f68704;
    font-weight: 900;
    font-size: 18px;
    text-decoration: none;
}

th{
    text-align: center;
}

#menu tr{
    line-height: 30px;
}

#adminadd,#adminlist,#readeradd,#readerlist,#bookadd,#booksearch,#borrowadd,#borrowsearch,#booklist{
    display: none;
}

input{
    width: 200px;
}

#borrowaddtable{

}
.title {
    text-align: right;
    font-size: 14px;
    font-weight: 700;
}
caption{
    font-size: 30px;
    font-weight: 900;
}

</style>
</head>

<body>
    <table width="800" border="0" cellpadding="0" cellspacing="0">
        <tr><td valign="top" width="200">
                <!--左边菜单开始-->
                <table  id="menu" width="200" border="0" cellpadding="0" cellspacing="0">
                    <tr><th><a href="javascript:togglemenu(new Array('adminadd','adminlist'))">管理员管理</a></th></tr>
                    <tr id="adminadd"><td><a href="admin_user.php?act=add">添加管理员</a></td></tr>
                    <tr id="adminlist"><td><a href="admin_user.php?act=list">管理员列表</a></td></tr>
                    <tr><th><a href="javascript:togglemenu(new Array('readeradd','readerlist'))">读者管理</a></th></tr>
                    <tr id="readeradd"><td><a href="admin_reader.php?act=add">添加读者</a></td></tr>
                    <tr id="readerlist"><td><a href="admin_reader.php?act=list">读者列表</a></td></tr>
                    <tr><th><a href="javascript:togglemenu(new Array('bookadd','booksearch', 'booklist'))">图书管理</a></th></tr>
                    <tr id="bookadd"><td><a href="admin_book.php?act=add">添加图书</a></td></tr>
                    <tr id="booksearch"><td><a href="admin_book.php?act=search">查询图书</a></td></tr>
                    <tr id="booklist"><td><a href="admin_book.php?act=list">图书列表</a></td></tr>
                    <tr><th><a href="admin_login.php?act=logout">退出管理</a></th></tr>
                </table>
                <!--左边菜单结束-->
            </td><td align="left" valign="top" style="margin-left: 10px;" width="600">
                <!--右边内容开始-->
                <?php
                    if($_REQUEST['act']=='add')
                    {
                        ?>
                <form onsubmit="return checkform();" action="admin_user.php" method="post">
                    <table id="borrowaddtable" width="550" border="0" cellpadding="0" cellspacing="0">
                        <caption>添加管理员</caption>
                        <tr><td  colspan="2" style="color: #ff0000;" align="center" id="errorinfo"></td></tr>
                        <tr><td class="title"  width="150" align="right">用户名：</td><td align="left"><input type="text" name="admin_name"/>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">密码：</td><td align="left"><input type="password" id="admin_pwd" name="admin_pwd"/>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">确认密码：</td><td align="left"><input type="password" id="admin_pwd2" name="admin_pwd2"/>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">&nbsp;
                                <input type="hidden" name="act" value="saveadd"/>
                            </td><td align="left"><input type="submit" style="width: 50px;" value="添加"/>
                        </td></tr>
                    </table>
                </form>
                <?php
                    }
                    elseif($_REQUEST['act']=='list')
                    {
                        $admins=$clsadmin->list_admin();
                        ?>

                    <table id="borrowaddtable" width="500" border="2">
                        <caption>管理员列表</caption>
                        <tr>
                            <th>用户名</th>
                            <th>操作</th>
                        </tr>
                        <?php
                        foreach($admins as $admin) {
                        ?>
                        <tr>
                            <td><?php echo $admin['admin_name'] ?></td>
                            <td><a href="admin_user.php?act=edit&id=<?php echo $admin['admin_id'] ?>">编辑</a>&nbsp;|
                                <a href="admin_user.php?act=delete&id=<?php echo $admin['admin_id'] ?>">删除</a>&nbsp;
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                <?php
                    }
                    elseif($_REQUEST['act']=='edit')
                    {
                        $id=$_REQUEST['id'];
                        $admin=$clsadmin->get_admin_by_id($id);
                        
                        ?>
                <form onsubmit="return checkform();" action="admin_user.php" method="post">
                    <table id="adminaddtable" width="550" border="2">
                        <caption>修改管理员</caption>
                        <tr><td  colspan="2" style="color: #ff0000;" align="center" id="errorinfo"></td></tr>
                        <tr><td class="title"  width="150" align="right">用户名：</td><td align="left"><?php echo $admin['admin_name'] ?>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">新密码：</td><td align="left"><input type="password" id="admin_pwd" name="admin_pwd"/>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">确认密码：</td><td align="left"><input type="password" id="admin_pwd2" name="admin_pwd2"/>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">&nbsp;
                                <input type="hidden" name="act" value="saveedit"/>
                                <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id'] ?>"/>
                            </td><td align="left"><input type="submit" style="width: 50px;" value="修改"/>
                        </td></tr>
                    </table>
                </form>
                <?php
                    }
                ?>
                <!--右边内容结束-->
            </td></tr>
    </table>
    <script language="javascript">
        function togglemenu(objs)
        {
            for(var i=0;i<objs.length;i++) {
                    $("#"+objs[i]).toggle(0);
            }
        }

        function checkform()
        {
            if($("#admin_pwd").val()!=$("#admin_pwd2").val()) {
                $("#errorinfo").html('两次密码不相同!');
                return false;
            } else {
                return true;
            }

        }
    </script>
</body>
</html>