@extends('layouts.app')
@section('title')
    @if($idea)
        <div class="my_font" style="direction: rtl;">
            {{ $idea->title }}
        </div>
    @else
        چنین ایده ای ثبت نشده است
    @endif
@endsection
@section('title-meta')
    <p class="my_font" style="direction: rtl;">منتشر شده در تاریخ <span
                style="color: firebrick">{{ $idea->date }}</span> ساعت
        <span style="color: firebrick">{{ $idea->time }}</span> توسط <a
                href="{{ url('/user/'.$idea->user_id)}}">{{ $idea->user_name }}</a></p>
    @if(!Auth::guest() && ($idea->user_id == Auth::user()->id || Auth::user()->is_admin()))
        <a class="my_font" href="{{ url('edit/'.$idea->slug)}}"><h5>ویرایش ایده</h5></a>
    @endif
@endsection
@section('content')
    @if($idea)
        <div class="my_font" style="direction: rtl;">
            {!! $idea->body !!}
        </div>
    @else
        404 error
    @endif
@endsection