@extends('clients/layouts/master')
@section('content')
<div id="all">
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- breadcrumb-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li aria-current="page" class="breadcrumb-item active">Page not found</li>
                        </ol>
                    </nav>
                    <div  class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="box text-center py-5">

                                <h1>Mật khẩu mới</h1>
                                @if(session()->has('thongbao'))
                                <div class="alert alert-success">
                                    {{ session()->get('thongbao') }}
                                </div>
                                @endif
                              
                                @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                                @endif

                                <hr>
                                @php
                                $token=$_GET['token'];
                                $email=$_GET['email'];
                                @endphp
                                <form action="/updatenewpass" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="put">
                                    <input type="hidden" name="email_account" value="{{$email}}">
                                    <input type="hidden" name="token" value="{{$token}}">

                                    <div class="form-group">
                                        <label class="float-left">Mật khẩu mới</label>
                                        <input type="password" name='new_password' id="new_password" class='form-control' placeholder="Nhập mật khẩu mới" required>


                                    </div>
                                    <div class="form-group">
                                        <label class="float-left">Xác nhận mật khẩu</label>
                                        <input type="password" name='new_password_confirm' id="new_password_confirm" class='form-control' placeholder="Xác nhận mật khẩu" required>


                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary float-right">Gửi</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop