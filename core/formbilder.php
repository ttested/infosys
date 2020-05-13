<?php

//Собираем форму
function BuildForm($brigada,$data)
{
	global $rootH;
	
	$tabname = 'tabel';
	
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	$sql = 'SELECT descr FROM nr32_brigada WHERE id = '.$brigada;
	$query = mysqli_query($link,$sql)or die("Ошибка построения бригад [$sql]");
	$rec =  mysqli_fetch_assoc($query);
	$desc = $rec['descr'];
	
	//mysqli_free_result($query);
	$sql = 'SELECT * FROM nr32_v_calendar WHERE data = "'.$data.'"' ;
	$query = mysqli_query($link,$sql)or die("Ошибка построения даты [$sql]");
	$rec =  mysqli_fetch_assoc($query);
	$iddey = $rec['id'];
	
	mysqli_free_result($query);
	$sql ="SELECT id, idfio, whour, remarc FROM nr32_tabel WHERE idbrigada = $brigada AND iddey = $iddey";
	$query = mysqli_query($link,$sql)or die("Ошибка построения табеля [$sql]");
	foreach($query as $val)
	{
		$idfio = (int)$val['idfio'];
		$whour[$idfio] = $val['whour'];
		$remarc[$idfio] = $val['remarc'];
	}
	
	
	mysqli_free_result($query);
	$sql ="SELECT nvbs.idpeople, nvbs.fio FROM nr32_v_brigada_spis nvbs WHERE nvbs.idbrigada = $brigada";
	$query = mysqli_query($link,$sql)or die("Ошибка построения списка бригады [$sql]");
	$fios = '';
	$i=0;
	foreach($query as $val)
	{
		$i++;
		$idfio = (int)$val['idpeople'];
		if (isset($whour[$idfio])){$hour = $whour[$idfio];} else {$hour ='';}
		if (isset($remarc[$idfio])){$rem = $remarc[$idfio];} else {$rem ='';}
				
		$fios .= '<div class="form-group row"><input type="hidden" class="form-control" id="idpeople'.$i.'"  value="'.$idfio.'">';
		$fios .= '<label for="whour'.$i.'" class="col-sm-4 control-label text-left">'.$val['fio'].'</label><div class="col-sm-8"><div class="row"><div class="col-sm-3"><input type="text" placeholder="Часов"  class="form-control whour" id="whour'.$i.'"  value="'.$hour.'"></div>';
		$fios .= '<div class="col-sm-9"><input type="text" placeholder="Причина невыхода"  class="form-control remarc" id="remarc'.$i.'"  value="'.$rem.'"></div></div></div></div>';
	}
	$fios .= '<input type="hidden" class="form-control" id="count"  value="'.$i.'">';
	
	mysqli_free_result($query);
	closeDB($link);
	
	$modalid = 'modal_'.$tabname;
	$modaltitle = $modalid.'Title';
	$modallabel = 'Табель для бригады: '.$desc;
	
	$modal =  '<div class="modal fade" id="'.$modalid.'" tabindex="-1" role="dialog" aria-labelledby="'.$modaltitle.'" aria-hidden="true">';
	$modal .= '<div class="modal-dialog modal-dialog-centered" role="document">';
    $modal .= '<div class="modal-content">';
    $modal .= '<div class="modal-header">';
    $modal .= '<h5 class="modal-title" id="mytitle">'.$modallabel.'</h5>';
    $modal .= '<button type="button" class="close" data-dismiss="'.$modalid.'" aria-label="Close"  onclick="CloseMy();">';
    $modal .= '<span aria-hidden="true">&times;</span>';
    $modal .= '</button>';
    $modal .= '</div>';
    $modal .= '<div class="modal-body">';
	
	$frm='<form id="frm_'.$tabname.'">';
	//дата и коды
	$frm .='<div class="form-group row"><label for="paypercent" class="col-sm-3 control-label text-left">Дата работы</label><div class="col-sm-9"><input type="date" class="form-control" id="paypercent" aria-describedby="paypercentHelp"  Value="'.$data.'"></div><small id="paypercentHelp" class="form-text text-muted">Укажите дату, на которую вы заполняете табель</small></div>';
	$frm .='<input type="hidden" class="form-control" id="idbrigada"  value="'.$brigada.'">';
		
	$frm .='<div class="overflow-y: scroll; max-height:200px;">';
	$frm .=$fios;
	$frm .='</div>';
	
	$frm .='</div><div class="modal-footer">';
	$frm .='<button class="btn btn-info" onclick ="FillMy(\'whour\',\'8\');" type="reset">Все отработали смену</button>';
    $frm .='<button class="btn btn-success" onclick ="SaveMy(\'frm_'.$tabname.'\','.$brigada.');"  type="submit">Сохранить</button>';
	//$frm .='<button class="btn btn-warning" onclick ="ClearMy();" type="reset">Отменить</button>';
	$frm .='<button class="btn btn-danger" onclick="CloseMy();">Закрыть</button>';
	$frm .=' </div></form>';
	$frm = $modal.' ' .$frm .'</div></div></div>';
	
	return $frm;
}