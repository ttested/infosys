<?php
function RunEngine()
{
	global $UserName;
	global $UserPermission;
	global $rootH;
	global $UserCOD;
	
	require_once($rootH. '/core/menu.php');

	//Общие
	$Rules = ' ваши привилегии: '.$UserPermission;
	$rez['title']='Добро пожаловать '.$UserName;
	$rez['nav']= getMenu($UserCOD);
	$rez['h1']='Список должностей';
	$rez['footer']='Добро пожаловать '.$UserName.', '.$Rules;
	
	//Для вывода списка
	$rez['context']='<div id="dict_appointments"></div>';
	$rez['js'] ='<script src="./js/tools.js"></script><script src="./js/dict_appointments.js"></script><script>ShowAppointments();</script>';
	$rez['css']='<style>.pop{margin: 0 20px;}</style>';
	return $rez;
}