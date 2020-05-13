<?php
function f($v)
{
	if ($v<10) 
	{
		return "0$v";
	}
	else{return $v;}
}

//Выводим год
function drawYear($y)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	
	$sql = "SELECT cldr.`id`, cldr.`nYear`, cldr.`nMonth`, cldr.`nDay`, cldr.`typeday` FROM `nr32_calendar` cldr WHERE cldr.`nYear`=$y";
	$query = mysqli_query($link,$sql)or die("Ошибка построения колонок [$sql]");
	foreach ($query as $var)
	{
		$ids[$var['nYear']][$var['nMonth']][$var['nDay']] = $var['id'];
		$t[$var['id']]=$var['typeday'];
	}
	mysqli_free_result($query);
	closeDB($link);
	
	$calendar ='<div class="row"><div class="col"><span class="clyear">'.$y.'</span></div></div>';
	$m=1;
	for($r=1; $r<4; $r++)
	{
		$calendar .='<div class="row">';
		for($c=1; $c<5; $c++)
		{
			$calendar .='<div class="col">';
			$calendar .=getMonth($m,$y,$ids,$t);
			$calendar .='</div>';
			$m++;
		}
		$calendar .='</div>';
	}
	return $calendar;
}

//Строим календарь на месяц
function getMonth($m,$y,$ids,$t)
{
	$monts = ['','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
	$days = ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'];
	
	//Название месяца
	$clmonth = '<div class="row"><div class="col"><span class="clmonth">'.$monts[$m].'</span></div></div>';
	$clmonth .='<table class="table table-bordered table-sm"><thead><tr>';
	
	//Дни недели заголовок
	for ($i=0; $i<7; $i++)
	{
		if ($i>4)
		{
			$clmonth .='<th scope="col" class="text-danger">'.$days[$i].'</th>';
		}
		else
		{
			$clmonth .='<th scope="col">'.$days[$i].'</th>';
		}
	}
	$clmonth .='</tr></thead><tbody>';
	
	//Дни 
	$mm = f($m);
	$i=0; $ww=1;
	foreach($ids[$y][$m] as $d=>$id)
	{
		$dd = f($d);
		$tm = date('w',strtotime("$y-$mm-$dd"));
		if ($tm==0){$w=7;}else{$w=$tm;}
		
		if ($ww==1){$clmonth .='<tr>';}
		for ($i=$ww; $i<$w; $i++){$clmonth .='<td></td>';}
		switch($t[$id])
			{
				case 1: $clmonth .="<td id='$id' class='click'>$dd</td>"; break;
				case 2: $clmonth .="<td id='$id' class='table-danger text-danger click'>$dd</td>"; break;
				case 3: $clmonth .="<td id='$id' class='table-danger click'>$dd</td>"; break;
				case 4: $clmonth .="<td id='$id' class='table-warning click'>$dd</td>"; break;
			}
		$ww=$w+1;
		if ($ww==8){$clmonth .='</tr>';$ww==1;}
		
	}
    for ($i=$ww; $i<8; $i++){$clmonth .='<td></td>';} 
	$clmonth .='</tr></tbody></table>';
	
	return $clmonth ;
}

