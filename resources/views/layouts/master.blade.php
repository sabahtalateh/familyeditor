<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Family Editor</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    @yield('headscripts')
</head>
<body>
<div class="container">
    <h3>Построитель генеалогичеких деревьев</h3>
    <div class="btn-group">
        <button type="button" class="btn btn-primary">Люди</button>
        <button style="height: 34px" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{route('person.list')}}">Список</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{route('person.create')}}">Добавить</a></li>
        </ul>
    </div>

    <div class="btn-group">
        <button type="button" class="btn btn-primary">Потомки людей</button>
        <button style="height: 34px" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{route('person.children.create')}}">Добавить</a></li>
        </ul>
    </div>
    <br>
    <br>
    @include('blocks.flash')
    @yield('content')
</div>
</body>
</html>