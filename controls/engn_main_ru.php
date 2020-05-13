<?php
function RunEngine()
{
	
	global $UserName;
	global $UserPermission;
	global $rootH;
	global $UserCOD;
	
	require_once ($rootH .'/core/menu.php');
	
	$Rules = ' ваши привилегии: '.$UserPermission;
	

	
	$rez['title']='Добро пожаловать '.$UserName;
	$rez['nav']= getMenu($UserCOD);
	$rez['h1']='Мониторинг компании';
	$rez['footer']='Добро пожаловать '.$UserName.', '.$Rules;
	return $rez;
}