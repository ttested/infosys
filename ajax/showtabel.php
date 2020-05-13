 <?php
if (isset($_POST["idb"]) && isset($_POST["dat"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/formbilder.php');
	echo BuildForm($_POST["idb"],$_POST["dat"]);
}
else
{
    print_r($_POST);
}