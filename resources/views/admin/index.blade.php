<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/admin/normalize.css">
  <link rel="stylesheet" href="css/admin/styles.css">
  <link
    href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext"
    rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>



  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторррская</span>
  </header>

  <main class="conf-steps">

  <!-- Подключаем 1 блок "Управление залами" -->
  @include('admin.hall_management');    

  <!-- Подключаем 2 блок "Конфигурация залов" -->
  @include('admin.configuration_of_halls');

  <!-- Подключаем 3 блок "Конфигурация цен" -->
  @include('admin.configuration_of_prices');

  <!-- Подключаем 4 блок "Сетка сеансов" -->
  @include('admin.configuration_of_sessions');

  <!-- Подключаем 5 блок "Открыть продажи" -->
  @include('admin.openSales');

  </main>
  <script src="js/accordeon.js"></script>
  <!-- <script src="js/halls.js"></script> -->
</body>

</html>