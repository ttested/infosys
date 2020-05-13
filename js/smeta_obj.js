var $snam = 'smeta_obj';
var $tab = "smeta_obj"
var $tablename ="#modal_"+$tab; 

function ShowSmetaObj(){
    $.ajax({url: "ajax/show"+$snam+"list.php", 
    beforSend: function(){$("#"+$tab).html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#"+$tab).html(data); $($tablename).modal("hide");$v=StartDT();MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});}

function EditSmetaObj($cod){
	$.ajax({
		type: "POST",
		url: "ajax/show"+$snam+".php",  
		data: "tab="+$tab+"&id="+$cod, 
		success: function(data){$("#popup").html(data); $($tablename).modal("show")},
		error: function(a,b){alert(a.responseText());}});
} 

function CloseMy() {$($tablename).modal("hide");}

function ClearMy() {$("form").trigger('reset');}

function SaveMy(frm){
    $data ='';
	$value = 0;
	
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
	success: function(data){ShowSmetaObj(); $($tablename).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	//console.log($a);
	EditSmetaObj($a);
  });