<?php
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	$sql = 'SELECT * FROM nr32_v_calendar WHERE data = "'.$_POST['paypercent'].'"' ;
	$query = mysqli_query($link,$sql)or die("Ошибка построения даты [$sql]");
	$rec =  mysqli_fetch_assoc($query);
	$iddey = $rec['id'];
	$idbrigada = $_POST['idbrigada'];
	
	for ($i=1; $i<=$_POST['count']; $i++)
	{
		$idpeople = $_POST['idpeople'.$i];
		$whour[$idpeople] = $_POST['whour'.$i]; 
		$remarc[$idpeople] = $_POST['remarc'.$i];
		if ($i==1)
		{
			$where="(idbrigada = $idbrigada AND iddey=$iddey AND idfio= $idpeople)";
		}
		else
		{
			$where .=" OR (idbrigada = $idbrigada AND iddey=$iddey AND idfio= $idpeople)";
		}
		
	}
	$sql = 'SELECT id, idfio FROM nr32_tabel WHERE '. $where;
	$query = mysqli_query($link,$sql)or die("Ошибка построения даты [$sql]");
	foreach ($query as $val)
	{
		$exist[$val['idfio']]=$val['id'];
	}
	
	//Формируем запросы
	$sql ='';
	foreach ($whour as $idpeople => $hour)
	{
		
		$rem = $remarc[$idpeople];
		if (!$hour)$hour=0;
		if (isset($exist[$idpeople]))
		{
			if ($rem)
			{
				$sql .= "UPDATE  nr32_tabel SET whour=$hour, remarc=$rem WHERE id = ".$exist[$idpeople]. '; ';
				}
			else
			{
				$sql .= "UPDATE  nr32_tabel SET whour=$hour WHERE id = ".$exist[$idpeople]. '; ';
				}
		}
		else
		{
			
			if ($rem)
			{
				$sql .= "INSERT INTO nr32_tabel (idbrigada, iddey, idfio, whour, remarc) VALUES ($idbrigada, $iddey, $idpeople, $hour, '$rem'); ";
			}
			else
			{
				$sql .= "INSERT INTO nr32_tabel (idbrigada, iddey, idfio, whour) VALUES ($idbrigada, $iddey, $idpeople, $hour); ";
			}
		}
	}
	mysqli_multi_query($link,$sql)or die("Ошибка сохранения [$sql] \n ".mysqli_error($link));
	closeDB($link);
	
 echo 'Saved';