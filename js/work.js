var $snam = 'work';
var $tab = "workplan"
var $tablename ="#modal_"+$tab; 


function ShowWork($fnam='', $div='', $frmed='',flrefresh=false){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
	let mdata='zagl=0';
	if (flrefresh)
	{
		let idbuilding = $('#idbuilding').val();
		let selrec = $('#tabwork').find('tr.marked').attr('rowcod');
		mdata = 'idbuilding='+idbuilding+'&selrec = '+selrec;
	}

    $.ajax({type: "POST",url: "ajax/show"+$fnam+"list.php", data: mdata,
    beforSend: function(){$("#"+$div).html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#"+$div).html(data); $($frmed).modal("hide");StartDT('#tabworkplan');MarkDT();}, 
    error: function(a,b){alert(a.responseText)}});}

function EditWork($cod, $fnam='', $div='', $frmed='', $typpay=0){
	if ($fnam==''){$fnam=$snam;}
	if ($div==''){$div=$tab;} 
	if ($frmed==''){$frmed=$tablename;}
	let idbuilding = $('#idbuilding').val();
	$.ajax({
		type: "POST",
		url: "ajax/show"+$fnam+".php",  
		data: "idbuilding="+idbuilding, 
		success: function(data){
			$("#popup").html(data); 
			StartDT("#editworkplan"); 
			$($frmed).modal("show");
		},
		error: function(a,b){alert(a.responseText);}});
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
	success: function(data){ShowWork(); $($frmed).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	//console.log($a);
	EditWork($a);
  });

//выбор объекта строительства
$('body').on('change', '#idbuilding', function(e) {
	ShowWork('','','',true);
	//console.log($(this).val());
});