@extends('header')

@section('title','Home')

@section('content')
<input type="hidden" id="username" value="{{Session::get('name')}}">
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
            <tr id="tr3">
                <th scope="row">picture</th>
            </tr>
            <tr id="tr4">
                <th scope="row"></th>
            </tr>
        </tbody>
    </table><br>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center" id="page">
        </ul>
      </nav>
</div>
<script>
    $( document ).ready(function() {
        $.ajax({
            method: "GET",
            url: "http://api.test/api/products?page=1",
        })
        .done(function(response){
            $("#head").append(`<th scope="col">#</th>`)
            $.each(JSON.parse(JSON.stringify(response)), function(key, value){
                if(key == "last_page"){
                    for(page=1;page<=value;page++){
                        $("#page").append(`<li class="page-item"><a class="page-link" onclick="get_product_data(${page})">${page}</a></li>`)
                    }
                }
                if(key == "data"){
                    $.each(JSON.parse(JSON.stringify(value)), function(key, value){
                        $("#head").append(`<th scope="col"><center>${value.id}</center></th>`)
                        $("#tr1").append(`<td><center>${value.name}</center></td>`)
                        $("#tr2").append(`<td><center>${value.price}</center></td>`)
                        $("#tr3").append(`<td><center><img src="{{asset('img/${value.img}')}}"></center></td>`)
                        $("#tr4").append(`<td><center><input type="button" onclick="add_order('${value.id}','${value.name}','${value.price}')" value="購買"/></center></td>`)
                    })
                }
            });
        })
    });

    function get_product_data(page) {
        $.ajax({
            method: "GET",
            url: "http://api.test/api/products?page="+page,
        })
        .done(function(response){
            $("#head").empty()
            $("#tr1").empty()
            $("#tr2").empty()
            $("#tr3").empty()
            $("#tr4").empty()
            $("#tr1").append(`<th scope="row">name</th>`)
            $("#tr2").append(`<th scope="row">price</th>`)
            $("#tr3").append(`<th scope="row">picture</th>`)
            $("#tr4").append(`<th scope="row"></th>`)
            $("#head").append(`<th scope="col">#</th>`)
            $.each(JSON.parse(JSON.stringify(response)), function(key, value){
                if(key == "data"){
                    $.each(JSON.parse(JSON.stringify(value)), function(key, value){
                        $("#head").append(`<th scope="col"><center>${value.id}</center></th>`)
                        $("#tr1").append(`<td><center>${value.name}</center></td>`)
                        $("#tr2").append(`<td><center>${value.price}</center></td>`)
                        $("#tr3").append(`<td><center><img src="{{asset('img/${value.img}')}}"></center></td>`)
                        $("#tr4").append(`<td><center><input type="button" onclick="add_order('${value.id}','${value.name}','${value.price}')" value="購買"/></center></td>`)
                    })
                }
            });
        })
    }

    function add_order(id,name,price) {
        if($("#username").val() == '' || $("#username").val() == undefined){
            alert('請先登入再購買商品');
        }
        else{
            $.ajax({
                method: "POST",
                url: '/add_orders',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': id,
                    'name': name,
                    'price': price
                }
            })
            .done(function(){
                alert("已加入至訂單");
            })
        }
    }
</script>
@stop