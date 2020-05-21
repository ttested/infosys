var $snam = 'building';
var $tab = "building"
var $tablename ="#modal_"+$tab; 


function ShowBuilding($fnam='', $div='', $frmed=''){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
    $.ajax({url: "ajax/show"+$fnam+"list.php", 
    beforSend: function(){$("#"+$div).html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#"+$div).html(data); $($frmed).modal("hide");StartDT();MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});}

function EditBuilding($cod, $fnam='', $div='', $frmed='', $typpay=0){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
	$.ajax({
		type: "POST",
		url: "ajax/show"+$fnam+".php",  
		data: "tab="+$div+"&id="+$cod+"&typpay="+$typpay, 
		success: function(data){$("#popup").html(data); $($frmed).modal("show")},
		error: function(a,b){alert(a.responseText());}});
} 

function CloseMy($frmed='') {$($tablename).modal("hide");}

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
	success: function(data){ShowBuilding(); $($frmed).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	//console.log($a);
	EditBuilding($a);
  });