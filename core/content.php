<?php
function showPage($view)
{
	//echo $view;
	global $rootH;
	require_once ($rootH .'/templates/engine.php');
	require_once ($rootH .'/controls/engn_'.$view.'_ru.php');
	$content = RunEngine();
	ProductTemplate($rootH .'/templates/tmpl_'.$view.'.php',$content);
	
}

function userInfo($userid)
{
    global $link;
    global $UserName;
    global $UserPermission;
	global $UserPermAr;
	
    //название таблицы и полей
	$tabName = 'users';
	$tabName = TN($tabName);
	$userID = 'id';
	$userFIO = 'fio';
	$rulename = 'rulename';
	
	// Имя
	$sql = 'SELECT '.$userFIO.' FROM '.$tabName.' WHERE '.$userID.'="'.$userid.'" LIMIT 1';
    $query = mysqli_query($link,$sql);
    $data  = mysqli_fetch_assoc($query);
    $UserName =$data[$userFIO]; 
    
    //Права
    $sql = "SELECT n.`rulename`, r.`useall`,r.`canread`,r.`cancreate`,r.`canedit`,r.`candel`, u.rule_id\n"

    . "FROM `nr32_rules_names` n\n"

    . "INNER JOIN `nr32_rules_users` u ON n.id = u.rule_id\n"

    . "INNER JOIN `nr32_rules` r ON r.`id_rule` = u.`rule_id`\n"

    . "WHERE u.user_id=".$userid;
    
     $query = mysqli_query($link,$sql);
     
     while( $data  = mysqli_fetch_assoc($query))
     {
          if ( $data['useall']==1) {$detail = '[Полные права]';}
          else {
              $detail = '[';
              if ( $data['canread']==1) $detail .= 'Чтение';
              if ( $data['cancreate']==1) $detail .= ', добавление';
              if ( $data['canedit']==1) $detail .= ', изменение';
              if ( $data['candel']==1) $detail .= ', удаление';
               $detail .= ']';
          
          }
          $UserPermAr[$data['canread']] = $data['canread'] + 2*$data['cancreate'] + 4*$data['canedit']+8*$data['canread']+16*$data['useall'];
          $UserPermission .= $data[$rulename]. ' '. $detail. ' ';      }
}