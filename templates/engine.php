<?php

//формируем вывод статической страницы
function ShowTemplate($fileTmpl)
{
	if (file_exists ($fileTmpl))
	{
		$str = file_get_contents($fileTmpl);
	}
	else
	{
		$str='';
	}
	echo $str;
}

//Формируем вывод динамических страниц
function ProductTemplate($fileTmpl,$context)
{
    Global $rootH;
    if (file_exists ($fileTmpl))
	{
		$str = file_get_contents($fileTmpl);
	}
	else
	{
		$str = file_get_contents( $rootH.'/templates/tmpl_default.php');
	}
	
	foreach ($context as $key=>$value) {
	    $str = str_replace ('<!--{'.$key.'}-->',$value,$str);
	}
	
	echo $str;
}