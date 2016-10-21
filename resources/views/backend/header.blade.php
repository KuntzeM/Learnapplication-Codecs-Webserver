<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Route::is('admin') ? 'active' : '' }}"><a href="/admin">Dashboard</a></li>
                <li class="{{ Route::is('configurations') ? 'active' : '' }}"><a href="/admin/configurations">Configurations</a>
                </li>
                <li class="{{ (Route::is('codecs') || Route::is('codec')) ? 'active' : '' }}"><a href="/admin/codecs">Codecs</a>
                </li>
                <li class="{{ Route::is('media') ? 'active' : '' }}"><a href="/admin/media">Media
                        Files</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2" >
            <div id="messages" ></div>
        </div>
    </div>
</div>
<script>
    var socket = io.connect('192.168.178.100:5000', {origin: '192.168.178.100:5000'});
    socket.on('connect', function() {
        log('connect');
    });
    socket.on('message', function(data) {
        log('message: ' + data);
    });
    socket.on('disconnect', function() {
        log('disconnect');
    });
    socket.connect();
/*
    socket.on('message', function (data) {
        $( "#messages" ).append( "<p>"+data+"</p>" );
    });*/
</script>
