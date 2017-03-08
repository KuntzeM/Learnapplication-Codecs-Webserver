{!!Html::script('js/jquery-3.1.0.min.js') !!}
{!!Html::style('css/font-awesome.css') !!}
{!!Html::style('css/bootstrap.min.css')!!}
{!!Html::style('css/frontend.css')!!}
{!!Html::style('css/editor_tinymce.css')!!}
<!--{!!Html::style('css/splitview/cocoen.min.css')!!}-->
{!!Html::style('css/splitview/images-compare.css')!!}

{!!Html::script('js/bootstrap.min.js')!!}
{!!Html::script('js/jquery.ui.widget.js')!!}
{!!Html::script('js/splitview/requestAnimationFrame.min.js')!!}
<!--{!!Html::script('js/splitview/cocoen.min.js')!!}-->
{!!Html::script('js/splitview/hammer.min.js')!!}
{!!Html::script('js/splitview/jquery.images-compare.js')!!}
{!!Html::script('js/functions_frontend.js')!!}
{!!Html::script('js/MathJax/MathJax.js?config=TeX-MML-AM_CHTML', array('async'))!!}


<!DOCTYPE html>
<html lang='en'>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Lernanwendung</title>

    <style>
        body {
            margin-top: 5%;
        }
    </style>
    <script>
        var url = "{!! URL::to('/') !!}";
    </script>
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            jax: ["input/TeX", "output/SVG"],
            tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]},
            TeX: { equationNumbers: { autoNumber: "AMS" } },
            CommonHTML: {
                scale: 120
             },
             "HTML-CSS": {
                scale: 150
             }
        });
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