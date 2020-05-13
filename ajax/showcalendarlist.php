<?php
function RunEngine()
{
	
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/ajax/calendar.php');
	$card = '<div class="card text-center"><div class="card-header"><h5 class="card-title">';
	$card .= 'НА '. date('Y').' год';
	$card .= '</h5></div><div class="card-body">';
	$card .= '<div class="column">';
	$card .= drawYear(date('Y'));
	$card .= '</div></div><div class="card-footer text-muted">';
	$card .= '<button type="button" class="btn btn-primary"  onclick="EditCalendar(0);">Новый день</button><button type="button" class="btn btn-success" onclick="NewCalendar();">Получить календарь на '.date('Y').' год</button>';
	$card .= '</div></div>';
	
	return $card;
}

echo RunEngine();