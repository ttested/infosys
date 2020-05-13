<?php
function YesNo($v)
{
    if($v==='1'){return 'Удалена';}else {return 'В работе';}
}

function RunEngine()
{
	$table ='smeta_sostav';
	$view = 'v_smeta_sostav';
	
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/grid.php');
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	
	if (isset($_POST['id']))
	{
		$selid = $_POST['id'];
	}
	else
	{
		$selid = 1;
	}
	//echo "ghbikb";
	
	//Подготавливаем таблицу пользоывтелей
	$sqlgrd ='SELECT ';
	$endsql ='FROM ';
	if (isset($_POST['idobj']))
	{  //Назвыания полей при вызове из другой формы
		$exclude = "'objsmeta','orderidx','delrec'";
		$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = '$table' and `dbfield` not in ($exclude) ORDER BY `fieldorder`";
	}
	else
	{	//Назвыания полей
		$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = '$table' ORDER BY `fieldorder`";
	}	

	//echo $sql;
	$query = mysqli_query($link,$sql)or die("Ошибка построения списка заголовка [$sql]");
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
	if (isset($_POST['idobj']))
	{
		$endsql .= ' WHERE `nr32_'.$view.'`.`idobj`='.$_POST['idobj'];
	}
	$sqlgrd .=$endsql;
    //echo $sqlgrd;
	mysqli_free_result($query);
	$grid['tabheader']=$tabheader;
	
	$query = mysqli_query($link,$sqlgrd);
    while($data  = mysqli_fetch_assoc($query))
    {
		if (isset($data['delrec']))	{$data['delrec']=YesNo($data['delrec']);}
		$tabrows[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	if (isset($tabrows))
	{$grid['tabrows']=$tabrows;}
	

	//Служебные данные
	$grid['tabid']=$table;
	if (isset($_POST['idobj']))
	{
		$grid['heder']='';
		$grid['title']='';
		$grid['control']='';	
	}
	else {
		$grid['heder']='Состав объекта сметы';
		$grid['title']='Состав сметы';
		$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_'.$table.'" data-target="#'.$table.'" onclick="EditSmetaSost(0,\'idobj\');">Новая запись</button>';	
	}
	
	
	return getGrid($grid, $selid);
}

echo RunEngine();