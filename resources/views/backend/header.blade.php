<script>
    checkMediaServerStatus('.alert_box');
    setInterval("checkMediaServerStatus('.alert_box')", 2000);

</script>
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
                <li class="{{ Route::is('admin') ? 'active' : '' }}"><a href="/admin">Transcoding Overview</a></li>
                <li class="{{ Route::is('configurations') ? 'active' : '' }}"><a href="/admin/configurations">Configurations</a>
                </li>
                <li class="{{ (Route::is('codecs') || Route::is('codec')) ? 'active' : '' }}"><a href="/admin/codecs">Codecs</a>
                </li>
                <li class="{{ Route::is('media') ? 'active' : '' }}"><a href="/admin/media">MediaFiles</a></li>
                <li class="{{ Route::is('log') ? 'active' : '' }}"><a href="/admin/log">Log</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><span id="server_status" class="label label-danger">Server Status</span></li>
                <li><span id="coding_status" class="label label-default">Coding Status</span></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2" >
            <div id="messages" ></div>
        </div>
    </div>
</div>


