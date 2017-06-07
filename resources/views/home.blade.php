@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @if (Auth::guest())
                        <div class="panel-heading" style="text-align: center">Hello :)</div>
                    @else
                        <div class="panel-heading" style="text-align: center">Welcome !</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
