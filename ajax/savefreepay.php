<?php
if (isset($_POST["id"]))
{
    $tabname ='nr32_freepay';
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
	
		
	
	$query = mysqli_query($link,$sql)or die("Ошибка записи [$sql] \n ".mysqli_error($link));
	closeDB($link);
}
else
{
    print_r($_POST);
} 