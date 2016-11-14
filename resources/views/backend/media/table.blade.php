<div class="panel panel-default">
   <div class="panel-heading"><h4>{{ $name }} Media</h4>
        <a title="add new codec" href="/admin/media/upload">
            <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Add new
                Media
            </button>
        </a>
    </div>

    @if (count($media) == 0)
        <div class="panel-body">
            no media uploaded
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th class="number">#</th>
                <th>thumbnail</th>
                <th class="name">name</th>
                <th class="date">last change</th>
                <th class="date">origin file path on media server</th>
                <th class="options">options</th>
            </tr>
            </thead>
            <tbody>


            @forelse ($media as $m)

                <tr>
                <td>{{ $loop->iteration }}</td>
                    <td class="thumbnail">
                        @if ($name == "Image")
                            <img width="300" src="{!! $m->getUrl('300') !!}">

                        @else
                            <video width="300" controls>
                                <source src="{!! $m->getUrl('300') !!}">
                            </video>
                        @endif
                    </td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->created_at }}</td>
                    <td><input type="text" readonly value="{{ $m->origin_file }}"/></td>
                <td class="options">

                </td>

            </tr>
            @endforeach
        </table>
    @endif
</div>


