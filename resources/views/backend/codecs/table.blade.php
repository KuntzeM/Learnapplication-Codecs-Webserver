<div class="panel panel-default">
    <div class="panel-heading"><h4>{{ $name }} Codecs</h4>
        <a title="add new codec" href="/admin/codec">
            <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Add new
                Codec
            </button>
        </a>
    </div>
    @if (count($codecs) == 0)
        <div class="panel-body">
            no codecs created
        </div>
    @else
        <table class="table">
            <thead>
            <tr>
                <th class="expand"></th>
                <th class="number">#</th>
                <th class="name">name</th>
                <th>ffmpeg</th>
                <th class="date">last change</th>
                <th class="options">options</th>
            </tr>
            </thead>
            <tbody>
            @forelse  ($codecs as $codec)
                <tr>
                    <td class="pointer"><span data-row="codec_{{ $codec->codec_id }}_config"
                                              class="clickable_icon fa fa-chevron-right" title="show configurations"></span></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $codec->name }}</td>
                    <td>{{ $codec->ffmpeg_codec }}</td>
                    <td>{{ $codec->created_at }}</td>
                    <td class="options">
                        {!! Form::open(['action' => ['Backend\CodecsController@get_codec_config', 0, $codec->codec_id],
                                        'method' => 'get'])  !!}

                        <button type="submit" class="btn btn-default"><span
                                    class="glyphicon glyphicon-plus-sign"></span></button>
                        {!! Form::close() !!}

                        <a title="update codec {{ $codec->name }}" href="/admin/codec/{{ $codec->codec_id }}">
                            <button type="button" class="btn btn-default"><span
                                        class="glyphicon glyphicon-pencil"></span></button>
                        </a>
                        <a title="edit documentation" href="/admin/codec/documentation/{{ $codec->codec_id }}">
                            <button type="button" class="btn btn-default"><span
                                        class="glyphicon glyphicon-comment"></span></button>
                        </a>
                        {!! Form::open(['action' => ['Backend\CodecsController@delete_codec', $codec->codec_id],
                                        'method' => 'delete'])  !!}
                        @include('backend.modal_delete', ['modal_id'=>'delete_' . $codec->codec_id,
                        'title'=>'Are you sure you want to delete this codec?',
                        'body'=>'<p>Delete Codec ' . $codec->name . '</p><p>Delete '. count($codec->codec_configs) .' Configurations</p>',
                        'button'=>'Delete'])
                        <button type="button" title="delete codec {{ $codec->name }}" data-toggle="modal"
                                class="btn btn-danger" data-target="#delete_{{ $codec->codec_id }}"><span
                                    class="glyphicon glyphicon-trash"></span></button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @if (count($codec->codec_configs) == 0)
                    <tr class="codec_{{ $codec->codec_id }}_config" style="display: none">
                        <td colspan="6">
                            no codec configurations created
                        </td>
                    </tr>
                @else
                    @forelse ($codec->codec_configs as $config)
                        <tr class="codec_config codec_{{ $codec->codec_id }}_config" style="display: none">
                            <td></td>
                            <td></td>
                            <td>{{ $config->name }}</td>
                            <td>{{ $config->ffmpeg_parameters }}</td>
                            <td></td>
                            <td class="options">
                                <!--<a title="activate configuration" href="#">
                                    @if($config->active)
                                        <button type="button" data-id="{!! $config->codec_config_id !!}"
                                                class="activate_config btn btn-success"><span
                                                    class="glyphicon glyphicon-ok-circle"></span></button>
                                    @else
                                        <button type="button" data-id="{!! $config->codec_config_id !!}"
                                                class="activate_config btn btn-danger"><span
                                                    class="glyphicon glyphicon-remove-circle"></span></button>
                                    @endif
                                </a>-->
                                <a title="update configuration {{ $config->name }}"
                                   href="/admin/codec_config/{{ $config->codec_config_id }}">
                                    <button type="button" class="btn btn-default"><span
                                                class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                </a>
                                <span style="width: 45px; float:left;">
                                    &nbsp;
                                </span>
                                {!! Form::open(['action' => ['Backend\CodecsController@delete_codec_config', $config->codec_config_id],
                                        'method' => 'delete'])  !!}
                                @include('backend.modal_delete', ['modal_id'=>'delete_config_' . $config->codec_config_id,
                                'title'=>'Are you sure you want to delete this codec configuration?',
                                'body'=>'<p>Delete Codec Configuration ' . $config->name . '</p>',
                                 'button'=>'Delete'])
                                <button type="button" data-toggle="modal" class="btn btn-danger"
                                        data-target="#delete_config_{{ $config->codec_config_id }}"><span
                                            class="glyphicon glyphicon-trash"></span></button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
            </tbody>
        </table>
    @endif
</div>


