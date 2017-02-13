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
                <th class="expand"></th>
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
                    <td class="pointer"><span data-row="media_{{ $m->media_id }}_config"
                                              class="clickable_icon fa fa-chevron-right"
                                              title="show configurations"></span></td>
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
                    @include('backend.modal_delete', ['modal_id'=>'transcode_' . $m->media_id,
                                'title'=>'File is transcoded or is in queue!',
                                'body'=>'<p>Would you like to transcode the file again?</p>',
                                'button'=>'Ok',
                                'attr' => 'class="process_transcoding btn btn-success" data-media-id="' . $m->media_id .'" data-toggle="modal" data-target="#transcode_' . $m->media_id . '"'])
                    <button type="button"
                            data-toggle="modal" data-target="#transcode_{!! $m->media_id !!}" data-media-id="{!! $m->media_id !!}"
                            data-backdrop=""
                            class="transcode_status_{!! $m->media_id !!} btn btn-info">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </button>
                    <a title="update media file {{ $m->name }}" href="/admin/media/{{ $m->media_id }}">
                        <button type="button" class="btn btn-default"><span
                                    class="glyphicon glyphicon-pencil"></span></button>
                    </a>
                    {!! Form::open(['action' => ['StorageMediaController@deleteMedia', $m->media_type, $m->origin_file],
                                        'method' => 'delete'])  !!}
                    @include('backend.modal_delete', ['modal_id'=>'delete_' . $m->media_id,
                    'title'=>'Are you sure you want to delete this media file?',
                    'body'=>'<p>Delete Media file ' . $m->name . '</p>',
                    'button'=>'Delete'])
                    <button type="button" title="delete codec {{ $m->name }}" data-toggle="modal"
                            class="btn btn-danger" data-target="#delete_{{ $m->media_id }}"><span
                                class="glyphicon glyphicon-trash"></span></button>
                    {!! Form::close() !!}
                </td>

            </tr>
                @if (count($m->getTranscodedFiles()) == 0)
                    <tr class="media_{{ $m->media_id }}_config" style="display: none">
                        <td colspan="7">
                            no codec configurations created
                        </td>
                    </tr>
                @else
                    @forelse ($m->getTranscodedFiles() as $config)
                        <tr class="codec_config media_{{ $m->media_id }}_config" style="display: none">
                            <td></td>
                            <td></td>
                            <td colspan="3">{!! $config['codec_name'] . ' - ' . $config['codec_config_name']!!}</td>
                            <td>


                            </td>

                            <td class="options">
                                @include('backend.modal_delete', ['modal_id'=>'transcode_' . $config['codec_config_id'] . '_' . $m->media_id,
                                'title'=>'File is transcoded or is in queue!',
                                'body'=>'<p>Would you like to transcode the file again?</p>',
                                'button'=>'Ok',
                                'attr' => 'class="process_transcoding btn btn-success" data-media-id="' . $m->media_id .'" data-config-id="' . $config['codec_config_id'] . '" data-toggle="modal" data-target="#transcode_' . $config['codec_config_id'] . '_' . $m->media_id . '"'])
                                @if($config['status'] == 1)
                                    <button type="button" data-config-id="{!! $config['codec_config_id'] !!}"
                                            data-toggle="modal" data-target="#transcode_{!! $config['codec_config_id'] . '_' . $m->media_id !!}" data-media-id="{!! $m->media_id !!}"
                                            data-backdrop=""
                                            class="transcode_status_{!! $config['codec_config_id'] . '_' . $m->media_id !!}  btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span>
                                    </button>
                                @elseif($config['status'] == -1)
                                    <button type="button" data-config-id="{!! $config['codec_config_id'] !!}"
                                            data-media-id="{!! $m->media_id !!}"
                                            class="process_transcoding transcode_status_{!! $config['codec_config_id'] . '_' . $m->media_id !!} btn btn-danger"><span
                                                class="glyphicon glyphicon-remove-sign"></span></button>
                                @else
                                    <button type="button" data-config-id="{!! $config['codec_config_id'] !!}"
                                            data-toggle="modal" data-target="#transcode_{!! $config['codec_config_id'] . '_' . $m->media_id !!}" data-media-id="{!! $m->media_id !!}"
                                            data-backdrop=""
                                            class="transcode_status_{!! $config['codec_config_id'] . '_' . $m->media_id !!}  btn btn-warning"><span
                                                class="glyphicon glyphicon-info-sign"></span></button>
                                @endif


                            </td>

                        </tr>
            @endforeach
            @endif




            @endforeach
        </table>
    @endif
</div>


