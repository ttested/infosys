<?php

function gv($y,$m,$d,$hd)
{
	switch($hd)
	{
		case 0: $t=1; break;
		case 1: 
			$time = strtotime("$y-$m-$d");
			$w = date('w', $time);
			if (($w==0) || ($w==6))	{$t=2;} else {$t=3;}
		break;
		case 2: $t=4; break;
	}
	return $t;
}

if (isset($_POST['year']))
{
	$y = $_POST['year'];
	$sql = 'INSERT INTO nr32_calendar (nYear, nMonth, nDay, typeday) VALUES ';
	$dsql = 'DELETE FROM nr32_calendar WHERE nYear='.$y;
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	for ($i=1; $i<13; $i++)
	{
		if ($i<10){$m='0'.$i;}else{$m=$i;}
		$url = "https://isdayoff.ru/api/getdata?year=$y&month=$m&pre=1&delimeter=,";
		
		$holidays=file_get_contents($url);
		$hdays = explode(',',$holidays);
		$d=1;
		foreach($hdays as $hd)
		{
			$t = gv($y,$m,$d,$hd);
			if (($d==1)&&($i==1))
			{
				$sql .="($y,$i,$d,$t)";
			}
			else
				{
				$sql .=", ($y,$i,$d,$t)";
			}
			$d++;
		}
	}
	echo 'Ok';
	mysqli_query($link,$dsql)or die("Ошибка удаления [$dsql]");
	mysqli_query($link,$sql)or die("Ошибка записи [$sql] ");
	closeDB($link);
}
else
{
	print_r($_POST);
}