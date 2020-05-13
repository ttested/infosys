var $snam = 'tabel';
var $tab = "tabel"
var $tablename ="#modal_"+$tab; 


function ShowTabel($fnam='', $div='', $frmed=''){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
    $.ajax({url: "ajax/show"+$fnam+"list.php", 
    beforSend: function(){$("#"+$div).html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#"+$div).html(data); $($frmed).modal("hide");LoadTabel(1)}, 
    error: function(a,b){alert(a.responseText());}});}
	
function LoadTabel($brigada)
{
	mdate= new Date();
	$year=mdate.getFullYear();
	$.ajax({
		type: "POST",
		url: "ajax/cross.php",  
		data: "brigada="+$brigada+"&year="+$year+"&month=1,2,3,4,5,6,7,8,9,10,11,12 ", 
		success: function(data){$("#listtabel").html(data);},
		error: function(a,b){alert(a.responseText());}});
}

function EditTabel(){
	$fnam=$snam;
	$div=$tab;
	$frmed=$tablename;
	
	$idbrig = $('#brigada').val();
	var date = new Date();
	var now = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

	//console.log([$idbrig,now]);

	$.ajax({
		type: "POST",
		url: "ajax/show"+$fnam+".php",  
		data: "idb="+$idbrig+"&dat="+now, 
		success: function(data){$("#popup").html(data); $($frmed).modal("show")},
		error: function(a,b){alert(a.responseText());}});
} 

function CloseMy($frmed='') {if ($frmed==''){$frmed=$tablename;}$($frmed).modal("hide");}

function ClearMy() {$("form").trigger('reset');}

function SaveMy(frm, $idbrig=''){
    $data ='';
	$value = 0;
	$frmed=$tablename;
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
	success: function(data){LoadTabel($idbrig); $($frmed).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

function FillMy(clas,val)
{
	$('.'+clas).val(val);
}


$('body').on('change','#brigada', function(e) {
	var v;
	v= $(this).val();
	console.log('new ' + v);
	LoadTabel(v);
});

  
  