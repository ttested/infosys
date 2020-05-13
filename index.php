<?php
///Выводим все ошибки
error_reporting(E_ALL);
ini_set("display_error", true);
ini_set("error_reporting", E_ALL);
header('Content-Type: text/html; charset=utf-8');

//ПОДКЛЮЧАЕМ ИСПОЛЬЗУЕМЫЕ ФАЙЛЫ
require_once ($_SERVER['DOCUMENT_ROOT'].'/test/vars.php');

require_once ($db);
require_once ($rght);
require_once ($auth);
require_once ($content);

//ПЕРЕСЫЛКА НА ИСПОЛНЕНИЕ
if (isset($_POST['key']))
{
	$controlUnit = $rootH .'/controls/ctrl_'.$_POST['key'].$prefix.'ru.php';
//	$controlUnit = $rootH .'/test.php';
//	echo $controlUnit; 
	require_once($controlUnit);
	exit;
}

//ПРАОВЕРЯЕМ ДОСТУП ПОЛЬЗОВАТЕЛЯ
//Проверяем, есть ли у вызвавшего записи в куках
if ((isset($_COOKIE['id'])) && (isset($_COOKIE['hash']))) 
{
	//echo "Залогинились";
	//подключаемся к базе
	$link = InitDB();
	$UserCOD =$_COOKIE['id'];
	//проверяем, есть ли доступ
	$RezLoged = checkUser($_COOKIE['id'],$_COOKIE['hash']);
}
else 
{
	//отправляем на авторизацию
	$RezLoged = 0;
}

//Проверяем авторизацию
if ($RezLoged==0)
{
	//отправляемс на авторизацию
	RunAuth();
	closeDB($link);
	exit;
}

// Получаем права пользователя
$UsrRules = getRules($_COOKIE['id']);

if ($UsrRules===false)
{
     echo "У вас нет прав на использование программы";
     exit;
}

//Получаем информацию о пользователе
userInfo($UserCOD);
//echo $UserName;
//МАРШРУТИЗАЦИЯ
//Получаем  запрос на маршрут
if (isset($_GET['route']))
{
	$pathRout = $_GET['route'];
}
else $pathRout ='';

//Если запрос пустой, отправляем на главную страницу
if ($pathRout =='')
{
	showPage('main');
}
else
{
   //echo $pathRout;
	//иначе отправляем куда просят
	showPage($pathRout);
}

closeDB($link);


?>