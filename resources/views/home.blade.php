@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if ( !$ideas->count() )<p class="my_font">ایده ای ثبت نشده است</p>@else
        <div class="">
            @foreach( $ideas as $idea )
                <div class="list-group">
                    <div class="list-group-item">
                        <h3><a class="my_font" style="direction: rtl;"
                               href="{{ url('/'.$idea->slug) }}">{{ $idea->title }}</a></h3>
                        <p class="my_font" style="direction: rtl;">منتشر شده در تاریخ <span
                                    style="color: firebrick">{{ $idea->date }}</span> ساعت
                            <span style="color: firebrick">{{ $idea->time }}</span> توسط <a
                                    href="{{ url('/user/'.$idea->user_id)}}">{{ $idea->user_name }}</a></p>
                    </div>
                    <div class="list-group-item my_font" style="direction: rtl;">
                        <article>
                            {!! str_limit($idea->body, $limit = 800, $end = '....... <a href='.url("/".$idea->slug).'>Read More</a>') !!}
                        </article>
                    </div>
                </div>
            @endforeach
            {!! $ideas->render() !!}
        </div>
    @endif
@endsection
