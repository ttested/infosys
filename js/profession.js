var $tablename ="#modal_dict_profession"; 

function ShowProfession(){
    $.ajax({url: "ajax/showproflist.php", 
    beforSend: function(){$("#proffesionlist").html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#proffesionlist").html(data); $($tablename).modal("hide");StartDT();MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});}

function EditProf($cod){
	$.ajax({
		type: "POST",
		url: "ajax/showproffesion.php",  
		data: "tab=dict_profession&id="+$cod, 
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
    $.ajax({url:  "ajax/saveprofession.php", type:   "post", data:   $data, success: function(data){ShowProfession(); $($tablename).modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	console.log($a);
	EditProf($a);
  });	