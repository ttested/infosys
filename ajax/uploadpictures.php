<?php
//echo 'error: '. print_r($_POST);
//echo 'error: '. print_r($_POST).' // '. print_r($_FILES);
//*
if (isset($_FILES)&&isset($_POST))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
    //echo $sql;
    echo "Ok";

    $idbuild = $_POST['id_buildin'];
    $desc    = $_POST['descr'];
    $idsmeta = $_POST['id_smeta']; 
    $count = 0;
    $arrok=[];
    $arrer=[];
    //Upload Files
    foreach($_FILES as $Pictures) {

        list($name,$ext) = explode('.',$Pictures['name']);
        $photo = uniqid().'.'.$ext;
        $uploadfile =  $rootH.'/img/obj/'.$idbuild.'/'. $photo;
        if (move_uploaded_file($Pictures['tmp_name'], $uploadfile)) {
            $sql = "INSERT nr32_photos (id_buildin, descr, photofile, id_smeta) VALUES ($idbuild,'$desc','$photo',$idsmeta)";
           // echo $sql;
            mysqli_query($link,$sql)or die("Ошибка добавления изображения ".$dat." `$sql`");
            $arrok[]=$Pictures['name'];
            $count++;
        }
        else {
          //  echo $Pictures['name'];
            $arrer[]=$Pictures['name'];
        }

    }

    if (!empty($arrok))
    {
        $report['success'] = $arrok;
    }
    
    if (!empty($arrer))
    {
        $report['errors'] = $arrer;
    }

   echo json_encode ( $report );
}
else {
    echo 'error: ';
}//*/