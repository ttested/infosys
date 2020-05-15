<?php
if (isset($_POST["id"]))
{
    $tabname ='nr32_building';
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	require_once ($rootH .'/core/tools.php');
	$link = InitDB();
	if($_POST["id"]==0)
	{
		if (isset($_POST["typpay"]))
		{
			$typpay = $_POST["typpay"];
			$sql = makeSQLXT($tabname,$_POST,'insert','typpay',$typpay );
		}
		else
		{	
			$sql = makeSQL($tabname,$_POST,'insert');
		}
	}
	else
	{
		if (isset($_POST["typpay"]))
		{
			$typpay = $_POST["typpay"];
			$sql = makeSQLXT($tabname,$_POST,'update','typpay',$typpay );
		}
		else
		{
			$sql = makeSQL($tabname,$_POST,'update');
		}
	}
	
	//echo '['.$sql.']';
	
	mysqli_query($link,$sql)or die("Ошибка записи [$sql] \n ".mysqli_error($link));
	$sql = "SELECT tab.id FROM $tabname tab ORDER BY tab.id DESC LIMIT 1";
    $query = mysqli_query($link,$sql)or die("Ошибка получения последней записи `$sql`");
	$data  = mysqli_fetch_assoc($query);
	echo $data['id'];
	closeDB($link);
}
else
{
   echo 'Ошибка входных параметров: ';
   print_r($_POST);
} 