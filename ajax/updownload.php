<?php
function loadexl($filepach, $dbtable)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	require_once ($rootH .'/Classes/PHPExcel.php');
	require_once ($rootH .'/Classes/PHPExcel/Writer/Excel2007.php');
	require_once ($rootH .'/Classes/PHPExcel/IOFactory.php');
	 
	 $objPHPExcel = PHPExcel_IOFactory::load($filepach);
	 
	 foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			break;
		}
	 $highestRow = $worksheet->getHighestRow(); // получаем количество строк
	 $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок
	 
	 $sql = 'INSERT INTO '.$dbtable.' (';
	 for ($row = 0; $row < $highestRow; $row++)
	 {
		 if ($row ==0)
		 {
			 for ($i=0; $i < $highestColumn; $i++)
			 {
				 if ($sql == 'INSERT INTO '.$dbtable.' (')
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

function saveexl( $dbtable)
{
	$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
	require_once ($rootH .'/core/db.php');
	require_once ($rootH .'/Classes/PHPExcel.php');
	require_once ($rootH .'/Classes/PHPExcel/Writer/Excel2007.php');
	
	$link = InitDB();
	$sql = 'SELECT * FROM `nr32_'.$dbtable.'`';
	$query = mysqli_query($link,$sql)or die("Ошибка чтения таблицы ");
	
	$keys =[];
	while($data  = mysqli_fetch_assoc($query))
	{
		if ($keys ===[]) {
			// получение всех ключей массива
			$keys = array_keys($data);
		}
		$values[]=array_values($data);
	}
	mysqli_free_result($query);
	closeDB($link);
		
	$xls = new PHPExcel();
	
	$xls->getProperties()->setTitle("Выгрузка из ASU picashowdom");
	$xls->getProperties()->setSubject($dbtable);
	/*$xls->getProperties()->setCreator("Автор");
	$xls->getProperties()->setManager("Руководитель");
	$xls->getProperties()->setCompany("picashowdom");
	$xls->getProperties()->setCategory("Группа");
	$xls->getProperties()->setKeywords("Ключевые слова");
	$xls->getProperties()->setDescription("Примечания");
	$xls->getProperties()->setLastModifiedBy("Автор изменений");*/
	$xls->getProperties()->setCreated(date('d-m-Y'));
	
	$xls->setActiveSheetIndex(0);
	$sheet = $xls->getActiveSheet();
	$sheet->setTitle($dbtable);
	
	//Заполняем файл
	$cnt=sizeof($keys);
	//шапка
	for($i=0; $i<$cnt; $i++)
	{
	   
	   $colString = PHPExcel_Cell::stringFromColumnIndex($i);
	   $celN = $colString."1";
	   $sheet->setCellValueExplicit($celN, $keys[$i], PHPExcel_Cell_DataType::TYPE_STRING); 
	   $sheet->getStyle($celN)->getAlignment()->setWrapText(true);
	   
       

	}
	//данные
	$j=1;
	foreach($values as $value)
	{
	    $j++;
	    for($i=0; $i<$cnt; $i++)
    	{
    	   $colString = PHPExcel_Cell::stringFromColumnIndex($i);
    	   $celN = $colString.$j;
    	   $sheet->setCellValueExplicit($celN, $value[$i], PHPExcel_Cell_DataType::TYPE_STRING); 
    	   $sheet->getStyle($celN)->getAlignment()->setWrapText(true);
    	 // Авто ширина колонки по содержимому
       //$sheet->getColumnDimensionByColumn($colString)->setAutoSize(true);
    	}
	    
	}
	
	header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=".$dbtable.".xlsx");
	 
	$objWriter = new PHPExcel_Writer_Excel2007($xls);
	$objWriter->save('php://output'); 
}
//////////////////////////////////////////////////////////////////////
if (isset($_POST['upload']))
{
	loadexl($_POST['filepach'],$_POST['dbtable']);
}
elseif (isset($_POST['download']))
{
    if(isset($_POST['dbtable'])){
	saveexl($_POST['dbtable']);
    }
    else
    {
      print_r($_POST);  
    }
}else {print_r($_POST);}