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
		error: function(a,b){alert(a.responseText);}});
} 

function CloseMy($frmed='') 
{
	if ($frmed===''){
		$frmed=$tablename;
	}else{
		$frmed='#'+$frmed;
	} 
	$($frmed).modal("hide");
}

function ClearMy() {$($tablename).trigger('reset');}

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

function ShowTabs($tab,$div,$cod )
{
	//console.log([$tab,$div,$cod]);

	if ($div !='')
	{$.ajax({
		type: "POST",
		url: "ajax/table"+$snam+".php",  
		data: "tab="+$tab+"&id="+$cod, 
		success: function(data)
		{
			$($div).html(data);
			if ( '#smeta'===$tab )
			{
				StartDT('#smetaobj');
				MarkDT();
			}
		},
		error: function(a,b){alert(a.responseText);}});}

}
//Смета
function ShowSmetaDet(a,b)
{
	console.log(b);
	$.ajax({type: "POST",url: "ajax/showsmeta_sostavlist.php", data: "id="+a+"&idobj="+b,
    success: function(data){$("#smetasost").html(data);StartDT('#smeta_sostav'); MarkDT();}, 
    error: function(a,b){alert(a.responseText());}});
}

function ReReadSmeta(id)
{
	ShowTabs('#smeta','#smeta_obj',id )
}

function EditSmeta(id)
{
	let idobj = $('#idobj').val();
	let kolvo = $('#kolvo').val();
	let frmdat = 'idobj='+idobj+'&kolvo='+kolvo+'&idbld='+id;
	console.log('good');
	$.ajax({url:  "ajax/savesmeta.php", type:   "post", data: frmdat, 
	success: function(data){ReReadSmeta(id); console.log(data);}, error: function(a,b){alert(a.responseText());}});
}

//Фотографии
function ShowPhoto($a,$b)
{
	//console.log($a);
	let v=$b.split('|');
	$('#bigimg').attr('src',$a);
	$('#bignam').html(v[0]);
	$('#bigdat').html(v[1]);
	$('#bigtyp').html(v[2]);
}

function NewPhoto( $tab,$cod )
{
	$.ajax({
		type: "POST",
		url: "ajax/photo"+$snam+".php",  
		data: "tab="+$tab+"&id="+$cod, 
		success: function(data){$("#newphoto").html(data); $("#modal_photos").modal("show")},
		error: function(a,b){alert(a.responseText);}});
}

function AddPhotos(idbuilding)
{
	let ingf = $("#imgfile");
	let desc = $("#imgdescr").val();
	let smeta = $("#id_smeta").val();
    let fd = new FormData;

	$.each($(ingf)[0].files, function(count, This_File) {
		//If MIME Type Of Picture Not Match With That Formats (Если не соответствует тип)
		if(!This_File.type.match(/(.png)|(.jpeg)|(.jpg)|(.gif)$/i) )  return false;
		//Иначе
		else {
			fd.append("image" + count, This_File);
		}
	});

	fd.append("id_buildin", idbuilding);
	fd.append("descr", desc);
	fd.append("id_smeta", smeta);
    
    $.ajax({
        url: 'ajax/uploadpictures.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
			//console.log('Ok');
			console.log(data);
		},
		error: function(a,b){
			alert(a.responseText);
		}
	});
}

$('body').on('dblclick','table tr' ,function(e) {
	var $a;
	var $b;
	$a= $(this).attr('rowcod');
	$b= $(this).attr('info');
	//console.log($a);
	EditBuilding($a, $b);
  });

 $('body').on('click','#tabnav  > ul > li > a' ,function(e) {
	var $a;
	var $b;
	var $c;
	$a= $(this).attr('href');
	$b= $(this).attr('dest');
	$c= $(this).attr('cod');
	ShowTabs($a, $b, $c);
  });  

 $('body').on('click','#thumbs  >  li' ,function(e) {
	var $a;
	var $b;
	$a= $(this).attr('imgurl');
	$b= $(this).attr('info');
	ShowPhoto($a,$b);
  });

  $('body').on('click','#smetaobj tr' ,function(e) {
	var $a;
	var $b;
	$a= $(this).attr('rowcod');
	$b= $(this).attr('smetacod');
	ShowSmetaDet($a,$b);
  });

  $('body').on('change', '#imgfile', function(event){
	let id = $('#id').attr('value');  
    $('#photoform').ajaxSubmit({
		type: 'POST',
		url: 'ajax/uploadfoto.php',
		data: 'obj/'+id+'/',
		target: '#photorez',
		success: function() {
			// После загрузки файла очистим форму.
			//$('#photoform')[0].reset();
			console.log('ok');
		},
		error: function(a,b){
                console.log('error: '+a);
            } 
	});
});