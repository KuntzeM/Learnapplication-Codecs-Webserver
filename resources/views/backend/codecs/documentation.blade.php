@extends('backend.master')

@section('nav')
    @parent
    @include('backend.header')

@stop


@section('content')
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist codesample autolink lists link image charmap print preview hr anchor autolink',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons paste textcolor colorpicker textpattern imagetools codesample autosave, template, toc, placeholder'
            ],
            toolbar1: 'placeholder preview | undo redo |  styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | table bullist numlist outdent indent | link image media codesample emoticons | toc',
            toolbar2: '',
            autosave_interval: "30s",
            image_advtab: false,
            templates: [
                {title: 'Vergleichsseite', url: '{!! asset('templates/compare_template.html') !!}'}
             ],
            table_class_list: [
                {title: 'None', value: ''},
                {title: 'no Border', value: 'noborder'}
            ],
            placeholder_tokens: [
                { token: "image_codecs", title: "verwendete Bildkodierungsverfahren einfügen"},
                { token: "video_codecs", title: "verwendete Videokodierungsverfahren einfügen"}
            ],
            content_css: [
                '{{ asset('css/editor_tinymce.css') }}',
            ],
            file_browser_callback: function (field_name, url, type, win) {

                // from http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
                var w = window,
                    d = document,
                    e = d.documentElement,
                    g = d.getElementsByTagName('body')[0],
                    x = w.innerWidth || e.clientWidth || g.clientWidth,
                    y = w.innerHeight || e.clientHeight || g.clientHeight;

                //var cmsURL = '{{URL::to('filemanager') }}?&field_name=' + field_name + '&langCode=en&token=faherstlwizto8ew5h4p5z8thgfoewz4o5z7thfpoet8zwg65745-sadtr43_w44wtrt';
                var cmsURL = '{!! url('filemanager/index.html') !!}?&field_name=' + field_name + '&langCode=en&token=faherstlwizto8ew5h4p5z8thgfoewz4o5z7thfpoet8zwg65745-sadtr43_w44wtrt';

                if (type == 'image') {
                    cmsURL = cmsURL + "&type=images";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });

            }
        });
    </script>


    @if($codec != Null)
        <h3 class="item_details">Dokumentation {{ ($type == 'compare')? 'Vergleich' : 'Übersicht' }}
            : {!! $codec->name !!} </h3>
        {!! Form::open(['action' => ['Backend\CodecsController@update_documentation', $codec->codec_id], 'method' => 'post'])  !!}
        <input type="hidden" value="{{$type}}" name="type"/>
    @else
        <h3 class="item_details">{{ ($site == 'impressum')? 'Impressum-Seite' : 'Startseite' }} </h3>
        {!! Form::open(['action' => ['Backend\ConfigurationsController@update_site', $site], 'method' => 'post'])  !!}
        <input type="hidden" value="{{$site}}" name="site"/>
    @endif

    <div class="form-group">
        <div>
            <textarea name="documentation"
                      class="form-control {!! ((count($errors->get('documentation'))) ?  'alert-danger' : '')  !!}">{{((empty($documentation)) ? Input::old('documentation') : $documentation)}}</textarea>
        </div>
        @if(count($errors->get('documentation')))
            <div class="permanent alert alert-danger">
                @foreach($errors->get('documentation') as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif
    </div>
    @if($codec != Null)
        <a class="item_details" title="back without save" href="/admin/codecs">
            @else
                <a class="item_details" title="back without save" href="/admin/configurations">
                    @endif
        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list"></span> Back without Save
        </button>
    </a>


                <button type="submit" data-toggle="modal" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Save
    </button>

    {!! Form::close() !!}
@stop