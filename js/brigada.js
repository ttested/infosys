var $snam = 'brigada';
var $tab = "brigada"
var $tablename ="#modal_"+$tab; 


function ShowBrigada($id=0,$fnam='', $div='', $frmed=''){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
	console.log($fnam);
	$tid = '#'+$fnam;
    $.ajax({url: "ajax/show"+$fnam+"list.php", 
	type: "POST",
	data: "tab="+$div+"&id="+$id, 
    beforSend: function(){$("#div_"+$div).html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#div_"+$div).html(data); $($frmed).modal("hide");StartDT($tid);MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});}

function EditBrigada($cod, $fnam='', $div='', $frmed=''){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
	if ($cod==0){
		$a=$('#brigada').find('.marked').attr('rowcod');
		$a= '&idbrigada='+$a;
	}
	else {$a='';}
	$.ajax({
		type: "POST",
		url: "ajax/show"+$fnam+".php",  
		data: "tab="+$div+"&id="+$cod+$a, 
		success: function(data){$("#popup").html(data); $($frmed).modal("show")},
		error: function(a,b){alert(a.responseText());}});
} 

function EditBrigadaSpis($cod)
{
	$fnam = 'brigada_spis';
	$frmed = "#modal_"+$fnam;
	EditBrigada($cod,$fnam, $fnam, $frmed);
}

function CloseMy($frmed='') {if ($frmed==''){$frmed=$tablename;}else{$frmed='#'+$frmed}$($frmed).modal("hide");}

function ClearMy() {$("form").trigger('reset');}

function SaveMy(frm){
    $data ='';
	$value = 0;
	$frmed="#modal_"+frm.substring(4);
	//if ($frmed==''){$frmed=$tablename;}
    $("#"+frm).find ('input, textearea, select').each(function() {
		$atr = $(this).attr("type");
		if(($atr!== undefined)&('checkbox'=== $atr))
		{
			if ($(this).is(':checked')){$value =1;}else {$value =0;}
		}
		else
		{
			$value =$(this).val();
		}
		
		if ($data ===''){
				$data = $data + this.id + '='+ $value;
			}
		else{
				$data = $data +'&' +this.id + '='+ $value;
			}
	});
	$data = $data +'&tabname=nr32_'+frm.substring(4);
    $.ajax({url:  "ajax/save"+$snam+".php", type:   "post", data:   $data, 
	success: function(data){
		var $a;
		$a= $('#brigada').find('.marked').attr('rowcod');
		$b = frm.substring(4)
		$frmed = "#modal_"+$b; 
		ShowBrigada($a,$b, $b, $frmed);
		$($frmed).modal("hide"); 
		console.log(data);}, 
	error: function(a,b){alert(a.responseText());}});
}

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	$b = $(this).parent().parent().attr('id');
	$frmed = "#modal_"+$b; 
	//console.log($b);
	//console.log($a);
	EditBrigada($a,$b, $b, $frmed);
  });
  
  $('body').on('click','#brigada tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	$b = 'brigada_spis';
	$frmed = "#modal_"+$b; 
	//console.log($b);
	//console.log($a);
	ShowBrigada($a,$b, $b, $frmed);
  });
  
  