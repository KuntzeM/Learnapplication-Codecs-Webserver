<div class="page-header">
    <h1>Überschrift
        <small>für Frontend</small>
    </h1>
</div>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Route::currentRouteNamed('home') ? 'active' : '' }}"><a href="/">Willkommen</a></li>
                <li class="{{ Route::currentRouteNamed('image') ? 'active' : '' }}"><a href="/image">Image</a></li>
                <li class="{{ Route::currentRouteNamed('video') ? 'active' : '' }}"><a href="/video">Video</a></li>
                <li class="{{ Route::currentRouteNamed('about') ? 'active' : '' }}"><a href="/about">Impressum</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
