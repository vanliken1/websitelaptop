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
                            <li aria-current="page" class="breadcrumb-item active">My account</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <!--
              *** CUSTOMER MENU ***
              _________________________________________________________
              -->
                    <div class="card sidebar-menu">
                        <div class="card-header">
                            <h3 class="h4 card-title">Customer section</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column">
                                <a href="/history" class="nav-link"><i class="fa fa-list"></i> My orders</a>
                                <a href="customer-wishlist.html" class="nav-link"><i class="fa fa-heart"></i> My wishlist</a>
                                <a href="customer-account.html" class="nav-link active"><i class="fa fa-user"></i> My account</a>
                                <a href="index.html" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a>
                            </ul>
                        </div>
                    </div>
                    <!-- /.col-lg-3-->
                    <!-- *** CUSTOMER MENU END ***-->
                </div>
                <div class="col-lg-9">
                    <div class="box">
                        <h1>My account</h1>
                        <p class="lead">Change your personal details or your password here.</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                        <h3 class="mt-5">Personal details</h3>
                        @if(session()->has('mess'))
                        <p class="alert alert-success sm-4">
                            {{session('mess')}}
                        </p>
                        @endif
                        <form action="/updateuser" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" name="email" type="email" class="form-control" value="{{$nguoidung->email}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tennguoidung">Tên người dùng</label>
                                        <input id="tennguoidung" name="tennguoidung" type="text" value="{{$nguoidung->tennguoidung}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sdt">Số điện thoại</label>
                                        <input id="sdt" name="sdt" type="text" class="form-control" value="{{$nguoidung->sdt}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="diachi">Địa chỉ</label>
                                        <input id="diachi" name="diachi" type="text" class="form-control" value="{{$nguoidung->diachi}}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                
                                    <div class="form-group">
                                        <input type="checkbox" name="changePassword" id="changePassword">

                                        <label for="password">Mật khẩu mới</label>
                                        <input id="password" name="password" type="password" class="form-control password" disabled='disable' required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password2">Xác nhận mật khẩu</label>
                                        <input id="password2" name="password2" type="password" class="form-control password" disabled='disable' required>

                                    </div>
                                </div>



                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    $(document).ready(function() {
        $("#changePassword").change(function(){
            if($(this).is(":checked"))
            {
                $(".password").removeAttr('disabled');
            }else{
                $(".password").attr('disabled','');
            }
        });

    });
</script>
@stop