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
        @forelse  ($media as $m)
            <tr>
                <td class="pointer"><span data-row="media_{{ $loop->iteration }}_config"
                                          class="clickable_icon fa fa-chevron-right" title="show configurations"></span></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->orgin_file }}</td>
                <td>{{ $m->created_at }}</td>
                <td class="options">
                    {!! Form::open(['action' => ['Backend\MediaController@get_media', 0, $m->media_id],
                                    'method' => 'get'])  !!}

                    <button type="submit" class="btn btn-default"><span
                                class="glyphicon glyphicon-plus-sign"></span></button>
                    {!! Form::close() !!}

                    <a title="update media {{ $m->name }}" href="/admin/media/{{ $m->media_id }}">
                        <button type="button" class="btn btn-default"><span
                                    class="glyphicon glyphicon-pencil"></span></button>
                        {!! Form::open(['action' => ['Backend\MediaController@delete_media', $m->media_id],
                                        'method' => 'delete'])  !!}
                        @include('backend.modal_delete', ['modal_id'=>'delete_' . $m->media_id,
                        'title'=>'Are you sure you want to delete this media?',
                        'body'=>'<p>Delete media ' . $m->name . '</p>'])
                        <button type="button" title="delete media {{ $m->name }}" data-toggle="modal"
                                class="btn btn-danger" data-target="#delete_{{ $m->media_id }}"><span
                                    class="glyphicon glyphicon-trash"></span></button>
                        {!! Form::close() !!}
                </td>

            </tr>
            @endforeach
    @endif
</div>


