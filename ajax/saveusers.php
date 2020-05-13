<?php
if (isset($_POST["id"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	require_once ($rootH .'/core/tools.php');
	$link = InitDB();
	//$updatesql = 'UPDATE `nr32_users` SET `fio`=[fio],`login`=[login],`password`=md5(md5([password])),`canrun`=[canrun],`whoadm`=[whoadm],`dtreg`=[dtreg] WHERE  `id`=[id]';
	//$insertsql = 'INSERT INTO `nr32_users`( `fio`, `login`, `password`, `canrun`, `whoadm`, `dtreg`) VALUES ([fio],[login],md5(md5([password])),[canrun],[whoadm],[dtreg])';
	if($_POST["id"]==0)
	{
	    //$sql = $insertsql;
		$sql = makeSQL('nr32_users',$_POST,'insert');
	}
	else
	{
	    //$sql = $updatesql;
		$sql = makeSQL('nr32_users',$_POST,'update');
	}
	
	/*foreach ($_POST as $key=>$val)
	{
	    $sql = str_replace('['.$key.']','"'.$val.'"',$sql);
	}*/
	
	echo '['.$sql.']';
	//print_r($_POST);
	
	$query = mysqli_query($link,$sql)or die("Ошибка записи пользователя");
	mysqli_free_result($query);
	closeDB($link);
}
else
{
    print_r($_POST);
}