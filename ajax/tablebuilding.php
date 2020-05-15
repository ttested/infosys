<?php

function getPhoto($id)
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    require_once ($rootH .'/forms/gallery.php');
    $link = InitDB();
    $sql = 'SELECT nr32_photos.id, nr32_photos.id_buildin, nr32_photos.descr, nr32_photos.photofile, nr32_photos.datetm, nr32_smeta_obj.descr AS etap FROM nr32_photos INNER JOIN nr32_smeta_obj ON nr32_photos.id_smeta = nr32_smeta_obj.id WHERE nr32_photos.id_buildin = '. $id . ' ORDER BY nr32_photos.datetm DESC';
    $query = mysqli_query($link,$sql)or die("Ошибка получения фотографий `$sql`");
    $galery=[];
    while( $data  = mysqli_fetch_assoc($query))
    {
        $galery[]=$data;
    }
    
    mysqli_free_result($query);
    closeDB($link);

    if (!sizeof( $galery ))
    {
        $arr['id_buildin']=$id;
        $arr['photofile']='.';
        $arr['descr']='';
        $arr['etap']='';
        $arr['datetm ']=date('Y-m-dTH:i:s');
        $arr['fake']=1;
        $galery[] = $arr;
       
    }

    return ShowGalery($galery);
}

function getDocs($id)
{
    
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    require_once ($rootH .'/forms/docs.php');
    $link = InitDB();
    $sql = "SELECT vds.id, vds.descr, vds.filedoc, vds.filelbl, vds.idbuilding, vds.building, vds.address, vds.orderidx FROM nr32_v_docs vds WHERE vds.delrec=0 AND vds.idbuilding=$id ORDER BY vds.orderidx, vds.id DESC";
    $query = mysqli_query($link,$sql)or die("Ошибка получения фотографий `$sql`");
    $docs=[];
    while( $data  = mysqli_fetch_assoc($query))
    {
        $docs[]=$data;
    }
    
    if (!sizeof( $docs ))
    {
        $arr['idbuilding']=$id;
        $arr['filedoc']='.';
        $arr['filelbl']='';
        $arr['descr']='';

        $docs[] = $arr;
       
    }
    
    mysqli_free_result($query);
    closeDB($link);
    return ShowDocs($docs);
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

function getExecutors($id)
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    require_once ($rootH .'/forms/executors.php');
    $link = InitDB();
    $sql = "SELECT ve.id,ve.id_building, ve.fio, ve.appointment, ve.persentpay FROM nr32_v_executors ve WHERE ve.id_building=$id ORDER BY ve.orderidx, ve.id DESC";
    $query = mysqli_query($link,$sql)or die("Ошибка получения исполнителей `$sql`");
    $docstmp=[];
    $docs['idbuilding']=$id;
    while( $data  = mysqli_fetch_assoc($query))
    {
        $docstmp[]=$data;
    }
    mysqli_free_result($query);
    $sql = "SELECT nb.id, nb.descr FROM nr32_brigada nb WHERE nb.idbuilding =$id ORDER BY nb.orderidx, nb.id DESC";
    $query = mysqli_query($link,$sql)or die("Ошибка получения бригад `$sql`");
    $brigads=[];
    $brid='';
    while( $data  = mysqli_fetch_assoc($query))
    {
        $brigads[]=$data;
        if($brid)
        {
            $brid .=', '.$data['id'];
        }
        else {
            $brid .= $data['id'];
        }
    }

    if ($brid !='')
    {
        $docs['brigads'] =  $brigads;
        $sql = "SELECT nvbs.idbrigada, nvbs.fio, nvbs.profes, nvbs.boss, nvbs.worck FROM nr32_v_brigada_spis nvbs WHERE nvbs.idbrigada IN ($brid) ORDER BY nvbs.idbrigada, nvbs.orderidx";
        $query = mysqli_query($link,$sql)or die("Ошибка получения списка бригады `$sql`");
        $brigadspis=[];
        while( $data  = mysqli_fetch_assoc($query))
        {
            $brigadspis[]=$data;
        }
        if (sizeof($brigadspis))
        {
            $docs['brigadsspis'] = $brigadspis;  
        }
    }


    if (sizeof( $docstmp ))
    {
        $docs['executors'] =$docstmp;
    }
    
    
    mysqli_free_result($query);
    closeDB($link);
    return ShowExecutors($docs);
}

//Селектор страниц
if (isset($_POST['tab']))
{
   
    switch ($_POST['tab'])
    {
        case '#photos':
            echo getPhoto($_POST['id']);
        break;
        case '#docs':
            echo getDocs($_POST['id']);
        break;
        case '#smeta':
            echo getSmetaObj($_POST['id']);
        break;
        case '#executors':
            echo getExecutors($_POST['id']);
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