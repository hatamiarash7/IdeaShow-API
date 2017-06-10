@extends('layouts.app')

@section('content')
    @if(isset($user))
        <h2 class="my_font" style="color: #0f0f0f">{{ $user->name }}</h2>
    @endif
@endsection

@section('list')
    @if(isset($ideas))
        @if ( !$ideas->count() )ایده ای وجود ندارد@else
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    @foreach( $ideas as $idea )
                        <div class="list-group">
                            <div class="list-group-item">
                                <h3><a class="my_font" href="{{ url('/'.$idea->slug) }}">{{ $idea->title }}</a></h3>
                                <p class="my_font" style="direction: rtl;">منتشر شده در تاریخ <span
                                            style="color: firebrick">{{ $idea->date }}</span> ساعت
                                    <span style="color: firebrick">{{ $idea->time }}</span> توسط <a
                                            href="{{ url('/user/'.$idea->user_id)}}">{{ $idea->user_name }}</a></p>
                            </div>
                            <div class="list-group-item my_font" style="direction: rtl;">
                                <article>
                                    {!! str_limit($idea->body, $limit = 800, $end = '....... <a href='.url("/".$idea->slug).'>ادامه مطلب</a>') !!}
                                </article>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
@endsection