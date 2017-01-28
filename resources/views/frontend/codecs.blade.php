@extends('frontend.master')


@section('nav')
    @parent
    @include('frontend.header')

@stop

@section('content')


    <aside class="codecs_side">
        <h3>Video Codecs</h3>
        <div class="list-group">
            @foreach($video_codecs as $video_codec)
                <a href="/codecs/{{$video_codec->codec_id}}"
                   class="list-group-item {{ ($video_codec->codec_id==$id) ? 'active' : '' }}">
                    {{$video_codec->name}}
                </a>
            @endforeach
        </div>
        <h3>Image Codecs</h3>
        <div class="list-group">
            @foreach($image_codecs as $image_codec)
                <a href="/codecs/{{$image_codec->codec_id}}"
                   class="list-group-item {{ ($image_codec->codec_id==$id) ? 'active' : '' }}">
                    {{$image_codec->name}}
                </a>
            @endforeach
        </div>
    </aside>
    <article class="codec_documentation">
        <h2>{{$titel}}</h2>
    @if($content != null)
        {!! $content  !!}
    @else
        <!--  Hier kann irgend ein Text stehen!  -->

        @endif

    </article>


@stop