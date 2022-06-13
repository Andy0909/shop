@extends('header')

@section('title','Home')

@section('content')
<div id="product-table" style="margin-top: 50px">
    <table class="table">
        <thead id="head"></thead>
        <tbody id="body">
            <tr id="tr1">
                <th scope="row">name</th>
            </tr>
            <tr id="tr2">
                <th scope="row">price</th>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $( document ).ready(function() {
        $.ajax({
            method: "GET",
            url: "http://api.test/api/products",
        })
        .done(function(response){
            $("#head").append(`<th scope="col">#</th>`)
            $.each(JSON.parse(JSON.stringify(response)), function(key, value){
                $("#head").append(`<th scope="col">${key+1}</th>`)
                $("#tr1").append(`<td>${value.name}</td>`)
                $("#tr2").append(`<td>${value.price}</td>`)
            });
        })
    });
</script>
@stop