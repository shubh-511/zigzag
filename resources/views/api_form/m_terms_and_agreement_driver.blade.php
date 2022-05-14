@if($language==1)
<h1> {{$tc_data->name }}</h1>
@endif
@if($language==2)
<h1> {{$tc_data->spanish_name }}</h1>
@endif
@if($language==1)
{!! $tc_data->content_english !!}
@endif
@if($language==2)
{!! $tc_data->content_spanish !!}
@endif
