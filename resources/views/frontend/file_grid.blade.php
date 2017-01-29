<a href="#" class="tooltip_icon first" data-toggle="tooltip" data-placement="top"
   title="1. Bitte wähle zuerst ein Bild/Video aus!"><img width="32" alt="1" src="img/1.gif"/></a>
<div class="input-group">
    <input type="text" class="form-control open_grid" value="Bild auswählen" placeholder="Bild auswählen">
    <span class="input-group-btn">
        <button class="btn btn-default open_grid" type="button">Auswählen!</button>
    </span>
</div>

<div id="grid" style="display: none">
    @if(count($num_files)==0)
        no images founded
    @else
        <div class="row">
            @foreach($files as $file)
                @if(count($file['media_codec_configs'])>0)
                    <div class="col-xs-6 col-md-2">
                        <a class="thumbnail select_media" data-id="{!! $file->media_id !!}">
                            @if($file->media_type=='image')
                                <img src="{!! $file->getUrl('300') !!}">
                            @else
                                <video width="300" controls>
                                    <source src="{!! $file->getUrl('300') !!}">
                                </video>
                            @endif
                            <button data-name="{!! $file->name !!}" data-id="{!! $file->media_id !!}" type="button" class="btn btn-info">Auswählen</button>
                        </a>

                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>


