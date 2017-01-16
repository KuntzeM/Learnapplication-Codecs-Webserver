{!!Html::script('js/jquery-3.1.0.min.js') !!}
{!!Html::style('css/font-awesome.css') !!}
{!!Html::style('css/bootstrap.min.css')!!}
{!!Html::style('css/frontend.css')!!}
{!!Html::script('js/bootstrap.min.js')!!}
{!!Html::script('js/jquery.ui.widget.js')!!}
{!!Html::script('js/splitview/requestAnimationFrame.min.js')!!}
{!!Html::script('js/splitview/hammer.min.js')!!}
{!!Html::script('js/splitview/jquery.images-compare.js')!!}
{!!Html::script('js/functions_frontend.js')!!}
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Learning Applikation</title>

    <style>
        body {
            margin-top: 5%;
        }
    </style>
    <script>
        var url = "{!! $url !!}";
    </script>
</head>
<body>
<div class='container-fluid'>
      @section('nav')
    @show

    <div class='row'>
        @yield('content')
    </div>
</div>
</body>
</html>