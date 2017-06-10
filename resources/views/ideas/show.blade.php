@extends('layouts.app')
@section('title')
    @if($idea)
        {{ $idea->title }}
        @if(!Auth::guest() && ($idea->user_id == Auth::user()->id || Auth::user()->is_admin()))
            <a class="my_font" style="float: right" href="{{ url('edit/'.$idea->slug)}}"><h4>ویرایش ایده</h4></a>
        @endif
    @else
        چنین ایده ای ثبت نشده است
    @endif
@endsection
@section('title-meta')
    <p class="my_font">publishat {{ $idea->created_at->format('M d,Y \a\t h:i a') }} by <a
                href="{{ url('/user/'.$idea->user_id)}}">{{ $idea->user_name }}</a></p>
@endsection
@section('content')
    @if($idea)
        <div>
            {!! $idea->body !!}
        </div>
    @else
        404 error
    @endif
@endsection