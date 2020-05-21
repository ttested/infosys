<?php
if (isset($_POST["smeta"])&&isset($_POST["building"])&&isset($_POST["pay"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	
    $link = InitDB();
    $smeta = $_POST["smeta"];
    $smetaobj = $_POST["smetaobj"];
    $building = $_POST["building"];
    $pay = $_POST["pay"];
    
	$sql="INSERT INTO nr32_smeta_pay (id_smeta,id_building,pay) values ( $smeta, $building, $pay )";
	
    mysqli_query($link,$sql)or die("Ошибка записи [$sql]");

    $sql="SELECT nvspo.sumpay
    FROM nr32_v_smeta_pay_obj nvspo
    WHERE nvspo.id = $smetaobj
      AND nvspo.id_building = $building"; 
    
    $query = mysqli_query($link,$sql)or die("Ошибка чтения  [$sql]");
    $data  = mysqli_fetch_assoc($query);
	mysqli_free_result($query);
    closeDB($link);
    echo $data['sumpay'];
}
else
{
    print_r($_POST);
} 