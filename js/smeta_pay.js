var $snam = 'smeta_pay';
var $tab = "smeta_pay"
var $tablename = "#modal_" + $tab;


function ShowSmetaPay($fnam = '', $div = '', $frmed = '',idbuilding=-1) {
	if ($fnam == '') { $fnam = $snam; }
	if ($div == '') { $div = $tab; }
	if ($frmed == '') { $frmed = $tablename; }
	let mdata='zagl=0';
	if (idbuilding>=0)
	{
		let selrec = $('#smeta_pay_obj').find('tr.marked').attr('rowcod');
		mdata = 'id_building='+idbuilding+'&selrec = '+selrec;
	}
	//console.log(mdata);
	$.ajax({
		url: "ajax/show" + $fnam + "list.php", type: "POST", data: mdata,
		beforSend: function () { $("#" + $div).html("<div class=\"cssload-clock\"></div>"); },
		success: function (data) { $("#" + $div).html(data); $($frmed).modal("hide"); StartDT(); MarkDT(); },
		error: function (a, b) { alert(a.responseText) }
	});
}

function Refresh(idobj,newsumm=0) {
	let selrec = 0;
	let id_building = $('#idbuilding').val();
	let table="#smeta_pay_obj";
	$.ajax({
		type: "POST",
		url: "ajax/refresh" + $snam + "list.php",
		data: "selrec=" + selrec + "&id_smeta=" + idobj + "&id_building=" + id_building,
		beforSend: function () { $("#secondGrid").html("<div class=\"cssload-clock\"></div>"); },
		success: function (data) {
			$("#secondGrid").html(data);
			StartDT('#smeta_pay_det');
			if (newsumm > 0)
			{
				$(table).find('tr.marked td:eq("3")').html(newsumm); 
			}
			MarkDT();
		},
		error: function (a, b) { alert(a.responseText) }
	});
}

function EditSmetaPay($cod, $fnam = '', $div = '', $frmed = '', $typpay = 0) {
	if ($fnam == '') { $fnam = $snam; }
	if ($div == '') { $div = $tab; }
	if ($frmed == '') { $frmed = $tablename; }
	$.ajax({
		type: "POST",
		url: "ajax/show" + $fnam + ".php",
		data: "tab=" + $div + "&id=" + $cod + "&typpay=" + $typpay,
		success: function (data) { $("#popup").html(data); $($frmed).modal("show") },
		error: function (a, b) { alert(a.responseText()); }
	});
}

function CloseMy($frmed = '') { $($tablename).modal("hide"); }

function ClearMy() { $("form").trigger('reset'); }

function SaveMy(frm, $frmed = '') {
	$data = '';
	$value = 0;
	if ($frmed == '') { $frmed = $tablename; }
	$("#" + frm).find('input, textearea, select').each(function () {
		$atr = $(this).attr("type");
		if (($atr !== undefined) & ('checkbox' === $atr)) {
			if ($(this).is(':checked')) { $value = 1; } else { $value = 0; }
		}
		else {
			$value = $(this).val();
		}

		if ($data === '') {
			$data = $data + this.id + '=' + $value;
		}
		else {
			$data = $data + '&' + this.id + '=' + $value;
		}
	});
	$.ajax({
		url: "ajax/save" + $snam + ".php", type: "post", data: $data,
		success: function (data) { ShowSmetaPay(); $($frmed).modal("hide"); console.log(data); }, error: function (a, b) { alert(a.responseText()); }
	});
}

$('body').on('click', '#smeta_pay_obj tr', function (e) {
	var $a;
	$a = $(this).attr('rowcod');
	//console.log($a);
	Refresh($a);
});

//Редактирование цены сметы
$('body').on('dblclick', '#smeta_pay_det tbody tr td', function (e) {
	let a = $(this);
	let col = $(this).parent().children().index($(this));
	if (col == 3) {
		let id_smeta = GetSelRow('#smeta_pay_det');
		let id_building = $('#idbuilding').val();
		let b = a.html();
		a.html('<input id="editprice" oldval="' + b + '" smeta="' + id_smeta + '" id_building="' + id_building + '" value="' + b + '">');
		a.find("input").focus().select();

	}
	
});

function DoEdit(mode='undo')
{
	let inputs = $('#smeta_pay_det tbody').find('tr td input');
	if (inputs) {
		let input = inputs[0];
		let td = inputs.parent('td');
		if (input) {
			if (mode==='undo')
			{td.html(input.attributes.oldval.nodeValue);}
			else if (mode==='edit')
			{
				//td.html(input.value);
				//сохраняем на сервере
				let smetaobj = GetSelRow('#smeta_pay_obj')
				let smeta = input.attributes.smeta.nodeValue;
				let building = input.attributes.id_building.nodeValue;
				let pay = input.value;
				let mdata = 'smeta='+smeta+'&building='+building+'&pay='+pay+'&smetaobj='+smetaobj;
				$.ajax({
					url: "ajax/savesmetapay.php", type: "post", data: mdata,
					success: function (answer) { 
						Refresh(smetaobj,answer); 
						console.dir(answer);}, 
					error: function (a, b) { alert(a.responseText); }
				});

			}
		}
	}
}

$('body').on('click', '#smeta_pay_det tbody tr td', function (e) {
	
	DoEdit();
	
});

$('body').on('keyup','#editprice',function(e) {
    if(e.which == 13) {
        DoEdit('edit');
	}
	else if(e.which == 27) {
        DoEdit('undo');
	}
});

//выбор объекта строительства
$('body').on('change', '#idbuilding', function(e) {
	let idbuilding = $(this).val();
	ShowSmetaPay('','','',idbuilding);
	//console.log(idbuilding);
});