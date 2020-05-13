var $snam = 'calendar';
var $tab = "calendar"
var $tablename ="#modal_"+$tab; 

function NewCalendar()
{
	var today = new Date();
	var year = today.getFullYear();
	//console.log(year);
	$.ajax({
		type: "POST",
		url: "ajax/newcalendar.php",  
		data: "year="+year, 
		success: function(data){
			ShowCalendar();
			console.log(data);},
		error: function(a,b){alert(a.responseText());}});
}


function ShowCalendar($fnam='', $div='', $frmed=''){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
    $.ajax({url: "ajax/show"+$fnam+"list.php", 
    beforSend: function(){$("#"+$div).html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#"+$div).html(data); $($frmed).modal("hide");}, 
    error: function(a,b){alert(a.responseText());}});}

function EditCalendar($cod, $fnam='', $div='', $frmed=''){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
	$.ajax({
		type: "POST",
		url: "ajax/show"+$fnam+".php",  
		data: "tab="+$div+"&id="+$cod, 
		success: function(data){$("#popup").html(data); $($frmed).modal("show")},
		error: function(a,b){alert(a.responseText());}});
} 

function CloseMy($frmed='') {if ($frmed==''){$frmed=$tablename;}$($frmed).modal("hide");}

function ClearMy() {$("form").trigger('reset');}

function SaveMy(frm, $frmed=''){
    $data ='';
	$value = 0;
	if ($frmed==''){$frmed=$tablename;}
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
    $.ajax({url:  "ajax/save"+$snam+".php", type:   "post", data:   $data, 
	success: function(data){ShowCalendar(); $($frmed).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

$('body').on('click','table td' ,function(e) {
    var $a;
	$a= $(this).attr('id');
	console.log($a);
	EditCalendar($a);
  });