<?php
function RunEngine()
{
	$tabname = 'banc';
	
	global $UserName;
	global $UserPermission;
	global $rootH;
	global $UserCOD;
	
	require_once($rootH. '/core/menu.php');

	//Общие
	$Rules = ' ваши привилегии: '.$UserPermission;
	$rez['title']='Добро пожаловать '.$UserName;
	$rez['nav']= getMenu($UserCOD);
	$rez['h1']='Банки';
	$rez['footer']='Добро пожаловать '.$UserName.', '.$Rules;
	
	//Для вывода списка
	$rez['context']='<div id="'.$tabname.'"></div>';
	$rez['js'] ='<script src="./js/tools.js"></script><script src="./js/'.$tabname.'.js"></script><script>ShowBancs();</script>';
	$rez['css']='<style>.pop{margin: 0 20px;}</style>';
	return $rez;
}