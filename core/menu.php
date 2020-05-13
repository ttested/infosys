<?php

function getMenu($usrid)
{
	global $link;
	global $UserPermAr;
	
	//Получаем доступные роли для меню
	$rule = '(';
	foreach ($UserPermAr as $key=>$val)
	{
		if ($rule != '(')$rule .=',';
		if ($val > 0) $rule .= $key;
	}
	$rule .=')';

	
	//Получаем доступные пункты меню
	$sql = "SELECT m.`id`, m.`pid`,m.`orderfld`, m.`menuname`,m.`menuhint`,m.`menuaction` \n"

    . "FROM `nr32_menu` as m\n"

    . "INNER JOIN `nr32_menu_rules` as r \n"

    . "ON m.`id`=r.`menu_id`\n"

    . "WHERE r.`rule_id` in ".$rule."\n"

    . "ORDER BY 2,3,1";
    
 
	
	$query = mysqli_query($link,$sql)or die("Ошибка построения меню"); ;
	$navbar = '<ul class="navbar-nav">';
	if (isset($_GET['route']))
	{$active = $_GET['route'];}
	else {$active ='';}

	$menu=[];
	while( $data  = mysqli_fetch_assoc($query))
     {
		$tmp[$data['pid']][$data['id']]=$data;
	 }
	foreach ($tmp[0] as $key => $val) 
	{
		$menu[]= $val;
		$id = $val['id'];
		if(isset($tmp[$id]))
		{
			foreach ($tmp[$id] as $key1=>$val1){
				$menu[]= $val1;	
			}
		}
	}
	foreach($menu as $data)	{
		if (($data['pid']==0) && ($navbar != '<ul class="navbar-nav">') && ($type==1)){$navbar .='</div></li>';$type=0;}
		if ($data['id']==1)
		{
		    $type=0;
			if ($active === $data['menuaction'])
			{
				$navbar .=' <li class="nav-item active"><a class="nav-link" href="./index.php?route='.$data['menuaction'].'" data-toggle="tooltip" data-placement="bottom" title="'.$data['menuhint'].'">'.$data['menuname'].'</a></li>';   
			}
			else
			{
				$navbar .=' <li class="nav-item"><a class="nav-link" href="./index.php?route='.$data['menuaction'].'" data-toggle="tooltip" data-placement="bottom" title="'.$data['menuhint'].'">'.$data['menuname'].'</a></li>';   
			}
		}
		else
		{
    		if (($data['pid']==0) && ($data['menuaction'] ==''))
    		{
    			$type=1;
    			$id = $data['id'];
    			$navbar .='<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbardrop'.$data['id'].'" data-toggle="dropdown" >';
    			$navbar .=$data['menuname'].'</a><div class="dropdown-menu">';
    		}
    		else
    		{
    			if (($data['pid']==0) && ($data['menuaction'] !=''))
    			{
    				$type=0;
    				//$navbar .=' <li class="nav-item"><a class="nav-link" href="./index.php?route='.$data['menuaction'].'" data-toggle="tooltip" data-placement="bottom" title="'.$data['menuhint'].'">'.$data['menuname'].'</a></li>';
					if ($active === $data['menuaction'])
					{
						$navbar .=' <li class="nav-item active"><a class="nav-link" href="./index.php?route='.$data['menuaction'].'" data-toggle="tooltip" data-placement="bottom" title="'.$data['menuhint'].'">'.$data['menuname'].'</a></li>';   
					}
					else
					{
						$navbar .=' <li class="nav-item"><a class="nav-link" href="./index.php?route='.$data['menuaction'].'" data-toggle="tooltip" data-placement="bottom" title="'.$data['menuhint'].'">'.$data['menuname'].'</a></li>';   
					}
    			}
    			else
    			{
    				if ($data['pid']==$id)
    				{
    					$navbar .='<a class="dropdown-item"  data-toggle="tooltip" data-placement="bottom" title="'.$data['menuhint'].'" href="./index.php?route='.$data['menuaction'].'">'.$data['menuname'].'</a>';
    				}
    			}
    		}
		}
	 }
	 if (($navbar != '<ul class="navbar-nav">') && ($type==1)){$navbar .='</div></li>';$type=0;}
	 $navbar .='</ul>';
	 
	 return $navbar;
}