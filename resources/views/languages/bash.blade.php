curl -X {{$route['methods'][0]}} {{$route['methods'][0] == 'GET' ? '-G ' : ''}}"{{ trim(config('app.docs_url') ?: config('app.url'), '/')}}/{{ ltrim($route['uri'], '/') }}" @if(count($route['headers']))\
@foreach($route['headers'] as $header => $value)
    -H "{{$header}}: {{$value}}"@if(! ($loop->last) || ($loop->last && count($route['bodyParameters']))) \
@endif
@endforeach
@endif

@foreach($route['bodyParameters'] as $attribute => $parameter)
    @if(gettype($parameter['value']) === "boolean")\
    -d "{{ $attribute}}={!! "false" !!}"
    @elseif (in_array(gettype($parameter['value']), ["array", "object"])\
    -d "{{ $attribute}}={!! json_encode($parameter['value']) !!}"
    @else\
    -d "{{$attribute}}"="{!!$parameter['value'] === false ? "false" : $parameter['value']!!}" @if(! ($loop->last))\
    @endif
    @endif
@endforeach
@endforeach
