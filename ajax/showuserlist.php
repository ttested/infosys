<?php
function YesNo($v)
{
    if($v!=''){return 'Да';}else {return 'Нет';}
}

function RunEngine()
{
	
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/grid.php');
	require_once ($rootH .'/core/db.php');
	$link = InitDB();
	//echo "ghbikb";
	
	//Подготавливаем таблицу пользоывтелей
	$sqlgrd ='SELECT ';
	$endsql ='FROM ';
	//Назвыания полей
	$sql = "SELECT `gridname`, `fieldname`, `dbfield` FROM `nr32_grid_heders` WHERE `gridname` = 'users' ORDER BY `fieldorder`";
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
	
	//Таблица пользоывтелей
	//$sql = "SELECT `id`,`fio`,`login`,`password`,`canrun`,`dtreg` FROM `nr32_users` \n";
	//$query = mysqli_query($link,$sql);
	
	$query = mysqli_query($link,$sqlgrd);
    while($data  = mysqli_fetch_assoc($query))
    {
        //if($data[password]!=''){$data[password]!='Да';}else {$data[password]!='Нет';}
        $data['password']=YesNo($data['password']);
        $data['canrun']=YesNo($data['canrun']);
        $tabrows[]=$data;
    }
	mysqli_free_result($query);
	closeDB($link);
	$grid['tabrows']=$tabrows;
	

	//Служебные данные
	$grid['tabid']='users';
	$grid['heder']='Список пользователей системы';
	$grid['title']='Пользователи';
	$grid['control']='<button type="button" class="btn btn-primary" data-toggle="modal_users" data-target="#users" onclick="EditUser(0);">Новый сотрудник</button><button type="button" class="btn btn-secondary" onclick="LoadUsers();">Выгрузить в Excel</button><button type="button" class="btn btn-success">Success</button><button type="button" class="btn btn-danger">Danger</button><button type="button" class="btn btn-warning">Warning</button>';	
	
	return getGrid($grid);
}

echo RunEngine();