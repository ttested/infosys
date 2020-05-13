function ShowUsers(){
    $.ajax({url: "ajax/showuserlist.php", 
    beforSend: function(){$("#userlist").html("<div class=\"cssload-clock\"></div>");}, 
    success: function(data){$("#userlist").html(data); $("#modal_users").modal("hide");StartDT();MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});}
function EditUser($usr){$.ajax({type: "POST",url: "ajax/showuser.php",  data: "tab=users&id="+$usr, success: function(data){$("#popup").html(data); $("#modal_users").modal("show")},error: function(a,b){alert(a.responseText());}});} 
function CloseMy() {$("#modal_users").modal("hide");}
function ClearMy() {$('#frm_users')[0].reset();}
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
    $.ajax({url:  "ajax/saveusers.php", type:   "post", data:   $data, success: function(data){ShowUsers(); $("#modal_users").modal("hide"); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}
function LoadUsers()
{
    $.ajax({url: "ajax/updownload.php", 
            type:   "post", 
            data: "download=yes&dbtable=users", 
            dataType: 'binary',
            xhrFields: {
                'responseType': 'blob'
            },
            success: function(data, status, xhr){
                var link = document.createElement('a');
                filename = 'file.xlsx';
                var binaryData = [];
                binaryData.push(data);
                link.href = URL.createObjectURL(new Blob(binaryData, {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"}));
                link.download = filename;
                link.click();
               // alert("111");
            },
            error: function(a,b){
                console.log(a);
            }  
            });
			
}
function ShowTheUser(){
var $usr;
$usr=$('table tr .marked').attr('rowcod');
if (!$usr==='')EditUser($usr);	
}

$('body').on('change', '#imgfile', function(event){
    $('#photoform').ajaxSubmit({
		type: 'POST',
		url: 'ajax/uploadfoto.php',
		target: '#photorez',
		success: function() {
			// После загрузки файла очистим форму.
			$('#photoform')[0].reset();
		},
		error: function(a,b){
                console.log('error: '+a);
            } 
	});
});

$('body').on('change', '#banc', function(event){

	$(this).find('option').each(function() {
		if($(this).prop('selected') == true){ 
		   $bic=$(this).attr('bic');
		   $ks=$(this).attr('ks');
		   $('#bic').val($bic);
		   $('#korstcet').val($ks);
		}
	});
});

$('body').on('dblclick','table tr' ,function(e) {
    var $a;
	$a= $(this).attr('rowcod');
	//console.log($a);
	EditUser($a);
  });  

