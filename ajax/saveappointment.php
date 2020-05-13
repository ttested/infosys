<?php
if (isset($_POST["id"]))
{
    $tabname = 'nr32_dict_appointments';
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	require_once ($rootH .'/core/tools.php');
	$link = InitDB();
	if($_POST["id"]==0)
	{
		$sql = makeSQL($tabname,$_POST,'insert');
	}
	else
	{
		$sql = makeSQL($tabname,$_POST,'update');
	}
	
	echo '['.$sql.']';
	
	$query = mysqli_query($link,$sql)or die("Ошибка записи ");
	//mysqli_free_result($query);
	closeDB($link);
}
else
{
    print_r($_POST);
} 