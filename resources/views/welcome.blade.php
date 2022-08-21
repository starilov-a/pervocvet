<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <!-- Scripts -->


        <!-- Styles -->
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/font-awesome-4.7.0/css/font-awesome.min.css">

    </head>
    <body>
        <div class="main">
            <div class="bar">
                <h1>{{ config('app.name') }}</h1>
                <div class="nav-bar">
                    <ul>
                        <li class="active-nav-item">Дети</li>
                        <li>Статистика приходов</li>
                    </ul>
                </div>
                <div class="login-block">
                    <div class="button-exit">
                        <button>Выход</button>
                    </div>
                    <div class="login">
                        <p>Иванова Анастасия</p>
                    </div>
                </div>
            </div>
            <div class="right-container">
                <div class="container-header">
                    <div class="header-title"><h2>Дети</h2></div>
                    <div class="header-button">
                        <button onclick="changePopup('addKid', true);return false;">Добавить</button>
                    </div>
                    <div class="header-select">
                        <input placeholder="Поиск ребёнка">

                        </input>
                    </div>
                </div>
                <div class="container-main">
                    <table class="table-kids">
                        <thead>
                            <tr>
                                <th class="col-1">Имя</th>
                                <th class="col-2">Информация</th>
                                <th class="col-3">Группы</th>
                                <th class="col-4">Истоия оплаты</th>
                                <th class="col-5"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="col-1">текст</th>
                                <th class="col-2">тексттекст</th>
                                <th class="col-3">текст текст текст текст текст текст текст текст текст текст</th>
                                <th class="col-4">тексттексттекст</th>
                                <th class="col-5"><a href="/">Изменить</a></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('kid.addPopup')
        <script src="/js/main.js"></script>
        <script src="/js/jquery-3.6.0.min.js"></script>
    </body>
</html>
