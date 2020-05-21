<?php

function RefreshList()
{
    $rootH = $_SERVER['DOCUMENT_ROOT'] . '/test';
	require_once($rootH . '/core/grid.php');
	require_once($rootH . '/core/db.php');
	require_once($rootH . '/core/tools.php');
    $link = InitDB();
    
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
    
    if (isset($_POST['id_smeta'])) {
        $sqlgrd .= $endsql . ' WHERE `idobj` = ' . $_POST['id_smeta'];
        $sqlgrd .= ' AND ';
        if (isset($_POST['id_building'])) {
            $sqlgrd .= '  id_building = ' . $_POST['id_building'];
        } else {
            $sqlgrd .= '  id_building = 0';
        }
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

	return getGrid( $sgrid,  $srow );
}

echo RefreshList();