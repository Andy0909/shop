@extends('header')

@section('title','Home')

@section('content')
    <div style="margin-top: 50px">
        @if(Session::has('user_id'))
            <input type="hidden" id="userId" value={{Session::get('user_id')}}>
            <input type="hidden" id="userToken" value={{Session::get('token')}}>
        @endif
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
                    <p>選擇數量：<input type="number" id="orderQuantity{{$key}}" min="1" max="10" value="1"></p>
                    <center><button type="button" class="btn btn-danger" onclick="cancelOrder({{$key}})">取消</button></center>
                </li>
            </ul>
            @endforeach
            <center><button type="button" class="btn btn-primary" style="margin-top: 60px" onclick="checkout({{$key}})">結帳</button></center>
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
                window.location.reload();
            })
            $("#"+key).remove();
        }

        function checkout(key) {
            var totalPrice = 0;
            var cart =  new Array();
            var order = new Array();
            for(itemKey = 0; itemKey <= key; itemKey++){
                if($("#orderPrice"+itemKey).val()!= '' && $("#orderPrice"+itemKey).val()!= undefined){
                    cart[itemKey] = {user_id:$("#userId").val(), product_id:$("#orderId"+itemKey).val(), quantity:$("#orderQuantity"+itemKey).val()};
                    totalPrice = totalPrice + $("#orderPrice"+itemKey).val() * $("#orderQuantity"+itemKey).val()
                }
            }
            order = { user_id: $("#userId").val(), price: totalPrice, status: 0}
            $.ajax({
                url: "http://api.test/api/orderCreate",
                headers: {
                    "Authorization": "Bearer"+" "+$("#userToken").val()
                },
                method: "POST",
                data: {
                    'user_id': $("#user_id").val(),
                    'price': totalPrice,
                    'status' : 0
                }
            })
            .done(function(response){
                if(JSON.parse(JSON.stringify(response)).code != undefined && JSON.parse(JSON.stringify(response)).code == '201'){
                    for(itemKey = 0; itemKey <= key; itemKey++){
                        if($("#orderPrice"+itemKey).val()!= '' && $("#orderPrice"+itemKey).val()!= undefined){
                            cart[itemKey].order_id = (JSON.parse(JSON.stringify(response)).order_id)
                        }
                    }
                    $.ajax({
                        url: "http://api.test/api/CartCreate",
                        headers: {
                            "Authorization": "Bearer"+" "+$("#userToken").val()
                        },
                        method: "POST",
                        data: {
                            'cart': cart,
                        }
                    })
                    .done(function(response){
                        if(JSON.parse(JSON.stringify(response)).code == '200'){
                            $.ajax({
                                url: "/remove_orders",
                                method: "GET",
                                data: {
                                    '_token': '{{csrf_token()}}',
                                }
                            })
                            alert(JSON.parse(JSON.stringify(response)).message);
                            window.location.reload();
                        }
                        else{
                            alert(JSON.parse(JSON.stringify(response)).message);
                        }
                    })
                }
                else{
                    alert(JSON.parse(JSON.stringify(response)).message);
                }
            })
        }
    </script>
@stop