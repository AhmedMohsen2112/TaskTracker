@foreach (config('settings.languages') as $value)
<div class="col-md-12">
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">{{ $value['title'] }}</legend>
        @foreach($inputs as $one)
         @if($one=='title'||$one=='meta_title')
        <div class="col-md-12">
            <div class="form-group form-md-line-input">
                <input type="text" class="form-control" id="{{ $one.'.'.$value['locale'] }}" name="trans[{{ $value['locale'] }}][{{$one}}]" value="">
                <label for="{{ $one.'.'.$value['locale'] }}">{{ $one }}</label>
                <span class="help-block"></span>
            </div>
        </div>
        @endif
         @if($one=='description'||$one=='meta_description')
        <div class="col-md-12">
            <div class="form-group form-md-line-input">
                <textarea rows="4" style="resize: none;" class="form-control" id="{{ $one.'.'.$value['locale'] }}" name="trans[{{ $value['locale'] }}][{{$one}}]"></textarea>
                <label for="{{ $one.'.'.$value['locale'] }}">{{ $one }}</label>
                <span class="help-block"></span>
            </div>
        </div>
        @endif
        @endforeach
       
      
    </fieldset>
</div>
@endforeach

