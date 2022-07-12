@extends('header')

@section('title','computer')

@section('content')
<div style="margin-top: 50px">
    <input type="hidden" id="username" value="{{Session::get('name')}}">
    <input type="hidden" id="category_slug" value="{{$category_slug}}">
    分類：{{$category_slug}}
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
                    <th scope="row">content</th>
                </tr>
                <tr id="tr5">
                    <th scope="row"></th>
                </tr>
            </tbody>
        </table><br>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center" id="page">
            </ul>
          </nav>
    </div>
</div>

<script>
    var category_slug = $("#category_slug").val();
    $.ajax({
        url: "http://api.test/api/categoryProduct/"+category_slug,
        method: "GET",
    })
    .done(function(response){
        $("#head").append(`<th scope="col">#</th>`)
        $.each(JSON.parse(JSON.stringify(response)), function(key, value){
            $.each(value, function(key, value){
                if(key == "product"){
                    $.each(JSON.parse(JSON.stringify(value)), function(key, value){
                        $("#head").append(`<th scope="col"><center>${value.id}</center></th>`)
                        $("#tr1").append(`<td><center>${value.name}</center></td>`)
                        $("#tr2").append(`<td><center>${value.price}</center></td>`)
                        $("#tr3").append(`<td><center><img src="{{asset('img/${value.img}')}}"></center></td>`)
                        $("#tr4").append(`<td><center>${value.content}</center></td>`)
                        $("#tr5").append(`<td><center><input type="button" onclick="add_order('${value.id}','${value.name}','${value.price}')" value="購買"/></center></td>`)
                    })
                }
            });
        });
    })

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
