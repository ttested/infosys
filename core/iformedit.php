<?php
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
		$readonly='';
		if ($fld['column_name']=='id')$readonly=' readonly ';
		$value .=$readonly;
		
		
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

function getEditFields($gname)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
	$sql = "SELECT 	`table_name`, `column_name`, `data_type`, `character_maximum_length`, `column_comment` FROM  information_schema.columns WHERE	column_comment <>'' and  `table_name` = 'nr32_".$gname."'";

	$query = mysqli_query($link,$sql)or die("Ошибка построения списка полей ".$gname);
    while($data  = mysqli_fetch_assoc($query))
    {
        $grd[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	return $grd;
}

function EditGrid($gridname, $id=0)
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
		echo $sql;		
		mysqli_free_result($query);
	    closeDB($link);
	}
	else
	{
		$data['id']= 0;
			}
	
	$fields = getEditFields($gridname);
	return getIsiForm($gridname,$fields,$data);
		//print_r( $fields);
}