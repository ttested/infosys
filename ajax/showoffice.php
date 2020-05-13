 <?php
if (isset($_POST["id"]) && isset($_POST["tab"]))
{
    $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/formedit.php');
	echo EditGrid($_POST["tab"], $_POST["id"]);
}
else
{
    print_r($_POST);
}