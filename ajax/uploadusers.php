<?php
function loadexl($filepach, $dbtable)
{
	 $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	 require_once ($rootH .'/core/db.php');
	 require_once ($rootH .'/Classes/PHPExcel.php');
	 
	 $objPHPExcel = PHPExcel_IOFactory::load($filepach);
	 
	 foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			break;
		}
	 $highestRow = $worksheet->getHighestRow(); // получаем количество строк
	 $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок
	 
	 $sql = 'INSERT INTO (';
	 for ($row = 0; $row < $highestRow; $row++)
	 {
		 if ($row ==0)
		 {
			 for ($i=0; $i < $highestColumn; $i++)
			 {
				 if ($sql == 'INSERT INTO (')
				 {
					 $sql .= $worksheet->getCellByColumnAndRow($i, $row);
				 }
				 else
				 {
					 $sql .= ', '.$worksheet->getCellByColumnAndRow($i, $row);
				 }	 
			 }
			 $sql .= ') VALUES '; 
		 }
		 else
		 {
			 if ($row ==1)
			 {
			 $sql .= '(';}
			 else
			 {$sql .= ',(';}
		 
			 for ($i=0; $i < $highestColumn; $i++)
				 {
					 if ($i==0)
					 {
						 $sql .= '"'.$worksheet->getCellByColumnAndRow($i, $row).'"';
					 }
					 else
					 {
						 $sql .= ', "'.$worksheet->getCellByColumnAndRow($i, $row).'"';
					 }	 
				 }
		 }
	 }
	$link = InitDB();
	$query = mysqli_query($link,$sql)or die("Ошибка записи пользователя");
	mysqli_free_result($query);
	closeDB($link);
}


//////////////////////////////////////////////////////////////////////
if (isset($_POST['load']))
{
	loadexl($_POST['filepach'],$_POST['dbtable']);
}