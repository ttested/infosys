var $tablename ="#modal_dict_appointments"; 

function ShowAppointments(){
    $.ajax({url: "ajax/showappolist.php", 
    beforSend: function(){$("#dict_appointments").html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#dict_appointments").html(data); $($tablename).modal("hide");StartDT();MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});}

function EditAppointment($cod){
	$.ajax({
		type: "POST",
		url: "ajax/showappointment.php",  
		data: "tab=dict_appointments&id="+$cod, 
		success: function(data){$("#popup").html(data); $($tablename).modal("show")},
		error: function(a,b){alert(a.responseText());}});
} 

function CloseMy() {$($tablename).modal("hide");}

function ClearMy() {$($tablename)[0].reset();}

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
    $.ajax({url:  "ajax/saveappointment.php", type:   "post", data:   $data, success: function(data){ShowAppointments(); $($tablename).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	console.log($a);
	EditProf($a);
  });