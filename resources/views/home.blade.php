@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if ( !$ideas->count() )<p class="my_font">ایده ای ثبت نشده است</p>@else
        <div class="">
            @foreach( $ideas as $idea )
                {{--<div class="list-group">
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
                </div>--}}
                <div class="panel panel-default panel-google-plus">
                    <div class="dropdown">
                    <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </span>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a role="menuitem" tabindex="0" href="#">Action</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="1" href="#">Another action</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="2" href="#">Something else here</a>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="3" href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="panel-google-plus-tags">
                        <ul>
                            <li>#Millennials</li>
                            <li>#Generation</li>
                        </ul>
                    </div>
                    <div class="panel-heading">
                        {{--<img class="img-circle pull-left" src="" alt="g"/>--}}
                        <h3><a class="my_font" style="direction: rtl;"
                               href="{{ url('/'.$idea->slug) }}">{{ $idea->title }}</a></h3>
                        <p class="my_font" style="direction: rtl;">منتشر شده در تاریخ <span
                                    style="color: red">{{ $idea->date }}</span> ساعت
                            <span style="color: red">{{ $idea->time }}</span> توسط <a
                                    href="{{ url('/user/'.$idea->user_id)}}">{{ $idea->user_name }}</a></p>
                    </div>
                    <div class="panel-body my_font">
                        <article>
                            {!! str_limit($idea->body, $limit = 800, $end = '....... <a href='.url("/".$idea->slug).'>Read More</a>') !!}
                        </article>
                    </div>
                    @if (!Auth::guest())
                        <input type="text" hidden value="{{ $idea->id }}" name="idea_id" id="idea_id"/>
                        <input type="text" hidden value="{{ Auth::user()->id }}" name="user_id" id="user_id"/>
                        <input type="text" hidden value="{{ csrf_token() }}" name="_token" id="_token"/>
                        <meta name="csrf-token" content="{!! Session::token() !!}">

                        <div class="panel-footer">
                            <span class="pull-right">
                                <a onclick="like()" href="javascript:void(0);"><i id="like"
                                                                                  class="glyphicon glyphicon-thumbs-up"></i></a>
                                <a onclick="dislike()" href="javascript:void(0);"><i id="dislike"
                                                                                     class="glyphicon glyphicon-thumbs-down"></i></a>
                            </span>

                            <div id="snackbar">امتیاز ثبت شد</div>

                            <p class="my_font">
                            <span class="pull-left" style="direction: rtl">
                                <span style="color: red">{{ $idea->like }} </span>نفر این مورد را پسندیده اند
                            </span>
                            </p>

                        </div>
                    @else
                        <div class="panel-footer">
                            <p class="my_font">
                            <span class="pull-left" style="direction: rtl">
                                <span style="color: red">{{ $idea->like }} </span>نفر این مورد را پسندیده اند
                            </span>
                            </p>
                        </div>
                    @endif
                </div>
                <br>
            @endforeach
            {!! $ideas->render() !!}
        </div>
    @endif
@endsection
