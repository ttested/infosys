<?php
// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

//подключаемся к базе
//$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
//$db = $rootH .'/core/db.php';
//require_once ($db);
$link = InitDB();
	
if(isset($_POST['submit']))
{
    //название таблицы и полей
	$tabName = 'users';
	$tabName = TN($tabName);
	$userID = 'id';
	$userFIO = 'fio';
	$user_login = 'login';
	$user_password = 'password';
	$user_hash ='hash';
	$user_ip='ipv4';
	
	// Вытаскиваем из БД запись, у которой логин равняеться введенному
	$sql = 'SELECT '.$userID.', '.$userFIO.', '.$user_password.' FROM '.$tabName.' WHERE '.$user_login.'="'.mysqli_real_escape_string($link,$_POST['login']).'" LIMIT 1';
    $query = mysqli_query($link,$sql);
    $data  = mysqli_fetch_assoc($query);
    
   // echo mysqli_real_escape_string($link,$_POST['login']).'<br>' .	$tabName .'<br>' .$sql.'<br>' . md5(md5($_POST['password'])).'<br>'.$data[$user_password];
	
    // Сравниваем пароли
    if($data[$user_password] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ', '.$user_ip.'=INET_ATON("'.$_SERVER['REMOTE_ADDR'].'")';
        }
        else
        {
            $insip='';
        }

        // Записываем в БД новый хеш авторизации и IP
        $sql = 'UPDATE '.$tabName.' SET '.$user_hash.'="'.$hash.'" '.$insip.' WHERE '.$userID.'='.$data[$userID];
        //echo $sql;
        mysqli_query($link, $sql);

        // Ставим куки
        setcookie("id", $data[$userID], time()+60*60*24*30, "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!

        // Очищаем данные из формы
        unset($_POST);
        
        //Сохраняем текущего пользователя
        $UserCOD =$data[$userID];
        $UserName = $data[$userFIO];
        
        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: /test/index.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
else
{
    print "Форма не подгрузилась";
}

