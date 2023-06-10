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
                            <li aria-current="page" class="breadcrumb-item active">New account / Sign in</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6">
                    <div class="box">
                        <h1>Tạo tài khoản</h1>
                        <p class="lead">Chưa có tài khoản?</p>
                        <hr>
                        @if(session()->has('mess'))
                        <p class="alert alert-primary sm-4">
                            {{session('mess')}}
                        </p>
                        @endif
                        <form action="/dangky" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Họ tên</label>
                                <input id="tennguoidung" name="tennguoidung" type="text" class="form-control" required>
                                @error('tennguoidung')
                                <div class=" alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="text" name="email" class="form-control" required>
                                @error('email')
                                <div class=" alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sdt">Số điện thoại</label>
                                <input id="sdt" type="text" name="sdt" class="form-control" required>
                                @error('sdt')
                                <div class=" alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="diachi">Địa chỉ</label>
                                <input id="diachi" name="diachi" type="text" class="form-control" required>
                                @error('diachi')
                                <div class=" alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control" required>
                                @error('password')
                                <div class=" alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box">
                        <h1>Đăng nhập</h1>
                        <p>Đã có tài khoản?</p>
                        @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                        @endif
                        <hr>
                        <form action="/dangnhap" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i>Đăng nhập</button>
                            </div>
                        </form>
                        <div class="text-center">
                        
                            <a href="/login-google"><img width="10%" alt="Đăng nhập google" src="{{asset('storage/img/google.jpg')}}"></a>
                            <a href=""><img width="10px" alt="Đăng nhập facebook" src=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop