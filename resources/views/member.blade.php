@extends('header')

@section('title','Home')

@section('content')
    <div style="margin-top: 50px">
        @if(Session::has('name'))
            <input type="hidden" id="user_id" value="{{Session::get('user_id')}}">
            <input type="hidden" id="userToken" value="{{Session::get('token')}}">
            @if(Session::has('subscribe'))
                @foreach(Session::get('subscribe') as $item)
                    <input type="hidden" id="subscribeItem{{$item}}" value="{{$item}}">
                @endforeach
            @endif
            <p>會員名稱：{{Session::get('name')}}</p><br>
            <p>會員信箱：{{Session::get('email')}}</p><br>
            <p>訂閱分類訊息(若您訂閱的分類有新商品上架，會立即通知您)：</p>
            <div id=ckeckbox></div>    
        @else
            <p>您尚未登入</p>
        @endif
    </div>
    <script>
        $( document ).ready(function() {
            $.ajax({
                method: "GET",
                url: "http://api.test/api/categories",
            })
            .done(function(response){
                $.each(JSON.parse(JSON.stringify(response)), function(key, value){
                    if($("#subscribeItem"+value.id).val() == ''|| $("#subscribeItem"+value.id).val() == undefined){
                        $("#ckeckbox").append(`
                            <input type="checkbox" id="${value.slug}" value="${value.id}">&nbsp;<label for="${value.slug}">${value.name}</label>&nbsp;&nbsp;&nbsp;
                        `)
                    }
                    else{
                        $("#ckeckbox").append(`
                            <input type="checkbox" id="${value.slug}" value="${value.id}" checked>&nbsp;<label for="${value.slug}">${value.name}</label>&nbsp;&nbsp;&nbsp;
                        `)
                    }
                });
                $("#ckeckbox").append(`
                    <input type="button" class="btn btn-primary" id="submit" value="確定" onclick="submit()">
                `)
            })
        });

        function submit(){
            var subscribe = new Array();
            var noSubscribe = new Array();
            $("input[type='checkbox']:checked").each(function(item){
                subscribe.push(this.value)
            })
            $("input[type='checkbox']").each(function(item){
                noSubscribe.push(this.value)
            })
            noSubscribe = $(noSubscribe).not(subscribe).toArray()
            $.ajax({
                url: "http://api.test/api/subscribe",
                headers: {
                    "Authorization": "Bearer"+" "+$("#userToken").val()
                },
                method: "POST",
                data: {
                    'user_id' : $("#user_id").val(),
                    'category_id' : subscribe
                }
            })
            .done(function(response){
                alert(JSON.parse(JSON.stringify(response)).message)
                $.ajax({
                    url: "http://api.test/api/cancel_subscribe",
                    headers: {
                        "Authorization": "Bearer"+" "+$("#userToken").val()
                    },
                    method: "POST",
                    data: {
                        'user_id' : $("#user_id").val(),
                        'category_id' : noSubscribe
                    }
                })
                $.ajax({
                    url: "/add_subscribe",
                    method: "POST",
                    data: {
                        '_token': '{{csrf_token()}}',
                        'category_id' : subscribe
                    }
                })
            })
        }
        
    </script>
@stop