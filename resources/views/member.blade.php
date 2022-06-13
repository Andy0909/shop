@extends('header')

@section('title','Home')

@section('content')
    @if(Session::has('name'))
        <p>會員名稱：{{Session::get('name')}}</p><br>
        <p>會員信箱：{{Session::get('email')}}</p>
    @else
        <p>您尚未登入</p>
    @endif
@stop