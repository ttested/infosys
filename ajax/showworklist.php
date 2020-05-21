<?php
function YesNo($v)
{
    if($v==='1'){return 'Удалена';}else {return 'В работе';}
}
function P($v)
{
    if($v==='1'){return 'Расчет';}else {return 'Выданы';}
}


function RunEngine()
{
	$table ='workplan';
	$view = "v_$table";
	
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/grid.php');
	require_once ($rootH .'/core/db.php');
	require_once ($rootH . '/core/tools.php');
	$link = InitDB();
	//echo "ghbikb";

	//**************************** Готовим список объектов ***********************************/
	if (isset($_POST['idbuilding'])) 	
	 {
		$spis =fillData('nr32_building',false,'id',$_POST['idbuilding']);}
	else {
		$spis =fillData('nr32_building');
	}
	
	$spis = '<div class="form-group row">
	<label for="idbuilding" class="col-sm-3 control-label text-left">Объект строительства</label>
	<div class="col-sm-9">
	<select class="form-control browser-default custom-select" id="idbuilding" aria-describedby="idbuildingHelp">
	'
	  . $spis .
	'<!--{building => idbuilding}-->
	</select>
	<small id="idbuildingHelp" class="form-text text-muted">Выберите объект строительства, для планирования</small>
	</div>
	</div>';
	
	//Подготавливаем таблицу пользоывтелей
	$sqlgrd ='SELECT ';
	$endsql ='FROM `nr32_'.$view.'`';
	//Назвыания полей
	$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = '$table' ORDER BY `fieldorder`";
	//echo $sql;
	$query = mysqli_query($link,$sql)or die("Ошибка построения заголовка [$sql]");
    while($data  = mysqli_fetch_assoc($query))
    {
        $tabheader[]=$data['fieldname'];
        if ($sqlgrd =='SELECT ')
        {
            $sqlgrd .='`nr32_'.$view.'`.`'.$data['dbfield'].'` ';
           // $endsql .= '`nr32_'.$view.'`';
        }
        else
        {
            $sqlgrd .=', `nr32_'.$view.'`.`'.$data['dbfield'].'` ';
        }
    }
	//$sqlgrd .=$endsql;
	
	if (isset($_POST['idbuilding'])) {
		$sqlgrd .= $endsql . ' WHERE id_building = ' . $_POST['idbuilding'];
	} else {
		$sqlgrd .= $endsql . ' WHERE id_building = 1';
	}

	if (isset($_POST['selrec'])) {
		$frow = $_POST['selrec'];
	} else {
		$frow = 0;
	}

    //echo $sqlgrd;
	mysqli_free_result($query);
	$grid['tabheader']=$tabheader;
	
	if($query = mysqli_query($link,$sqlgrd))
	{
		while($data  = mysqli_fetch_assoc($query))
		{
			//$data['delrec']=YesNo($data['delrec']);
			//$data['isclose']=P($data['isclose']);
			//$data['datepay']=substr($data['datepay'],0,10);
			$tabrows[]=$data;
		}
		mysqli_free_result($query);
		if (isset($tabrows))
		{$grid['tabrows']=$tabrows;}
	}
	closeDB($link);
	
	

	//Служебные данные
	$grid['tabid']='tab'.$table;
	$grid['heder']=$spis;
	$grid['title']='';
	$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_'.$table.'" data-target="#'.$table.'" onclick="EditWork(0);">Запланировать</button>';	

	
	return getGrid($grid);
}

echo RunEngine();