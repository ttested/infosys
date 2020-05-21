<?php
function YesNo($v)
{
	if ($v === '1') {
		return 'Удалена';
	} else {
		return 'В работе';
	}
}


function RunEngine()
{

	$rootH = $_SERVER['DOCUMENT_ROOT'] . '/test';
	require_once($rootH . '/core/grid.php');
	require_once($rootH . '/core/db.php');
	require_once($rootH . '/core/tools.php');
	$link = InitDB();



	//**************************** Готовим список объектов ***********************************/
	if (isset($_POST['id_building'])) 	
	 {
		$spis =fillData('nr32_building',false,'id',$_POST['id_building']);}
	else {
		$spis =fillData('nr32_building');
	}
	$spis = '<div class="form-group row">
	<label for="idbuilding" class="col-sm-3 control-label text-left">Объект строительства</label>
	<div class="col-sm-9">
	<select class="form-control browser-default custom-select" id="idbuilding" aria-describedby="idbuildingHelp">
	<option value="0" selected>Для всех</option>
	'
		. $spis .
		'<!--{building => idbuilding}-->
	</select>
	<small id="idbuildingHelp" class="form-text text-muted">Выберите объект строительства, для тарификации</small>
	</div>
	</div>';

	//*******************************  Объекты сметы ***************************************
	//Подготавливаем таблицу 
	$table = 'smeta_pay_obj';
	$view = "v_$table";
	$sqlgrd = 'SELECT ';
	$endsql = 'FROM ';
	//Назвыания полей
	$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = '$table' ORDER BY `fieldorder`";
	$query = mysqli_query($link, $sql) or die("Ошибка построения [$sql]");
	while ($data  = mysqli_fetch_assoc($query)) {
		$tabheader[] = $data['fieldname'];
		if ($sqlgrd == 'SELECT ') {
			$sqlgrd .= '`nr32_' . $view . '`.`' . $data['dbfield'] . '` ';
			$endsql .= '`nr32_' . $view . '`';
		} else {
			$sqlgrd .= ', `nr32_' . $view . '`.`' . $data['dbfield'] . '` ';
		}
	}

	if (isset($_POST['id_building'])) {
		$sqlgrd .= $endsql . ' WHERE id_building = ' . $_POST['id_building'];
	} else {
		$sqlgrd .= $endsql . ' WHERE id_building = 0';
	}


	// echo $sqlgrd;
	mysqli_free_result($query);
	$grid['tabheader'] = $tabheader;
	if (isset($_POST['selrec'])) {
		$frow = $_POST['selrec'];
	} else {
		$frow = 0;
	}

	if ($query = mysqli_query($link, $sqlgrd)) {
		while ($data  = mysqli_fetch_assoc($query)) {
			//$data['delrec']=YesNo($data['delrec']);
			//$data['isclose']=P($data['isclose']);
			//$data['datepay']=substr($data['datepay'],0,10);
			$tabrows[] = $data;
			if ($frow == 0) {
				$frow = $data['id'];
			}
		}
		mysqli_free_result($query);
		if (isset($tabrows))
		{$grid['tabrows'] = $tabrows;}
	}

	//Служебные данные
	$grid['tabid'] = $table;
	$grid['heder'] = $spis;
	//$grid['title']='';
	$grid['control'] = '<button type="button" class="btn btn-primary" data-toggle="modal_' . $table . '" data-target="#' . $table . '" onclick="EditSmetaPay(0);">Новая таррификация</button>';

	
	//**************************** Детализация сметы *****************************************/
	//Подготавливаем таблицу 
	$table = 'smeta_pay_det';
	$view = "v_$table";
	$sqlgrd = 'SELECT ';
	$endsql = 'FROM ';
	//Назвыания полей
	$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = '$table' ORDER BY `fieldorder`";
	$query = mysqli_query($link, $sql) or die("Ошибка построения [$sql]");
	$tabheader = [];
	while ($data  = mysqli_fetch_assoc($query)) {
		$tabheader[] = $data['fieldname'];
		if ($sqlgrd == 'SELECT ') {
			$sqlgrd .= '`nr32_' . $view . '`.`' . $data['dbfield'] . '` ';
			$endsql .= '`nr32_' . $view . '`';
		} else {
			$sqlgrd .= ', `nr32_' . $view . '`.`' . $data['dbfield'] . '` ';
		}
	}

	$sqlgrd .= $endsql . ' WHERE idobj = ' . $frow;
	$sqlgrd .= ' AND ';
	if (isset($_POST['id_building'])) {
		$sqlgrd .= '  id_building = ' . $_POST['id_building'];
	} else {
		$sqlgrd .= '  id_building = 0';
	}


	// echo $sqlgrd;
	mysqli_free_result($query);
	$sgrid['tabheader'] = $tabheader;
	if (isset($_POST['selrec'])) {
		$srow = $_POST['selrec'];
	} else {
		$srow = 0;
	}
	$tabrows = [];
	if ($query = mysqli_query($link, $sqlgrd)) {
		while ($data  = mysqli_fetch_assoc($query)) {
			//$data['delrec']=YesNo($data['delrec']);
			//$data['isclose']=P($data['isclose']);
			//$data['datepay']=substr($data['datepay'],0,10);
			$tabrows[] = $data;
			if ($srow == 0) {
				$srow = $data['id'];
			}
		}
		mysqli_free_result($query);
		$sgrid['tabrows'] = $tabrows;
	}

	closeDB($link);

	//Служебные данные
	$sgrid['tabid'] = $table;

	return getDblGrid($grid, $sgrid, $frow, $srow);
}

echo RunEngine();
