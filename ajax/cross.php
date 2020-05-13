<?php

$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
require_once ($rootH .'/core/db.php');
$link = InitDB();
$cols= array();
$tcol= array();
$wday = array();

function f($v)
{
	if ($v<10) 
	{
		return "0$v";
	}
	else{return $v;}
}

//Генерация колонок
function GetCols($sFilter)
{
	global $link;
	global $cols;
	global $tcol;
	global $wday;
	
	$ruw = ['Воскресение','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'];
	
	$sql = "SELECT cldr.`id`, cldr.`nYear`, cldr.`nMonth`, cldr.`nDay`, cldr.`typeday` FROM `nr32_calendar` cldr WHERE $sFilter";
	$query = mysqli_query($link,$sql)or die("Ошибка построения колонок [$sql]");
	
	$th = '<thead><tr><th rowspan="3" scope="col">#</th><th rowspan="3" scope="col">Фамилия имя отчество</th>'; 
	
	$i=0; ;$yc=0; $mc=0;
	$oy=0; $om=0;
	$monts = ['','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
		
	foreach ($query as $val)
	{
				
		//Для данных по колонкам
		$cols[$val['id']]=$i;
		//Дни недели
		$y = $val['nYear'];
		$m = f($val['nMonth']);	
		$d = f($val['nDay']);
		$tm = date('w',strtotime("$y-$m-$d"));
		$wday[$i] = $ruw[$tm];
		//Подсчет для объединения столбцов в заголовке
		if (($oy>0)&&($oy!=$val['nYear']))
		{
			$ycol[$oy]=$yc;
			$yc=1;
			$oy = $val['nYear'];
		}
		elseif($oy==0)
		{
			$oy = $val['nYear'];
			$yc=1;
		}
		else
		{
			$yc++;
		}
		
		if (($om>0)&&($om!=$val['nMonth']))
		{
			$mcol[$om]=$mc;
			$mc=1;
			$om = $val['nMonth'];
		}
		elseif($om==0)
		{
			$om = $val['nMonth'];
			$mc=1;
		}
		else
		{
			$mc++;
		}
		$dcol[$i]=$val['nDay'];
		$tcol[$i]=$val['typeday'];
		$i++;
	}
	if (!isset($ycol[$oy])){$ycol[$oy]=$yc;}
	if (!isset($mcol[$om])){$mcol[$om]=$mc;}
	
		
	//Строим заголовок
	$i=0;
	foreach($ycol as $ykey=>$yval)
	{
		$th .="<th colspan='$yval' scope='col'>$ykey</th></tr><tr>";
	}	
	foreach ($mcol as $mkey=>$mval)
		{
			$th .="<th colspan='$mval' scope='col'>$monts[$mkey]</th>";
		}
	$th .="</tr><tr>";
	foreach ($dcol as $i=>$d)
		{
			$w= $wday[$i];
			switch($tcol[$i])
			{
				case 1: $th .="<td title='$w'>$d</td>"; break;
				case 2: $th .="<td title='$w' class='table-danger text-danger'>$d</td>"; break;
				case 3: $th .="<td title='$w' class='table-danger'>$d</td>"; break;
				case 4: $th .="<td title='$w' class='table-warning'>$d</td>"; break;
			}
		}
			$th .="</tr>";
		
	
	$th .="</thead>";
	return $th;
}

//Генерация строк
function GetRows($sFilter='')
{
	global $link;
	global $cols;
	global $tcol;
	
	if ($sFilter=='')
	{
		$sql = 'SELECT * FROM nr32_v_brigada_spis ORDER BY fio';
	}
	else
	{
		$sql = "SELECT * FROM nr32_v_brigada_spis WHERE $sFilter ORDER BY fio";
	}
	$query = mysqli_query($link,$sql)or die("Ошибка построения строк [$sql]");
	$i=0;
	$mans='';
	foreach ($query as $val)
	{
		$rowpos[$val['idpeople']]=$i;
		$m = explode(' ', $val['fio']);
		$fio[$i]=$m[0] . ' ' . substr($m[1],0,2) . '.' . substr($m[2],0,2) . '.' ;;
		$i++;
		if ($mans=='')
		{
			$mans='('.$val['idpeople'];
		}
		else
		{
			$mans.=','.$val['idpeople'];
		}
		
	}
	$mans.=')';
	$days='';
	foreach($cols as $key=>$val)
	{
		if ($days=='')
		{
			$days='('.$key;
		}
		else
		{
			$days.=','.$key;
		}
	}
	$days.=')';
	
	$sql = "SELECT * FROM nr32_tabel nt WHERE (nt.iddey IN $days) AND (nt.idfio IN $mans) AND ($sFilter)";
	
	$query = mysqli_query($link,$sql)or die("Ошибка построения табеля [$sql]");
	foreach ($query as $val)
	{
		$r = $val['idfio'];
		$c = $val['iddey'];
		
		$tabel[$rowpos[$r]][$cols[$c]] = $val['whour'];
	}
	//echo $sql;
	//print_r($tabel);
	//exit;
	
	//Строим колонки
	$tr = '<tbody>';
	for ($r=0; $r< count($rowpos); $r++)
	{
		$npp = $r+1;
		$tr .= "<tr><th  scope='row'>$npp</th><th  scope='row'>$fio[$r]</th>";
		for ($c=0; $c<count($cols); $c++)
		{
			$t = $tcol[$c];
			if (isset($tabel[$r][$c])){
				$v=$tabel[$r][$c];
				switch($t)
				{
					case 1:$tr .= "<td>$v</td>";break;
					case 2:$tr .= "<td class='table-danger text-danger'>$v</td>";break;
					case 3:$tr .= "<td class='table-danger'>$v</td>";break;
					case 4:$tr .= "<td  class='table-warning'>$v</td>";break;
						}
				}
			else{
				$v='-';
				if ( in_array ($t, [2,3]))
				{
					$tr .= "<td class='table-active'>$v</td>";
				}
				else
				{
					$tr .= "<td class='table-secondary'>$v</td>";	
				}
				
				}
			
		}
		$tr .= "</tr>";
	}
	$tr .= "</tbody>";	
	return $tr;
}

if (isset($_POST['year']) && isset($_POST['month']) && isset($_POST['brigada']))
	{
		$year = $_POST['year'];
		$month = $_POST['month']; 
		$brigada = $_POST['brigada'];
		
		$tab = '<div class="table-responsive"><table class="table table-bordered table-sm">';
		$tab .= GetCols("nYear=$year and nMonth in ($month)");
		$tab .= GetRows("idbrigada=$brigada");
		$tab .='</table></div>';
		echo $tab;
	}
else
{
	print_r($_POST);
}

//mysqli_free_result($query);
closeDB($link);
?>
