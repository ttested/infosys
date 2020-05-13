<?php
function is_Date($str){
	return (strlen($str)>=10) && is_numeric(strtotime($str));
}

echo is_Date('B');exit;

$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
$myform = $rootH . '/forms/users.php';
$data = file_get_contents($myform);

preg_match_all('/#\S*#/',$data,$arr);

			foreach($arr[0] as $dat)
			{
				$data =str_replace($dat,'',$data);
			}
echo $data;
exit;
require_once ($rootH .'/core/db.php');
$link =  InitDB();

$sql = 'SELECT * FROM `nr32_users` as nr where nr.`id`=3';
$query = mysqli_query($link,$sql)or die("Ошибка получения данных таблицы");
$values  = mysqli_fetch_assoc($query);
$timestamp = strtotime($values['dtreg']);
$values['dtreg']= date("Y-m-d",$timestamp).'T'.date("H:i:s",$timestamp);

mysqli_free_result($query);
closeDB($link);

function getLine($line, $sel)
{
	$i=0;
	$rez='<option value="';
	$endrez='';
	$param='';
	foreach($line as $k=>$l)
	{
		if ($i==0){$rez.=$l.'" '.$sel.' ';}
		elseif ($i==1){$endrez='>'.$l.'</option>';}
		else {$param .=' '.$k.'="'.$l.'"';}
		$i++;	
	}
	return $rez.$param.$endrez;
}
function fillData ($src, $dat)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT * FROM `nr32_".$dat. "`";

	$query = mysqli_query($link,$sql)or die("Ошибка чтения справочника ".$dat);
	$option ='';
    while($data  = mysqli_fetch_assoc($query))
    {
        if ($option =='')
		{
			$option .= getLine($data,'selected');
			//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
		}
		else
		{
			$option .= getLine($data,'');
			//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
		}	
        
    }
	mysqli_free_result($query);
	closeDB($link);
	$dat = str_replace('<!--{'.$dat.'}-->',$option,$src);
	
	return $dat;	
}

function fillDict($src, $dict, $act=1)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT spr.`id`,spr.`descr`,spr.`orderidx` FROM `nr32_".$dict. "` spr WHERE spr.`delrec`= 0 ORDER BY 3";

	$query = mysqli_query($link,$sql)or die("Ошибка чтения справочника ".$dict);
	$option ='';
    while($data  = mysqli_fetch_assoc($query))
    {
        if ($data['id']==$act)
		{
			$option .='<option value="'.$data['id'].'" selected>'.$data['descr'].'</option>';
		}
		else
		{
			$option .='<option value="'.$data['id'].'">'.$data['descr'].'</option>';
		}	
        
    }
	mysqli_free_result($query);
	closeDB($link);
	$dat = str_replace('<!--{'.$dict.'}-->',$option,$src);
	return $dat;	
}

preg_match_all('/{\K[^}]*(?=})/m',$data,$arr);
foreach($arr[0] as $dict)
{
	$cod=1;
			
			if (strpos($dict,'dict_')===FALSE) 
			{
				if(isset($values) && (isset($values[$dict])))$cod=$values[$dict];
				//echo "<p>SYS $dict = $cod </p>";
				$data = fillData($data,$dict,$cod);
				}
			else
			{
				$fld = substr($dict,5);
				if(isset($values) && (isset($values[$fld])))$cod=$values[$fld];
				$data = fillDict($data,$dict,$cod);
				//echo "<p>DICT $dict = $cod ($fld)</p>";
				}
	
}

//все данные формы

//////////////////////////
		if(isset($values) && (!$values===false))
		{
			foreach($values as $key=>$val)
			{
				if (($val>=0)&&($val<2)){
					$chk = '';
					if ($val==1)$chk = 'checked';
					$data =str_replace('$'.$key.'$',$chk,$data);
				};
				
				$data =str_replace('#'.$key.'#',$val,$data);
			}
		}
$data = '<div id="vse">'.$data;		
$data .='<button id="go">пуск</button>';		
$data .='<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>';
$data .="<script>$('#vse').on('click', '#go', function() {var test = []; 
		 $('.card').find(':input').each(function(i, input) {
			test.push($(input).attr('id')+'='+$(input).val());
			});

			alert(test);

		});	</script>";	
$data .= '</div>';
echo $data;
//print_r($values);

//preg_match_all('/{(.*?)}/',$data,$arr);
//preg_match_all('/{\K[^}]*(?=})/m',$data,$arr);
//var_dump($arr[0]);	

