<?php 
 
$file = @$_FILES['file'];
$error = $success = '';
 
// Разрешенные расширения файлов.
$allow = array('jpg', 'jpeg', 'png', 'gif');
 
// Директория, куда будут загружаться файлы.
$path = $_SERVER["DOCUMENT_ROOT"] . '/test/img/';

// Если есть указание места, то туда
if(isset($_POST['folder']))
{
	$path .= $_POST['folder'];
}
 
if (!empty($file)) {
	// Проверим на ошибки загрузки.
	if (!empty($file['error']) || empty($file['tmp_name'])) {
		switch (@$file['error']) {
			case 1:
			case 2: $error = 'Превышен размер загружаемого файла.'; break;
			case 3: $error = 'Файл был получен только частично.'; break;
			case 4: $error = 'Файл не был загружен.'; break;
			case 6: $error = 'Файл не загружен - отсутствует временная директория.'; break;
			case 7: $error = 'Не удалось записать файл на диск.'; break;
			case 8: $error = 'PHP-расширение остановило загрузку файла.'; break;
			case 9: $error = 'Файл не был загружен - директория не существует.'; break;
			case 10: $error = 'Превышен максимально допустимый размер файла.'; break;
			case 11: $error = 'Данный тип файла запрещен.'; break;
			case 12: $error = 'Ошибка при копировании файла.'; break;
			default: $error = 'Файл не был загружен - неизвестная ошибка.'; break;
		}
	} elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
		$error = 'Не удалось загрузить файл.';
	} else {
	
		// Расширение файла
		$imageFormat = explode('.', $file['name']);
		$imageFormat = $imageFormat[1];
	 
		// Генерируем новое имя для изображения. 
		$name = hash('crc32',time()) . '.' . $imageFormat;
 
		$parts = pathinfo($name);
		if (empty($name) || empty($parts['extension'])) {
			$error = 'Не удалось загрузить файл.';
		} elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
			$error = 'Недопустимый тип файла';
		} else {
			// Перемещаем файл в директорию.
			if (move_uploaded_file($file['tmp_name'], $path . $name)) {
				// Далее можно сохранить название файла в БД и т.п.
				$success = '<img id="photo" class="phpreview" src="./img/'. $name.'"/><input id="photofile" name="photofile" type="hidden" value="'.$name.'"/>';
			} else {
				$error = 'Не удалось загрузить файл.';
			}
		}
	}
 
	// Выводим сообщение о результате загрузки.
	if (!empty($success)) {
		echo  $success ;		
	} else {
		echo '<span class="error">' . $error . '</span>';
	}
}