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
                            <li aria-current="page" class="breadcrumb-item active">Thank you !</li>
                        </ol>
                    </nav>
                    <div id="error-page" class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="box text-center py-5">
                                <p class="text-center"><img src="{{asset('storage/img/success.png')}}" width="40%" alt="Obaju template"></p>
                                <h3>Cảm ơn bạn đã đặt hàng</h3>
                                <p class="text-center">Bạn có thể xem <strong>Lịch sử đơn hàng</strong> hoặc <strong>Quay về trang chủ</strong></p>
                                <p class="buttons"><a href="/" class="btn btn-primary"><i class="fa fa-home"></i> Trang chủ</a>
                                <a href="/history" class="btn btn-info"><i class="fa fa-home"></i> Lịch sử đơn hàng</a>
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop