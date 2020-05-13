<?php
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
function fillData ($src, $dat,$act=1,$repl='')
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT * FROM `nr32_".$dat. "`";
	
	//echo $sql;

	if ($repl==''){$repl=$dat;}
	$query = mysqli_query($link,$sql)or die("Ошибка чтения справочника ".$dat." `$sql`");
	$option ='';
    while($data  = mysqli_fetch_assoc($query))
    {
        if ($act ==$data['id'])
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
	$dat = str_replace('<!--{'.$repl.'}-->',$option,$src);
	
	return $dat;	
}


function fillDict($src, $dict, $act=1,$repl='')
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT spr.`id`,spr.`descr`,spr.`orderidx` FROM `nr32_".$dict. "` spr WHERE spr.`delrec`= 0 ORDER BY 3";

	if ($repl==''){$repl=$dict;}
	
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
	$dat = str_replace('<!--{'.$repl.'}-->',$option,$src);
	return $dat;	
}

function getEditFields($gname)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT 	`table_name`, `column_name`, `data_type`, `character_maximum_length`, `column_comment` FROM  information_schema.columns WHERE	column_comment <>'' and  `table_name` = 'nr32_".$gname."'";
//echo $sql;
	$query = mysqli_query($link,$sql)or die("Ошибка построения списка полей ".$gname);
    while($data  = mysqli_fetch_assoc($query))
    {
        $grd[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	return $grd;
}

function getFullForm($tabname,$gdName, $values, $fldn='id', $fid=0)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	$myform = $rootH . '/forms/'.$tabname.'.php';
	
	if (file_exists($myform))
	{
		$modalid = 'modal_'.$tabname;
		$modaltitle = $modalid.'Title';
		$modallabel = 'Редактирование '.$tabname;
		
		$modal =  '<div class="modal fade" id="'.$modalid.'" tabindex="-1" role="dialog" aria-labelledby="'.$modaltitle.'" aria-hidden="true" >';
		$modal .= '<div class="modal-dialog modal-dialog-centered modal-lg" role="document">';
		$modal .= '<div class="modal-content">';
		$modal .= '<div class="modal-header">';
		$modal .= '<h5 class="modal-title" id="exampleModalLongTitle">'.$modallabel.'</h5>';
		$modal .= '<button type="button" class="close" data-dismiss="'.$modalid.'" aria-label="Close"  onclick="CloseMy(\''.$modalid.'\');">';
		$modal .= '<span aria-hidden="true">&times;</span>';
		$modal .= '</button>';
		$modal .= '</div>';
		$modal .= '<div class="modal-body">';
		
		// получаем шаблон	
		$data = file_get_contents($myform);
		
		//заполняем шаблон данными
		//все справочники и связанные таблицы
		preg_match_all('/{\K[^}]*(?=})/m',$data,$arr);
		foreach($arr[0] as $dict)
		{
			$cod=1;
			
			$pos=strpos($dict,'=>');
			if (!$pos===FALSE)
			{
				$tab = trim(substr($dict,0,$pos));
				$fld = trim(substr($dict,$pos+2));
				$repl = $dict;
			}
			else
			{
				$tab = $dict;
				$fld = $dict; 
				$repl ='';
			}
			
			if (!$fldn==='id'){$fld=$fldn;}
			
			if (strpos($dict,'dict_')===FALSE) 
			{
				if(isset($values) && (isset($values[$fld])))$cod=$values[$fld];
				//echo " tab='$tab'   fld='$fld' val ='$cod'";
				$data = fillData($data,$tab,$cod,$repl);
				}
			else
			{
				if ($tab == $dict){$fld = substr($dict,5);};
				if(isset($values) && (isset($values[$fld])))$cod=$values[$fld];
				//echo " tab='$tab'   fld='$fld' val ='$cod'";
				$data = fillDict($data,$tab,$cod,$repl);
				}
		}
		
		//все данные формы
		if($values['id']>0)
		{
			foreach($values as $key=>$val)
			{
				if ($key=='photofile')
				{
					$data =str_replace('#'.$key.'#','img/'.$val,$data);
				}
				else
				{
					if (($val>=0)&&($val<2)){
						$chk = '';
						if ($val==1)$chk = 'checked';
						$data =str_replace('$'.$key.'$',$chk,$data);
					};	
					$data =str_replace('#'.$key.'#',$val,$data);
				}
			}
		}
		else
		{
			//Проверяем, возможно значение передано
			foreach($values as $key=>$val)
			{
				$data =str_replace('#'.$key.'#',$val,$data);
			}
			//Очищаем все метки
			preg_match_all('/#\S*#/',$data,$arr);
			foreach($arr[0] as $dat)
			{
				$data =str_replace($dat,'',$data);
			}
		}

		
		
		//присоединяем к модальному окну
		$modal .=$data;
		
		//закрываем модальное окно
		$frm ='</div><div class="modal-footer">';
		$frm .='<button class="btn btn-success" onclick ="SaveMy(\'frm_'.$tabname.'\');"  type="submit">Сохранить</button>';
		//$frm .='<button class="btn btn-warning" onclick ="ClearMy();" type="reset">Отменить</button>';
		$frm .='<button class="btn btn-danger" data-dismiss="'.$modalid.'" onclick="CloseMy(\''.$modalid.'\');">Закрыть</button>';
		$frm .=' </div></form>';
		$modal .= $frm .'</div></div></div>';
		
		return $modal;
	}
	else
	{
		return getIsiForm($tabname,$gdName, $values);
	}
}

