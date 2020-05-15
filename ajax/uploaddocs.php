<?php
if (isset($_FILES)&&isset($_POST))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	$link =  InitDB();
	
    //echo $sql;
    echo "Ok";

    $idbuild = $_POST['id_buildin'];
    $desc    = $_POST['descr'];
   
    $count = 0;
    $arrok=[];
    $arrer=[];

    $fldr = $rootH.'/docs/obj/'.$idbuild.'/';
    if ( !file_exists( $fldr ) ) {
        mkdir( $fldr,0777,true );       
    } 
    //Upload Files
    foreach($_FILES as $docs) {
        $srcfile=$docs['name'];
        list($name,$ext) = explode('.',$srcfile);
        $doc = uniqid().'.'.$ext;
        
        $uploadfile =  $fldr. $doc;
        if (move_uploaded_file($docs['tmp_name'], $uploadfile)) {
            $sql = "INSERT INTO nr32_docs (idbuilding, descr, filedoc, filelbl) VALUES ($idbuild,'$desc','$doc','$srcfile')";
           // echo $sql;
            mysqli_query($link,$sql)or die("Ошибка добавления документа $name `$sql`");
            $arrok[]=$srcfile;
            $count++;
        }
        else {
          //  echo $srcfile;
            $arrer[]=$srcfile;
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