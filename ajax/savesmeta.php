<?php
if (isset($_POST['idbld']) && isset($_POST['idobj']) && isset($_POST['kolvo']))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
    require_once ($rootH .'/core/db.php');
    $link = InitDB();

    $id_building  = $_POST['idbld'];
    $id_smeta_obj = $_POST['idobj'];
    $kolvo        = $_POST['kolvo'];
    $sql = "SELECT ns.id FROM nr32_smeta ns WHERE ns.id_building=$id_building AND ns.id_smeta_obj = $id_smeta_obj";
    $test = mysqli_query($link,$sql)or die("Ошибка записи  `$sql`");
    $rows  = mysqli_fetch_assoc($test);
    if (isset($rows['id']))
    {
        $id = $rows['id'];
        $sql = "UPDATE nr32_smeta ns SET ns.kolvo = ns.kolvo + $kolvo WHERE ns.id = $id";
        echo "count updated";
    }
    else {
        $sql="INSERT nr32_smeta (id_building, id_smeta_obj, kolvo) VALUES ($id_building,$id_smeta_obj,$kolvo)";
        echo "position inserted";
    }
    mysqli_free_result($test);
    mysqli_query($link,$sql)or die("Ошибка записи  `$sql`");
    closeDB($link);
}
else {
    print_r($_POST);
}