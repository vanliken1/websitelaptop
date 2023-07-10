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
                            <li aria-current="page" class="breadcrumb-item active">Quên mật khẩu</li>
                        </ol>
                    </nav>
                    <div  class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="box text-center py-5">

                                <h1>Quên mật khẩu</h1>
                                <h3>Vui lòng nhập email để khôi phục</h3>
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
                                <form action="/khoiphucmatkhau" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="float-left">Email</label>
                                        <input type="email" name='email_account' id="email_account" class='form-control' placeholder="Nhập email" required>


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