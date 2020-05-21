<?php
//общие не специализированные функции проекта
function isint($dat)
{
	if ((strlen($dat) < 10) && (is_numeric($dat)))
	{return $dat;}
	else 
	{return "'$dat'";}
}
function makeSQL($tabname,$data,$rectype)
{
	$sql='';
	switch ($rectype)
	{
		case "insert":
			$sql='INSERT INTO `'.$tabname.'` (';
			$sqlval = ' VALUES(';
			foreach($data as $key=>$val)
			{
				if ($key !='tabname')
				{
					if ($key=='password')$val=md5(md5('.$val.'));
					if ($key=='paypass')$val=md5(md5('.$val.'));
					if ($key=='validbuch')$val=md5(md5('.$val.'));
					if ($key=='validsotr')$val=md5(md5('.$val.'));
					if(($key !='id')&&($val !=''))
					{
						if ($sql=='INSERT INTO `'.$tabname.'` (')
						{
							$sql .='`'.$key.'`';
							$sqlval .=isint($val);
							}
						else
						{
							$sql .=',`'.$key.'`';
							$sqlval .=' ,'.isint($val);
							}
					}
				}
			}
			$sql .=')';
			$sql .= $sqlval.')';
			
		break;
		case 'update':
			$sql='UPDATE `'.$tabname.'` SET ';
			foreach($data as $key=>$val)
			{
				if ($key !='tabname')
				{
					if ($key=='password')$val=md5(md5('.$val.'));
					if ($key=='paypass')$val=md5(md5('.$val.'));
					if ($key=='validbuch')$val=md5(md5('.$val.'));
					if ($key=='validsotr')$val=md5(md5('.$val.'));
					if(($key !='id')&&($val !=''))
					{
						if ($sql=='UPDATE `'.$tabname.'` SET ')
						{
							$sql .='`'.$key.'`';
						}
						else
						{
							$sql .=',`'.$key.'`';	
						}
						$sql .= '='.isint($val);
					}
				}
			}
			$sql .= ' WHERE `id`='.$data['id'];
		break;
		case 'delete':
			$sql = 'DELETE FROM `'.$tabname.'` WHERE `id`='.$data['id'];
		break;
	}
	return $sql;
}

function makeSQLXT($tabname,$data,$rectype,$mkey,$mval)
{
	$sql='';
	switch ($rectype)
	{
		case "insert":
			$sql='INSERT INTO `'.$tabname.'` (';
			$sqlval = ' VALUES(';
			foreach($data as $key=>$val)
			{
				if ($key !='tabname')
				{
					if ($key=='password')$val=md5(md5('.$val.'));
					if ($key=='paypass')$val=md5(md5('.$val.'));
					if ($key=='validbuch')$val=md5(md5('.$val.'));
					if ($key=='validsotr')$val=md5(md5('.$val.'));
					
					if ($key == $mkey)$var = $mval;
					
					if(($key !='id')&&($val !=''))
					{
						if ($sql=='INSERT INTO `'.$tabname.'` (')
						{
							$sql .='`'.$key.'`';
							$sqlval .=isint($val);
							}
						else
						{
							$sql .=',`'.$key.'`';
							$sqlval .=' ,'.isint($val);
							}
					}
				}
			}
			$sql .=')';
			$sql .= $sqlval.')';
			
		break;
		case 'update':
			$sql='UPDATE `'.$tabname.'` SET ';
			foreach($data as $key=>$val)
			{
				if ($key !='tabname')
				{
					if ($key=='password')$val=md5(md5('.$val.'));
					if ($key=='paypass')$val=md5(md5('.$val.'));
					if ($key=='validbuch')$val=md5(md5('.$val.'));
					if ($key=='validsotr')$val=md5(md5('.$val.'));
					
					if ($key == $mkey)$var = $mval;
					
					if(($key !='id')&&($val !=''))
					{
						if ($sql=='UPDATE `'.$tabname.'` SET ')
						{
							$sql .='`'.$key.'`';
						}
						else
						{
							$sql .=',`'.$key.'`';	
						}
						$sql .= '='.isint($val);
					}
				}
			}
			$sql .= ' WHERE `id`='.$data['id'];
		break;
		case 'delete':
			$sql = 'DELETE FROM `'.$tabname.'` WHERE `id`='.$data['id'];
		break;
	}
	return $sql;
}

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

function fillData ($tab='nr32_smeta_obj',$noSelected=false,$selfld='',$fval=0 )
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT * FROM `$tab`";
	
	//echo $sql;

	$query = mysqli_query($link,$sql)or die("Ошибка чтения справочника ".$dat." `$sql`");
	$option ='';
	if ($selfld=='')
    {
		while($data  = mysqli_fetch_assoc($query))
		{
			
			if ($option === '')
			{
				if ($noSelected)
				{
					$option .= getLine($data,'');
					//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
				}
				else {
					$option .= getLine($data,'selected');
					//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
				}
				
			}
			else
			{
				$option .= getLine($data,'');
				//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
			}	
			
		}
	}
	else {
		while($data  = mysqli_fetch_assoc($query))
		{
			
			if ($data[$selfld] === $fval)
			{
				if ($noSelected)
				{
					$option .= getLine($data,'');
					//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
				}
				else {
					$option .= getLine($data,'selected');
					//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
				}
				
			}
			else
			{
				$option .= getLine($data,'');
				//$option .='<option value="'.$data[0].'" selected>'.$data[1].'</option>';
			}	
			
		}
	}

	mysqli_free_result($query);
	closeDB($link);
		
	return $option;	
}