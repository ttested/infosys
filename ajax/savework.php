<?php
 if (isset($_POST["idbuilding"]))
 {
 	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');

	$link =  InitDB();
    $idbuilding = $_POST["idbuilding"];
	 
	//получаем список этапов для объекта строитеьлства 
	$sql = "SELECT ns.id FROM nr32_smeta ns WHERE ns.id_building=$idbuilding";
	$query = mysqli_query($link,$sql)or die("Ошибка чтения [$sql] \n ".mysqli_error($link));

	$codes='';
	$updcod=[];
	$addcod=[];
	$allcod=[];
	while($data  = mysqli_fetch_assoc($query))
	{
		$allcod[]=$data['id'];
		
		if ($codes=='')
		{
			$codes = $data['id'];
		}
		else
		{
			$codes .= ', '.$data['id'];
		}
	}

	// Получаем список кодов на обновление
	$sql = "SELECT nw.id_smetaobj FROM nr32_workplan nw WHERE nw.id_building = $idbuilding AND nw.id_smetaobj IN ($codes)";
	$query = mysqli_query($link,$sql)or die("Ошибка чтения [$sql] \n ".mysqli_error($link));
	while($data  = mysqli_fetch_assoc($query))
	{
		$updcod[]=$data['id_smetaobj'];
	} 
	mysqli_free_result($query);

	//Получаем список кодов на добавление
	$addcod= array_diff($allcod,$updcod);

	//Формируем запрос на добавление
	$sql = "INSERT INTO nr32_workplan (id_building, id_smetaobj, id_brigada, datebegin, dateend) VALUES ";

	foreach($addcod as $cod)
	{
		$dtfrom = $_POST["dtfrom$cod"];
		$dtto	= $_POST["dtto$cod"];
		$brigada= $_POST["brigada$cod"];
		if ($sql == "INSERT INTO nr32_workplan (id_building, id_smetaobj, id_brigada, datebegin, dateend) VALUES ")
		{$sql .="($idbuilding, $cod, $brigada,'$dtfrom', '$dtto')";}
		else {
			$sql .=",($idbuilding, $cod, $brigada,'$dtfrom', '$dtto')";
		}
	}
	mysqli_query($link,$sql)or die("Ошибка чтения [$sql] \n ".mysqli_error($link));
	
	//Формируем запрос на обновление
	foreach ($addcod as $cod)
	{
		$dtfrom = $_POST["dtfrom$cod"];
		$dtto	= $_POST["dtto$cod"];
		$brigada= $_POST["brigada$cod"];
		if ($cod>0)
		{$sql = "DATE nr32_workplan nw SET nw.id_brigada = $brigada, nw.datebegin = '$dtfrom', nw.dateend = '$dtto' WHERE nw.id_building=$idbuilding AND nw.id_smetaobj = $cod";
		mysqli_query($link,$sql)or die("Ошибка чтения [$sql] \n ".mysqli_error($link));}
	}
	

	closeDB($link);	
 }
// {
//     $tabname ='nr32_building';
// 	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
// 	require_once ($rootH .'/core/db.php');
// 	require_once ($rootH .'/core/tools.php');
// 	$link = InitDB();
// 	if($_POST["id"]==0)
// 	{
// 		if (isset($_POST["typpay"]))
// 		{
// 			$typpay = $_POST["typpay"];
// 			$sql = makeSQLXT($tabname,$_POST,'insert','typpay',$typpay );
// 		}
// 		else
// 		{	
// 			$sql = makeSQL($tabname,$_POST,'insert');
// 		}
// 	}
// 	else
// 	{
// 		if (isset($_POST["typpay"]))
// 		{
// 			$typpay = $_POST["typpay"];
// 			$sql = makeSQLXT($tabname,$_POST,'update','typpay',$typpay );
// 		}
// 		else
// 		{
// 			$sql = makeSQL($tabname,$_POST,'update');
// 		}
// 	}
	
// 	//echo '['.$sql.']';
	
// 	$query = mysqli_query($link,$sql)or die("Ошибка записи [$sql] \n ".mysqli_error($link));
// 	closeDB($link);
// }
 else
 {
    print_r($_POST);
} 