function getIsiForm($tabname,$gdName, $values)
{
	$modalid = 'modal_'.$tabname;
	$modaltitle = $modalid.'Title';
	$modallabel = 'Редактирование '.$tabname;
	
	$modal =  '<div class="modal fade" id="'.$modalid.'" tabindex="-1" role="dialog" aria-labelledby="'.$modaltitle.'" aria-hidden="true">';
	$modal .= '<div class="modal-dialog modal-dialog-centered" role="document">';
    $modal .= '<div class="modal-content">';
    $modal .= '<div class="modal-header">';
    $modal .= '<h5 class="modal-title" id="exampleModalLongTitle">'.$modallabel.'</h5>';
    $modal .= '<button type="button" class="close" data-dismiss="'.$modalid.'" aria-label="Close"  onclick="CloseMy();">';
    $modal .= '<span aria-hidden="true">&times;</span>';
    $modal .= '</button>';
    $modal .= '</div>';
    $modal .= '<div class="modal-body">';
	
	$frm='<form id="frm_'.$tabname.'">';
	
	foreach ($gdName as $fld)
	{
		if ($values===FALSE)
		{$value='';
		    
		}
		else
		{
			if (isset($values[$fld['column_name']]))
			{$value = 'value ="'.$values[$fld['column_name']].'"';}
			else {$value='';}
		}
		
		if ($fld['data_type'] =='datetime')
		{$typ = '<input type="datetime-local" class="form-control" id="'.$fld['column_name'].'" '.$value.'>';}
		elseif ($fld['data_type'] =='varchar')
		{$typ = '<input type="text" class="form-control" id="'.$fld['column_name'].'" maxlength="'.$fld['character_maximum_length'].'" '.$value.'>';}	
		elseif ($fld['data_type'] =='tinyint')
		{$typ = '<input type="checkbox" class="form-control" id="'.$fld['column_name'].'" '.$value.'>';}
		else {$typ = '<input type="text" class="form-control" id="'.$fld['column_name'].'" '.$value.'>';}
		
		$frm .='<div class="form-group row pop"><label for="'.$fld['column_name'].'">';
		$frm .=$fld['column_comment'];
		$frm .='</label>';
		$frm .=$typ;
		$frm .='</div>';
	}
	$frm .='</div><div class="modal-footer">';
    $frm .='<button class="btn btn-success" onclick ="SaveMy(\'frm_'.$tabname.'\');"  type="submit">Сохранить</button>';
	//$frm .='<button class="btn btn-warning" onclick ="ClearMy();" type="reset">Отменить</button>';
	$frm .='<button class="btn btn-danger" onclick="CloseMy();">Закрыть</button>';
	$frm .=' </div></form>';
	$frm = $modal.' ' .$frm .'</div></div></div>';
	
	return $frm;
}

function EditGrid($gridname, $id=0, $fld='id',$pid=0,$linkfld='',$linkid=0)
{
	global $link;
	
	if ($id > 0)
	{
        $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	    require_once ($rootH .'/core/db.php');
	    $link =  InitDB();

		$sql = 'SELECT * FROM `nr32_'.$gridname. '` as nr where nr.`id`='.$id;
		$query = mysqli_query($link,$sql)or die("Ошибка получения данных таблицы");
		$data  = mysqli_fetch_assoc($query);
		if (isset($data['dtreg']))
		{
			$timestamp = strtotime($data['dtreg']);
			$data['dtreg']= date("Y-m-d",$timestamp).'T'.date("H:i:s",$timestamp);
		}
		mysqli_free_result($query);
	    closeDB($link);
	}
	else
	{
		if ($pid>0)
		{
			$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
			require_once ($rootH .'/core/db.php');
			$link =  InitDB();
			
			$sql = 'SELECT * FROM `nr32_'.$gridname. '` as nr where nr.`id`='.$pid;
			$query = mysqli_query($link,$sql)or die("Ошибка получения данных таблицы");
			$data  = mysqli_fetch_assoc($query);
			
			mysqli_free_result($query);
			closeDB($link);
		}
		
		$data['id']= 0;
		if($linkfld!=''){$data[$linkfld]= $linkid;}
		if (isset($data['dtreg'])){$data['dtreg']= date("Y-m-d").'T'.date("H:i:s");}
	}
	
	$fields = getEditFields($gridname);
	//return getIsiForm($gridname,$fields,$data);
	return getFullForm($gridname,$fields,$data,$fld,$pid);
	//print_r( $fields);
}