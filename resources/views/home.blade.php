@extends('header')

@section('title','Home')

@section('content')
    @if(isset($userName))
        <p>{{$userName}}</p>
    @else
        <p>尚未登入</p>
    @endif
@stop