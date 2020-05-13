<?php
function YesNo($v)
{
    if($v==='1'){return 'Удалена';}else {return 'В работе';}
}

function TypeNameObj($t)
{
	switch($t)
	{
		case 0: $to='Папка'; break;
		case 1: $to='Материал'; break;
		case 2: $to='Работа'; break;
		case 3: $to='Услуга'; break;
		case 4: $to='Аренда'; break;
		case 4: $to='Оборудование'; break;
		default: $to='Не выбран'; break;
	}
	return $to;
}

function RunEngine()
{
	$table ='smeta_obj';
	$view = 'v_smeta_obj';
	
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/grid.php');
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	//echo "ghbikb";
	
	//Подготавливаем таблицу пользоывтелей
	$sqlgrd ='SELECT ';
	$endsql ='FROM ';
	//Назвыания полей
	$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = '$table' ORDER BY `fieldorder`";
	$query = mysqli_query($link,$sql)or die("Ошибка построения списка заголовка");
    while($data  = mysqli_fetch_assoc($query))
    {
        $tabheader[]=$data['fieldname'];
        if ($sqlgrd =='SELECT ')
        {
            $sqlgrd .='`nr32_'.$view.'`.`'.$data['dbfield'].'` ';
            $endsql .= '`nr32_'.$view.'`';
        }
        else
        {
            $sqlgrd .=', `nr32_'.$view.'`.`'.$data['dbfield'].'` ';
        }
    }
    $sqlgrd .=$endsql;
	
//echo $sqlgrd;
	mysqli_free_result($query);
	$grid['tabheader']=$tabheader;
	
	$query = mysqli_query($link,$sqlgrd);
    while($data  = mysqli_fetch_assoc($query))
    {
        $data['delrec']=YesNo($data['delrec']);
		$data['objtype']=TypeNameObj($data['objtype']);
		$tabrows[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	$grid['tabrows']=$tabrows;
	
	//не показывать столбцы в таблице
	$grid['dontshow']=[1,8,'pid','papka'];
	

	//Служебные данные
	$grid['tabid']='Объекты сметы';
	$grid['heder']='';
	$grid['title']='';
	$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_'.$table.'" data-target="#'.$table.'" onclick="EditSmetaObj(0);">Новая категоря</button>';	
	
	return getGridXT($grid);
}

echo RunEngine();