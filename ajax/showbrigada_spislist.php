<?php
function YesNo($v)
{
    if($v==='1'){return 'Удалена';}else {return 'В работе';}
}

function RunEngine($id)
{
	$table ='brigada_spis';
	$view = 'v_brigada_spis';
	
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
    $sqlgrd .=$endsql.' WHERE `nr32_'.$view.'`.`idbrigada` = '.$id;
    //echo $sqlgrd;
	mysqli_free_result($query);
	$grid['tabheader']=$tabheader;
	
	$query = mysqli_query($link,$sqlgrd)or die("Ошибка построения списка заголовка");;
    while($data  = mysqli_fetch_assoc($query))
    {
       // $data['delrec']=YesNo($data['delrec']);
		$tabrows[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	if (isset($tabrows)) {$grid['tabrows']=$tabrows;}  
	

	//Служебные данные
	$grid['tabid']=$table;
	$grid['heder']='Состав бригад';
	$grid['title']='Сотрудники';
	$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_'.$table.'" data-target="#'.$table.'" onclick="EditBrigadaSpis(0);">Новый участник</button>';	
	
	return getGrid($grid);
}
//print_r($_POST);
echo RunEngine($_POST['id']);