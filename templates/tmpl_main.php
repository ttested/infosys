<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Вход в автоматизированную систему">

    <title>АСУ Строй <!--{title}--></title>

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
  <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Навигация</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Навигация">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <!--ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Индикаторы <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Документы</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Управление</a>
        </li>
      </ul-->
      <!--{nav}-->
      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Введите что найти" aria-label="Поиск">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
      </form>
    </div>
  </nav>
</header>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="content">
	<h1><!--{h1}--></h1>
  
	</div>
</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted"><!--{footer}--></span>
  </div>
</footer>

<div id="popup"></div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="./dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>