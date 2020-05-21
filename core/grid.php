<?php
function is_Date($str)
{
	//return is_numeric(strtotime($str));
	return (strlen($str) >= 10) && is_numeric(strtotime($str));
}
function getGrid($gidData, $selid = 0)
{
	//	$grid = '<script>$("'.$gidData[tabid].'").on("click", ":not(thead) tr", function() {console.log("clicked")});</script>';
	$grid = '<div class="table-responsive">';
	$grid .= '<table id="' . $gidData['tabid'] . '" class="table table-hover table-striped table-bordered table-condensed table-sm" cellspacing="0" width="100%"><thead><tr class="table-primary">';
	foreach ($gidData['tabheader'] as $theader) {
		$grid .= '<th scope="col" >' . $theader . '</th>';
	}
	$grid .= '</tr></thead><tbody>';
	if (isset($gidData['tabrows'])) {
		foreach ($gidData['tabrows'] as $rows) {
			if ($selid == $rows['id']) {
				$grid .= '<tr rowcod="' . $rows['id'] . '" class="marked">';
			} else {
				$grid .= '<tr rowcod="' . $rows['id'] . '">';
			}
			foreach ($rows as $row) {
				if (is_Date($row)) {
					$dttm = strtotime($row);
					$grid .= '<td>' . date('d.m.Y H:i:s', $dttm) . '</td>';
				} else {
					$grid .= '<td>' . $row . '</td>';
				}
			}
			$grid .= '</tr>';
		}
	}
	$grid .= '</tbody></table></div>';
	// $card = '<div class="card text-center"><div class="card-header"><h5 class="card-title">';
	// $card .= $gidData['heder'];
	// $card .= '</h5></div><div class="card-body">';
	// //$card .= $gidData['title'];
	// $card .= '<div class="column">';
	// $card .= $grid;
	// $card .= '</div></div><div class="card-footer text-muted">';
	// $card .= $gidData['control'];
	// $card .= '</div></div>'; 
	$card = '<div class="card text-center">';
	if (isset($gidData['heder'])) {
		$card .= '<div class="card-header"><h5 class="card-title">' . $gidData['heder'];
		$card .= '</h5></div>';
	}
	$card .= '<div class="card-body">';
	if (isset($gidData['title'])) {
		$card .= $gidData['title'];
	}
	$card .= '<div class="column">';
	$card .= $grid;
	$card .= '</div></div>';
	if (isset($gidData['control'])) {
		$card .= '<div class="card-footer text-muted">';
		$card .= $gidData['control'];
		$card .= '</div>';
	}
	$card .= '</div>';
	return $card;
}

function getGridXT($gidData)
{
	$odat = [];
	$cdat = [];
	foreach ($gidData['tabrows'] as $Dat) {
		if ($Dat['pid'] == 0) {
			$odat[] = $Dat;
		} else {
			$cdat[$Dat['pid']][] = $Dat;
		}
	}

	if (isset($gidData['dontshow'])) {
		foreach ($gidData['dontshow'] as $f) {
			unset($gidData['tabheader'][$f]);
		}
	}
	//print_r($gidData['tabrows']);
	//print_r($gidData['tabheader']);
	$hader = '<div class="table-responsive">';
	$hader .= '<table id="' . $gidData['tabid'] . '" class="table table-hover table-striped table-bordered table-condensed table-sm" cellspacing="0" width="100%"><thead><tr class="table-primary">';
	foreach ($gidData['tabheader'] as $theader) {
		$hader .= '<th scope="col" >' . $theader . '</th>';
	}
	$hader .= '</tr></thead><tbody>';

	$grid = '<div id="accordion" role="tablist" aria-multiselectable="true">';
	foreach ($odat as $orows) {

		$grid .= '<div class="card"><div class="card-header" role="tab" id="item' . $orows['id'] . '"><h5 class="mb-0"><a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $orows['id'] . '" aria-expanded="true" aria-controls="collapse' . $orows['id'] . '">';
		$grid .= $orows['descr'];
		$grid .= '</a></h5></div><div id="collapse' . $orows['id'] . '" class="collapse show" role="tabpanel" aria-labelledby="item' . $orows['id'] . '"><div class="card-block">';
		if (isset($cdat[$orows['id']])) {
			$grid .= $hader;
			foreach ($cdat[$orows['id']] as $rows) {
				//print_r(  $rows);
				if (isset($gidData['dontshow'])) {
					foreach ($gidData['dontshow'] as $f) {
						unset($rows[$f]);
					}
				}

				$grid .= '<tr rowcod="' . $rows['id'] . '">';
				foreach ($rows as $row) {
					if (is_Date($row)) {
						$dttm = strtotime($row);
						$grid .= '<td>' . date('d.m.Y H:i:s', $dttm) . '</td>';
					} else {
						$grid .= '<td>' . $row . '</td>';
					}
				}
				$grid .= '</tr>';
			}
			$grid .= '</div>';
			$grid .= '</tbody></table></div>';
		}
		$grid .= '</div></div></div>';
	}

	$card = '<div class="card text-center">';
	if (isset($gidData['heder'])) {
		$card .= '<div class="card-header"><h5 class="card-title">' . $gidData['heder'];
		$card .= '</h5></div>';
	}
	$card .= '<div class="card-body">';
	if (isset($gidData['title'])) {
		$card .= $gidData['title'];
	}
	$card .= '<div class="column">';
	$card .= $grid;
	$card .= '</div></div>';
	if (isset($gidData['control'])) {
		$card .= '<div class="card-footer text-muted">';
		$card .= $gidData['control'];
		$card .= '</div>';
	}
	$card .= '</div>';
	return $card;
}

function getDblGrid($firstGrid, $secondGrid, $fselid = 0, $sselid = 0, $direct = "v")
{
	$card = '';
	if ($direct = "v") {
		if (isset($firstGrid)) {
			$card .= '<div class="row"><div class="col" id="firstGrid">';
			$card .= getGrid($firstGrid, $fselid);
			$card .= '</div></div>';
		}
		if (isset($secondGrid)) {
			$card .= '<div class="row"><div class="col" id="secondGrid">';
			$card .= getGrid($secondGrid, $sselid);
			$card .= '</div></div>';
		}
	} else {
		$card .= '<div class="row">';
		if (isset($firstGrid)) {
			$card .= '<div class="col-mt-6"  id="firstGrid">';
			$card .= getGrid($firstGrid, $fselid);
			$card .= '</div>';
		}
		if (isset($secondGrid)) {
			$card .= '<div class="col-mt-6" id="secondGrid">';
			$card .= getGrid($secondGrid, $sselid);
			$card .= '</div>';
		}
		$card .= '</div>';
	}

	return $card;
}
