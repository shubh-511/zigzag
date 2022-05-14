<h1> {{$tc_data->name }}</h1>
@if($language==1)
{!! $tc_data->content_english !!}
@endif
@if($language==2)
{!! $tc_data->content_spanish !!}
@endif