@extends('header')

@section('title','Contact Us')

@section('content')
<br>
<form>
    <p style="text-align:center;font-size:30px">Contact us</p>
    <div class="form-group">
        <label for="exampleInputEmail1">Title</label>
        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter title" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Content</label>
        <textarea rows="4" cols="50" class="form-control" id="content" aria-describedby="emailHelp" placeholder="Enter content" required></textarea>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Phone</label>
        <input type="email" class="form-control" id="phone" aria-describedby="emailHelp" placeholder="Enter phone" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your phone with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Email</label>
      <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <button type="button" id="submit" class="btn btn-primary">Submit</button>
</form>
<script>
    $("#submit").click(function(){
        $.ajax({
            method: "POST",
            url: "http://api.test/api/posts",
            data: {
                'title' : $("#title").val(),
                'content' : $("#content").val(),
                'name' : $("#name").val(),
                'phone' : $("#phone").val(),
                'email' : $("#email").val(),
            }
        })
        .done(function(response){
            if(JSON.parse(JSON.stringify(response)).message === "ok"){
                alert("已收到您的來信")
                window.location.href = "/";
            }
            else{
                alert("表單送出錯誤")
            }
        })
    })
</script>
@stop