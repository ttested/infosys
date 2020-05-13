<?php

//Вывод формы авторизации
function RunAuth()
{
	global $rootH; 
	//echo  $rootH .'/templates/engine.php <br>'.$rootH .'/templates/tmpl_auth.php';
	require_once ($rootH .'/templates/engine.php');
	ShowTemplate($rootH .'/templates/tmpl_auth.php');
}