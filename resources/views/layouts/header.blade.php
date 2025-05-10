<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
    <!-- Scripts -->
  <!-- @viteReactRefresh -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <!-- <link rel="stylesheet" href="css/normalize.css"> -->
  <!-- <link rel="stylesheet" href="css/styles.css"> -->
  <link rel="stylesheet" href="css/styles.css"> -->
  <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


</head>

<body>
  <div style="width: 990px; margin: auto;">
    <!-- Подключаем блок авторизации  -->
    @include('layouts/loginInHead')
  </div>


  <header class="page-header">
    <a href="/" style="text-decoration: none;">
      <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    </a>
  </header>