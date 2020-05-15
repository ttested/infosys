<?php
if (isset($_POST["id"]))
{
    $tabname = 'nr32_executors';
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
	
	//echo '['.$sql.']';
	
	mysqli_query($link,$sql)or die("Ошибка записи ");
    closeDB($link);
    
    echo $_POST["id"];
}
else
{
    print_r($_POST);
} 