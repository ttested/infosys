<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Вход в автоматизированную систему">

    <title>Страница входа | Автоматизированная система управления строительной фирмы</title>

    <!-- Bootstrap core CSS -->
<link href="./dist/css/bootstrap.min.css" rel="stylesheet">



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

  </head>

  <body class="text-center" style="display:block">
	<div class="content">

  <form class="form-signin" action="index.php" method="post" name="login">
  <img class="mb-4" src="https://pikashovdom.ru/upload/CAllcorp2/c74/c74ed943946caeeb6e25b030c1acb00a.png" alt="" width="156" height="72" alt="bootstrap">
  <h1 class="h3 mb-3 font-weight-normal">Пожалуйста выполните вход в систему</h1>
  <label for="login" class="sr-only">Логин</label>
  <input type="text" name="login" class="form-control" placeholder="Ваш логин" required autofocus>
  <label for="password" class="sr-only">Пароль</label>
  <input type="password" name="password" class="form-control" placeholder="Ваш Пароль" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" name="not_attach_ip"> Запретить проверять IP адрес (не безопасно)
    </label>
  </div>
  <input type="hidden" id="key" name="key" value="auth" class="form-control">
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Принять</button>
  <p class="mt-5 mb-3 text-muted">&copy; ООО Нужные решения 2020</p>
</form>
</div>
</body>
</html>