<?php
include('include/init.php');

check_admin_login();
if(isset ($_REQUEST['act'])) {
    if(empty($_REQUEST['act'])) {
        $_REQUEST['act']='search';
    }
} else {
    $_REQUEST['act']='list';
}
if($_REQUEST['act']=='borrow') {



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
                    if($_REQUEST['act']=='search')
                    {
                        $keys=array('book_name'=>'书名','author'=>'作者','publishing'=>'出版社','date_in'=>'购买日期',
        'price'=>'价格','quantity_in'=>'购买量','quantity_out'=>'借出量','quantity_loss'=>'丢失数量');
                        ?>
                      <form action="admin_book.php" method="post">
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
                        $keys=array('book_name'=>'书名','author'=>'作者','publishing'=>'出版社','date_in'=>'购买日期',
        'price'=>'价格','quantity_in'=>'购买量','quantity_out'=>'借出量','quantity_loss'=>'丢失数量');
                        $condition=$_REQUEST['condition'];
                        $keywords=$_REQUEST['keywords'];
                        $condition.=" like '%$keywords%' ";
                        $books=$clsbook->search_book($condition);
                        
                        ?>
                <form action="admin_book.php" method="post">
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
                        <tr><th>书名</th><th>操作</th></tr>
                        <?php foreach($books as $book)
                        {
                            ?>
                        <tr><td><?php echo $book['book_name']?></td>
                            <td><a href="book.php?act=borrow&id=<?php echo $book['book_id'] ?>">借阅</a>&nbsp;|
                            </td>
                        </tr>
                       <?php
                        }
                        ?>

                    </table>
                      </form>
                <?php
                    }
                    elseif($_REQUEST['act']=='list')
                    {
                        $books=$clsbook->list_book();
                        ?>

                    <table id="borrowaddtable" width="500" border="2">
                        <caption>图书列表</caption>
                        <tr>
                            <th>书名</th>
                            <th>操作</th>
                        </tr>
                        <?php
                        foreach($books as $book) {
                        ?>
                        <tr>
                            <td><?php echo $book['book_name'] ?></td>
                            <td><a href="book.php?act=edit&id=<?php echo $book['book_id'] ?>">借阅</a>&nbsp;|
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
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