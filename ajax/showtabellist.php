<?php

function RunEngine()
{
	//Список бригад
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	$sql = 'SELECT id, descr FROM nr32_brigada WHERE delrec = 0 ORDER BY orderidx';
	$query = mysqli_query($link,$sql)or die("Ошибка построения списка бригад [$sql]");
	$sel='<form id="frmTabel"><div class="form-group row"><label for="brigada" class="col-sm-2 control-label text-left">Бригада</label><div class="col-sm-9"><select class="form-control browser-default custom-select" id="brigada" >';
	foreach ($query as $var)
	{
		$id = $var['id'];
		$des = $var['descr'];
		$sel.="<option value='$id'>$des</option>";
	}
	$sel.='</select></div></div></form><div id="listtabel"></div>';

	$card = '<div class="card text-center"><div class="card-header"><h5 class="card-title">';
	$card .= 'Табель отработанных дней';
	$card .= '</h5></div><div class="card-body">';
	$card .= '<div class="column">';
	$card .= $sel;
	$card .= '</div></div><div class="card-footer text-muted">';
	$card .= '<button type="button" class="btn btn-primary"  onclick="EditTabel();">Заполнить табель</button>';
	$card .= '</div></div>';

	
	return $card;
}

echo RunEngine();