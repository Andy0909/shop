@extends('header')

@section('title','Home')

@section('content')
    <div style="margin-top: 50px">
        @if(Session::has('orders') && count(Session::get('orders'))>0)
            <p>您欲訂購的商品：</p><br>
            @foreach(Session::get('orders') as $key => $order)
            <ul class="list-group" id={{$key}}>
                <li class="list-group-item">
                    <input type="hidden" id="orderId{{$key}}" value={{$order['id']}}>
                    <input type="hidden" id="orderName{{$key}}" value={{$order['name']}}>
                    <input type="hidden" id="orderPrice{{$key}}" value={{$order['price']}}>
                    <p>商品編號：{{$order['id']}}</p><br>
                    <p>商品名稱：{{$order['name']}}</p><br>
                    <p>商品價格：{{$order['price']}}</p><br>
                    <center><button type="button" class="btn btn-danger" onclick="cancelOrder({{$key}})">取消</button></center>
                </li>
            </ul>
            @endforeach
            <center><button type="button" class="btn btn-primary" style="margin-top: 60px" onclick="checkout()">結帳</button></center>
        @else
            <p>您尚未購買東西</p>
        @endif
    </div>
    <script>
        function cancelOrder(key) {
            $.ajax({
                method: "POST",
                url: "/delete_orders",
                data: {
                    '_token': '{{csrf_token()}}',
                    'key': key,
                }
            })
            .done(function(){
                alert("已刪除此項目");
            })
            $("#"+key).empty();
        }

        function checkout() {
            alert('checkout')
            /*if($("#username").val() == '' || $("#username").val() == undefined){
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
            }*/
        }
    </script>
@stop