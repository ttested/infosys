 <?php
if (isset($_POST["id"]) && isset($_POST["tab"]) && isset($_POST["fld"])&& isset($_POST["fid"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/formedit.php');
	echo EditGrid($_POST["tab"], $_POST["id"],$_POST["fld"],$_POST["fid"]);
}
else
{
    print_r($_POST);
}