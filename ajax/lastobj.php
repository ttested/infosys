<?php
if (isset($_POST['table']))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    $sql = "SELECT tab.id FROM nr32_$table tab ORDER BY tab.id DESC LIMIT 1";
    $query = mysqli_query($link,$sql)or die("Ошибка получения последней записи `$sql`");
    $data  = mysqli_fetch_assoc($query);
    if (isset($data))
    {
        echo $data['id'];
    }
    else {
        echo 0;
    }
}
else {
    echo 0;
}
