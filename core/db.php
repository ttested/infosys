<?php
//Функция инициализации базы данных
function InitDB()
{
	$db_name = 'pikashow_buildin';
	$db_host = 'localhost';
	$db_user = 'pikashow_buildin';
	$db_password = '&ft4UtKP';
	
	// подключаемся к серверу
	$link = mysqli_connect($db_host, $db_user, $db_password, $db_name)  or die("Ошибка " . mysqli_error($link));
	return $link;
}

//Название таблицы с префиксом
function TN($tableName)
{
	$prefix = 'nr32_';
	if (strpos($tableName,$prefix)===FALSE)
	{
		$tabName =  $prefix.$tableName;
	}
	else
	{
		$tabName =  $tableName;
	}
	return 	$tabName;
}	

//Функция закрывает соединение с базой
function closeDB($dblink)
{
	// закрываем подключение
	mysqli_close($dblink);
}
