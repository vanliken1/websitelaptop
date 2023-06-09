@extends('clients/layouts/master')
@section('content')
<div id="all">
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li aria-current="page" class="breadcrumb-item active">My orders</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-3">

                    _________________________________________________________

                    <div class="card sidebar-menu">
                        <div class="card-header">
                            <h3 class="h4 card-title">Thông tin khách hàng</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column">
                                <a href="/history" class="nav-link active"><i class="fa fa-list"></i> My orders</a>
                                <a href="customer-wishlist.html" class="nav-link"><i class="fa fa-heart"></i> My wishlist</a>
                                <a href="/info" class="nav-link"><i class="fa fa-user"></i> My account</a>
                                <a href="index.html" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a>
                            </ul>
                        </div>
                    </div>

                </div>
                <div id="customer-orders" class="col-lg-9">
                    <div class="box">
                        <h1>Chi tiết đơn hàng</h1>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th scope="col">Tên khách hàng</th>
                                        <th>SĐT</th>
                                        <th>Email</th>
                                        <th>Địa chỉ</th>
                                    </tr>
                                </thead>
                                @foreach($donhang as $item)
                                <tbody>
                                    <tr>
                                        <td>{{$item->users->tennguoidung}}</td>
                                        <td>{{$item->users->sdt}}</td>
                                        <td>{{$item->users->email}}</td>
                                        <td>{{$item->users->diachi}}</td>


                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                        <h1>Thông tin đơn hàng</h1>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th scope="col">Mã đơn hàng</th>
                                        <th>Tên người nhận</th>
                                        <th>SĐT người nhận</th>
                                        <th>Địa chỉ người nhận</th>
                                        <th>Hình thức thanh toán</th>
                                        <th>Ngày đặt</th>
                                        <th>Ghi chú</th>

                                    </tr>
                                </thead>
                                @foreach($donhang as $item)
                                <tbody>
                                    <tr>
                                        <td>{{$item->iddonhang}}</td>
                                        <td>{{$item->tennguoinhan}}</td>
                                        <td>{{$item->sdtnguoinhan}}</td>
                                        <td>{{$item->diachinguoinhan}}</td>
                                        <td>
                                            @if($item->hinhthuc==0)
                                            {{'Thanh toán tiền mặt'}}
                                            @else
                                            {{'Thanh toán ví điện tử'}}
                                            @endif
                                        </td>
                                        <td>{{$item->ngaydat}}</td>
                                        <td>{{$item->note}}</td>


                                    </tr>
                                </tbody>
                                @endforeach

                            </table>

                            <h1>Chi tiết đơn hàng</h1>

                            <hr>
                            <div class="table-responsive">
                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th scope="col">Mã sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá gốc</th>
                                            <th>Giá bán</th>
                                            <th>Mã coupon</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>


                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $tong = 0; ?>
                                        @foreach($chitietdonhang as $item)
                                        <?php $tong += $item->soluong * $item->gia; ?>
                                        <tr>
                                            <td>{{$item->products->idsanpham}}</td>
                                            <td>{{$item->products->tensanpham}}</td>
                                            <td>{{number_format($item->products->gia,0,',','.')}}</td>
                                            <td>{{number_format($item->gia,0,',','.')}}</td>

                                            <td>
                                                @if($item->codegiamgia != 'no')
                                                {{$item->codegiamgia}}
                                                @else
                                                Không mã
                                                @endif
                                            </td>
                                            <td>
                                                <!-- //soluong khach hang dat -->
                                                {{number_format($item->soluong,0, ',', '.')}}
                                                <!-- <input type="text" readonly  value="{{number_format($item->soluong,0, ',', '.')}}" class="order_qty_{{$item->products->idsanpham}}" name="soluonghang"> -->

                                                <!-- //so luong kho -->


                                            </td>
                                            <td>{{number_format($item->soluong * $item->gia, 0, ',', '.')}}</td>


                                        </tr>

                                        @endforeach
                                </table>
                                <div>
                                    Tổng thành tiền:{{number_format($tong,0,',','.')}} đ <br />
                                    @php $tong_coupon=0 @endphp
                                    @if($tinhnangma==0)
                                    @php
                                    $tongsaugiam = ($tong * $sotiengiam) / 100;
                                    echo 'Giảm giá:'.number_format($tongsaugiam,0,',','.') , 'đ' .'<br />';
                                    $tong_coupon=$tong-$tongsaugiam;
                                    @endphp
                                    @else
                                    @php
                                    echo 'Giảm giá:'.number_format($sotiengiam,0,',','.') , 'k' .'<br />';
                                    $tong_coupon = $tong - $sotiengiam ;
                                    @endphp
                                    @endif
                                    Thanh toán:{{number_format($tong_coupon,0,',','.')}} đ
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @stop