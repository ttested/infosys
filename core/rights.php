<?php
//проверка пользователя по ID и HESH
function checkUser($userID, $userHESH)
{
	//название таблицы и полей
	$tabName = 'users';
	$tabName = TN($tabName);
	$fldID = 'id';
	$user_hash ='hash';
	$userFIO = 'fio';
	global $link;
	// выполняем операции с базой данных
	$query  = "SELECT count(*) as cnt FROM ". $tabName . " where ". $fldID . " = ". $userID. ' and '.$user_hash."='".$userHESH."'";

	//echo $query;
	$result = mysqli_query($link, $query) or die("Ошибка проверки авторизации"); 
	if($result)
	{
		$row = mysqli_fetch_assoc($result);
	
		$rez = $row['cnt'];
		
	}
	else
	{
		$rez=0;
	}
	mysqli_free_result($result);
	
	return $rez;
	
}
function checkArray($val, $key)
{
	if (isset($val[$key]))
	{return $val[$key];}
	else 
	{return FALSE;}
}

function checkVal($val, $key)
{
	if(isset($val[$key]))
	{
		if ($val[$key]===1)
		{return TRUE;}
		else
		{return FALSE;}
	}
	else {return FALSE;}
}

function getRules($userID)
{
    global $link;
	
	$rez=[];
    $sql = "SELECT u.`rule_id`, n.`rulename`, r.`useall`, r.`canread`, r.`cancreate`, r.`canedit`, r.`candel` FROM `nr32_rules` as r INNER JOIN `nr32_rules_users` as u ON r.`id_rule` = u.`rule_id` INNER JOIN `nr32_rules_names` as n ON n.`id`=u.`rule_id` WHERE u.`user_id`=".$userID;
    $result = mysqli_query($link, $sql) or die("Ошибибка получения привилегий"); 
	if($result)
	{
		while ($row = mysqli_fetch_assoc($result)) 
		{
			$rule = '';
			$relenm =checkArray($row,'rulename');
			if (checkVal($row,'useall'))$rule = 'A';
			if (checkVal($row,'canread'))$rule = 'R';
			if (checkVal($row,'cancreate'))$rule = 'C';
			if (checkVal($row,'canedit'))$rule = 'E';
			if (checkVal($row,'candel'))$rule = 'D';
		    if ($rule != '')
		    {$rez[$relenm]=$rule;}
		}
		return $rez;
	}
	else
	{
	    return false;
	}
}