 <?php
function GetOptions($sel='')
{
    if ($sel=='')
    {
        $rez = fillData('nr32_brigada');
    }
    else {
        $rez = fillData('nr32_brigada',false,'id',$sel);
    }
    return $rez;
}

if (isset($_POST["idbuilding"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    require_once ($rootH .'/core/tools.php');

    $link =  InitDB();
    $idbuilding = $_POST["idbuilding"];
    //Загружаем существующие значения
    $sql = "SELECT nw.id_brigada, nw.datebegin, nw.dateend, nw.id_smetaobj FROM nr32_workplan nw WHERE nw.id_building=$idbuilding";
    $query = mysqli_query($link,$sql)or die("Ошибка построения списка полей [$sql]");
    $values =[];
    while($data  = mysqli_fetch_assoc($query))
    {
        $values[$data['id_smetaobj']]['brigada']=$data['id_brigada'];
        $values[$data['id_smetaobj']]['datebegin']=$data['datebegin'];
        $values[$data['id_smetaobj']]['dateend']=$data['dateend'];
    }
    mysqli_free_result($query);

    //Строим таблицу
    $sql ="SELECT * FROM nr32_v_workplan_list wl WHERE wl.id_building=$idbuilding";
    $query = mysqli_query($link,$sql)or die("Ошибка построения списка полей [$sql]");
    $grid = '<div class="table-responsive">';
	$grid .= '<table id="editworkplan" class="table table-hover table-striped table-bordered table-condensed table-sm" cellspacing="0" width="100%"><thead><tr class="table-primary">';
    // Заголовок
    foreach (['№ п.п.','Этап строительства','Количество','Ед. изм.','Дата начала<br><hr>Дата окончани','Бригада'] as $theader) {
		$grid .= '<th scope="col" >' . $theader . '</th>';
    }
    $grid .= '</tr></thead><tbody>';
    $brigada = GetOptions();
    $smety='<input type="hidden" class="form-control" id="idbuilding" value="'.$idbuilding.'">';
    // Строим строки таблицы
    while($data  = mysqli_fetch_assoc($query))
    {
        $grid .= '<tr>';
        $grid .= '<td>'.$data['id'].'</td>'; 
        $grid .= '<td>'.$data['etap'].'</td>';
        $grid .= '<td>'.$data['kolvo'].'</td>';
        $grid .= '<td>'.$data['edizm'].'</td>';

        $valdtfrom = '';
        $valdtto = '';
        if (isset($values[$data['id']]['datebegin']))
        {
            $valdtfrom = ' value="'.$values[$data['id']]['datebegin'].'"';
        }

        if (isset($values[$data['id']]['dateend']))
        {
            $valdtto = ' value="'.$values[$data['id']]['dateend'].'"';
        }

        //Данные для ввода
        $grid .= '<td><input type="date" id="dtfrom'.$data['id'].'" '.$valdtfrom.'><br>';
        $grid .= '<input type="date" id="dtto'.$data['id'].'" '.$valdtto.'></td>';
        if (isset($values[$data['id']]['brigada']))
        {
            $grid .= '<td><select id="brigada'.$data['id'].'">'.GetOptions($values[$data['id']]['brigada']).'</select></td>';
        }
        else {
            $grid .= '<td><select id="brigada'.$data['id'].'">'.$brigada.'</select></td>';
        }

        $grid .= '</tr>';
        $smety .='<input type="hidden" class="form-control" id="idsmeta'.$data['id'].'" value="'.$data['id'].'">';
    }
    mysqli_free_result($query);
	closeDB($link);
    $grid .= '</tbody></table></div>';

    //Строим форму
    $tabname = 'workplan';
	$modalid = 'modal_'.$tabname;
	$modaltitle = $modalid.'Title';
	$modallabel = 'Редактирование '.$tabname;
	
	$modal =  '<div class="modal fade bd-example-modal-lg" id="'.$modalid.'" tabindex="-1" role="dialog" aria-labelledby="'.$modaltitle.'" aria-hidden="true">';
	$modal .= '<div class="modal-dialog modal-dialog-centered modal-lg" role="document">';
    $modal .= '<div class="modal-content">';
    $modal .= '<div class="modal-header">';
    $modal .= '<h5 class="modal-title" id="exampleModalLongTitle">'.$modallabel.'</h5>';
    $modal .= '<button type="button" class="close" data-dismiss="'.$modalid.'" aria-label="Close"  onclick="CloseMy();">';
    $modal .= '<span aria-hidden="true">&times;</span>';
    $modal .= '</button>';
    $modal .= '</div>';
    $modal .= '<div class="modal-body">';
	$modal .='<form id="frm_'.$tabname.'">';
    $modal .=$grid;
    $modal .=$smety;
    //закрываем модальное окно
    $modal .='</div><div class="modal-footer">';
    $modal .='<button class="btn btn-success" onclick ="SaveMy(\'frm_'.$tabname.'\');"  type="submit">Сохранить</button>';
    //$modal .='<button class="btn btn-warning" onclick ="ClearMy();" type="reset">Отменить</button>';
    $modal .='<button class="btn btn-danger" data-dismiss="'.$modalid.'" onclick="CloseMy(\''.$modalid.'\');">Закрыть</button>';
    $modal .=' </div></form>';
    $modal .='</div></div></div>';

    echo $modal;

}
else
{
    print_r($_POST);
}