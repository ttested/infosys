<?php
if (isset($_POST["id"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/formedit.php');
	echo EditGrid('photos', $_POST["id"]);
}
else
{
    print_r($_POST);
}