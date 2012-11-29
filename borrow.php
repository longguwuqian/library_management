<?php
include('include/init.php');

check_login();
if(isset ($_REQUEST['act']))
{
    if(empty($_REQUEST['act']))
    {
        $_REQUEST['act']='search';
    }
}
else {
    $_REQUEST['act']='search';
}
if($_REQUEST['act']=='ajax')
{
    $bookname=trim($_REQUEST['bookname']);
    $bookid=$clsbook->name2id($bookname);
    if($bookid===false)
    {
        echo 'false';exit;
    }
    else
    {
        echo $bookid;exit;
    }
}
elseif($_REQUEST['act']=='back')
{
    $id=$_REQUEST['id'];
    if($clsbookmgr->change_state($id))
    {
        echo "<script language=javascript>alert('已成功归还');location.href='borrow.php?act=search'</script>";
    }
    else
    {
        echo "<script language=javascript>alert('归还失败');history.go(-1);</script>";
    }
    exit;
}
elseif($_REQUEST['act']=='saveadd')
{
    $keys=array ('borrow_book_id','borrow_name');
    $borrow=array();
    foreach($keys as $v)
    {
        $borrow[$v]=$_REQUEST[$v];
    }
    if($clsbookmgr->add_borrow($borrow))
    {
        echo "<script language=javascript>alert('已添加成功');location.href='borrow.php?act=search'</script>";
    }
    else {
        echo "<script language=javascript>alert('添加失败');history.go(-1);</script>";
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

#adminadd,#adminlist,#bookadd,#booksearch,#borrowadd,#borrowsearch{
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
        <tr><td width="200">
                <!--左边菜单开始-->
                <table id="menu" width="200" border="0" cellpadding="0" cellspacing="0">
                    <tr><th><a href="javascript:togglemenu(new Array('bookadd','booksearch'))">图书管理</a></th></tr>
                    <tr id="booksearch"><td><a href="book.php?act=search">查询图书</a></td></tr>
                    <tr><th><a href="javascript:togglemenu(new Array('borrowadd','borrowsearch'))">借阅管理</a></th></tr>
                    <tr id="borrowadd"><td><a href="borrow.php?act=add">添加借阅记录</a></td></tr>
                    <tr id="borrowsearch"><td><a href="borrow.php?act=search">查询借阅记录</a></td></tr>
                    <tr><th><a href="login.php?act=logout">退出</a></th></tr>
                </table>
                <!--左边菜单结束-->
            </td><td align="left" valign="top" style="margin-left: 10px;" width="600">
                <!--右边内容开始-->
                <?php
                  if($_REQUEST['act']=='add') {
                ?>
                <form action="borrow.php" method="post">
                    <table id="borrowaddtable" width="550" border="0" cellpadding="0" cellspacing="0">
                        <caption>添加借阅记录</caption>
                        <tr><td  colspan="2" style="color: #ff0000;" align="center" id="errorinfo"></td></tr>
                        <tr><td class="title"  width="150" align="right">书名：</td><td align="left"><input type="text" id="bookname" onchange="name2id()" name="book_name"/>
                        </td></tr>
                        <tr><td class="title"  width="150" align="right">&nbsp;
                                <input type="hidden" name="act" value="saveadd"/>
                                <input type="hidden" id="bookid" name="borrow_book_id" value="0"/>
                            </td><td align="left"><input type="submit" style="width: 50px;" value="添加"/>
                        </td></tr>
                    </table>
                </form>
                <?php
                    }
                    elseif($_REQUEST['act']=='search')
                    {
                        $keys=array('borrow_name'=>'姓名','borrow_time'=>'借书时间');
                        ?>
                 <form action="borrow.php" method="post">
                    <table id="borrowaddtable" width="550" border="0" cellpadding="0" cellspacing="0">
                        <caption>搜索书籍</caption>
                        <tr><td>条件：
                                <select name="condition">
                                    <?php foreach ($keys as $k => $v )
                                    {?>
                                    <option value="<?php echo $k?>"><?php echo $v ?></option>
                                    <?php
                                    }?>
                                </select>
                            </td><td>
                                关键字：<input name="keywords" type="text"/>
                                <input type="hidden" value="savesearch" name="act"/>
                            </td><td><input style="width:50px;" type="submit" value="搜索"/></td></tr>
                    </table>
                      </form>
                <?php
                    }
                    elseif($_REQUEST['act']=='savesearch')
                    {
                        $keys=array('borrow_name'=>'姓名','borrow_time'=>'借书时间');
                        $condition='A.'.$_REQUEST['condition'];
                        $keywords=$_REQUEST['keywords'];
                        $condition.=" like '%$keywords%' ";
                        $borrows=$clsbookmgr->search_borrow($condition);
                        ?>
                    <form action="borrow.php" method="post">
                    <table id="borrowaddtable" width="550" border="0" cellpadding="0" cellspacing="0">
                        <caption>搜索书籍</caption>
                        <tr><td>条件：
                                <select name="condition">
                                    <?php foreach ($keys as $k => $v )
                                    {?>
                                    <option value="<?php echo $k?>"><?php echo $v ?></option>
                                    <?php
                                    }?>
                                </select>
                            </td><td>
                                关键字：<input name="keywords" type="text"/>
                                <input type="hidden" value="savesearch" name="act"/>
                            </td><td><input style="width:50px;" type="submit" value="搜索"/></td></tr>
                    </table>
                    <br/>

                    <table id="borrowaddtable" width="550" border="0" cellpadding="0" cellspacing="0">
                        <tr><th>姓名</th><th>书名</th><th>状态</th><th>操作</th></tr>
                        <?php foreach($borrows as $borrow)
                        {
                            ?>
                        <tr>
                            <td><?php echo $borrow['borrow_name']?></td>
                            <td><?php echo $borrow['book_name']?></td>
                            <td><?php
                            if($borrow['borrow_state']==0)
                            {
                                echo '未归还!';
                            }
                            else
                            {
                                echo '已归还!';
                            }
                            ?></td>
                            <td><a <?php
                            if($borrow['borrow_state']!=0)
                            {
                                echo " onclick='return false;' ";
                            }
                            ?> href="borrow.php?act=back&id=<?php echo $borrow['book_id'] ?>">归还</a>
                            </td>
                        </tr>
                       <?php
                        }
                        ?>

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
            for(var i=0;i<objs.length;i++)
                {
                    $("#"+objs[i]).toggle(0);
                }
        }

        function name2id()
        {
            var booknamevalue=$("#bookname").val();
            var myDate = new Date();
            var params = { act:'ajax',rndtime:myDate.toLocaleTimeString(), bookname:booknamevalue};
            var str = jQuery.param(params);

            $.ajax({
               type: "POST",
               url: "borrow.php",
               data: "act=ajax&rndtime="+myDate.toLocaleTimeString()+"&bookname="+booknamevalue,
               success: function(data){
                    if(data!='false')
                    {
                        $("#bookid").val(data);
                        $("#errorinfo").html('');
                    }
                    else
                    {
                        $("#errorinfo").html('不存在该书籍！');
                    }
               }
            });
        }
    </script>
</body>
</html>