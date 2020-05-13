<?php
function YesNo($v)
{
    if($v==='1'){return 'Удалена';}else {return 'В работе';}
}

function RunEngine()
{
	$table ='office';
	$view = 'v_office';
	
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
		$tabrows[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	$grid['tabrows']=$tabrows;
	

	//Служебные данные
	$grid['tabid']=$table;
	$grid['heder']='Мои организации';
	$grid['title']='Список организаций для строительной деятельности';
	$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_'.$table.'" data-target="#dict_prava" onclick="EditOffice(0);">Новая организация</button>';	
	
	return getGrid($grid);
}

echo RunEngine();