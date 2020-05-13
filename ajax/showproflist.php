<?php
function YesNo($v)
{
    if($v==='1'){return 'Удалена';}else {return 'В работе';}
}

function RunEngine()
{
	$table ='dict_profession'; 
	
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
	$query = mysqli_query($link,$sql)or die("Ошибка построения меню");
    while($data  = mysqli_fetch_assoc($query))
    {
        $tabheader[]=$data['fieldname'];
        if ($sqlgrd =='SELECT ')
        {
            $sqlgrd .='`nr32_'.$data['gridname'].'`.`'.$data['dbfield'].'` ';
            $endsql .= '`nr32_'.$data['gridname'].'`';
        }
        else
        {
            $sqlgrd .=', `nr32_'.$data['gridname'].'`.`'.$data['dbfield'].'` ';
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
		$tabrows[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	$grid['tabrows']=$tabrows;
	

	//Служебные данные
	$grid['tabid']='dict_profession';
	$grid['heder']='Профессии';
	$grid['title']='Профессии';
	$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_prof" data-target="#dict_profession" onclick="EditProf(0);">Новая профессия</button>';	
	
	return getGrid($grid);
}

echo RunEngine();