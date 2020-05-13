<?php

function getPhoto($id)
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    require_once ($rootH .'/forms/gallery.php');
    $link = InitDB();
    $sql = 'SELECT nr32_photos.id, nr32_photos.id_buildin, nr32_photos.descr, nr32_photos.photofile, nr32_photos.datetm, nr32_smeta_obj.descr AS etap FROM nr32_photos INNER JOIN nr32_smeta_obj ON nr32_photos.id_smeta = nr32_smeta_obj.id WHERE nr32_photos.id_buildin = '. $id . ' ORDER BY nr32_photos.datetm DESC';
    $query = mysqli_query($link,$sql)or die("Ошибка получения фотографий `$sql`");

    while( $data  = mysqli_fetch_assoc($query))
    {
        $galery[]=$data;
    }
    
    mysqli_free_result($query);
    closeDB($link);
    return ShowGalery($galery);
}

function getSmetaObj($id, $selid=0)
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    require_once ($rootH .'/core/tools.php');
    $link = InitDB();
    $sql = 'SELECT ns.id, ns.id_building, ns.id_smeta_obj, nso.descr, ns.kolvo, ndm.descr as edizm 
    FROM nr32_smeta ns INNER JOIN nr32_smeta_obj nso ON ns.id_smeta_obj = nso.id
    INNER JOIN nr32_dict_metric ndm ON nso.edizm = ndm.id
    WHERE ns.id_building ='.$id;
    $query = mysqli_query($link,$sql)or die("Ошибка получения сметы `$sql`");

    $grid = '<div class="table-responsive"><table id="smetaobj" class="table table-hover table-striped table-bordered table-condensed table-sm">';
    $grid .='<thead><tr class="table-primary">';
    foreach (['№ п.п.','Наименование','Количество','Ед. изм.'] as $theader)
	{
		$grid .= '<th scope="col" >'.$theader.'</th>';
	}
    $grid .='</tr></thead><tbody>';
    $npp=1;
    while( $rows  = mysqli_fetch_assoc($query))
    {
        if (($selid == $rows['id'])||($selid==0 && $npp==1))
			{
				$grid .= '<tr rowcod="'.$rows['id'].'" smetacod="'.$rows['id_smeta_obj'].'" class="marked">';
			}
		else
			{
                $grid .= '<tr rowcod="'.$rows['id'].'" smetacod="'.$rows['id_smeta_obj'].'">';
            }
        $grid .= '<td>'.$npp++.'</td>';
        foreach(['descr','kolvo','edizm'] as $rname)
        {
            $grid .= '<td>'.$rows[$rname].'</td>';
        }
        $grid .= '</tr>';
    }
    mysqli_free_result($query);
    closeDB($link);

    $grid .= '</tbody></table></div>';

    $grid .= '<br/><div class="row">';
    $grid .= '<div class="form-group col-sm-5">
    <select class="form-control browser-default custom-select" id="idobj" aria-describedby="objsmetaHelp">
    '.fillData('nr32_v_smetaobjnz').'
    </select>
     <small id="objsmetaHelp" class="form-text text-muted">Название основного объекта сметы.</small>
    </div>';

    $grid .= '
            <div class="form-group col-sm-4">
				<input type="text" class="form-control" id="kolvo" aria-describedby="kolvoHelp" placeholder="Количество">
				<small id="pidHelp" class="form-text text-muted">Количество всего</small>
			</div>';
    
    $grid .= '<div class="form-group col-sm-3"><button type="button" class="btn btn-primary" onClick="EditSmeta('.$id.');">Новая запись</button><div>';
    $grid .= '</div>';
    

    return $grid;
}


if (isset($_POST['tab']))
{
   
    switch ($_POST['tab'])
    {
        case '#photos':
            echo getPhoto($_POST['id']);
        break;
        case '#smeta':
            echo getSmetaObj($_POST['id']);
        break;
        

        default:
            echo 'tab = '. $_POST['tab'].  ' id = '. $_POST['id'];
        break;
    }
    
    /*if ($_POST['tab']==='#photos')
    {
        echo getPhoto($_POST['id']);
    }
    else {
        echo 'tab = '. $_POST['tab'].  ' id = '. $_POST['id'];
    }*/
}
else {
    print_r($_POST);
}