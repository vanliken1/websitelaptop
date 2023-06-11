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
                            <li aria-current="page" class="breadcrumb-item active">Checkout - Address</li>
                        </ol>
                    </nav>
                </div>
                <div id="checkout" class="col-lg-9">

                    <div class="box">
                        @if(session()->has('error'))
                        <p class="alert alert-danger sm-4">
                            {{session('error')}}
                        </p>
                        @endif

                        <h1>Checkout - Address</h1>
                        <div class="nav flex-column flex-md-row nav-pills text-center"><a href="checkout1.html" class="nav-link flex-sm-fill text-sm-center active"> <i class="fa fa-credit-card"> </i>Thanh toán</a></div>
                        <form action="/savethanhtoan" method="post">
                            @csrf
                            <div class="content py-3">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tennguoinhan">Tên người nhận</label>
                                            <input id="tennguoinhan" name="tennguoinhan" type="text" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="diachinguoinhan">Địa chỉ người nhận</label>
                                            <input id="diachinguoinhan" name="diachinguoinhan" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sdtnguoinhan">Số điện thoại người nhận</label>
                                            <input id="sdtnguoinhan" name="sdtnguoinhan" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hình thức thanh toán</label>
                                            <select type="number" name='hinhthuc' id="hinhthuc" class='form-control'>
                                                <option value="0">Thanh toán tiền mặt</option>
                                                <option value="1">Thanh toán chuyển khoản</option>
                                                <option value="2">Thanh toán MoMo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="note">Ghi chú</label>
                                            <textarea id="note" name="note" type="text" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.row-->

                                <!-- /.row-->

                                <!-- /.row-->
                            </div>
                            <div class="box-footer d-flex justify-content-between">
                                @if(Session::has('coupon'))
                                <input type="hidden" name="coupon_donhang" value="{{Session::get('coupon')[0]['codegiamgia']}}">
                                @else
                                <input type="hidden" name="coupon_donhang" value="no">
                                @endif
                                @php
                                $tong = 0;
                                foreach (Cart::content() as $item) {
                                $tong += $item->qty * $item->price;
                                }
                                if (Cart::count() > 0) {
                                if (Session::has('coupon')) {
                                foreach (Session::get('coupon') as $cou) {
                                if ($cou['tinhnangma'] == 0) {
                                $sotiengiam = $cou['sotiengiam'];
                                $tong_coupon = ($tong * $sotiengiam) / 100;
                                } elseif ($cou['tinhnangma'] == 1) {
                                $sotiengiam = $cou['sotiengiam'];
                                $tong_coupon = $sotiengiam;
                                }

                                $tong_con = $tong - $tong_coupon;
                                if ($cou['tinhnangma'] == 0) {
                                $tong_con = $tong - $cou['sotiengiam'];
                                }
                                }
                                } else {
                                $tong_con = $tong;
                                }
                                }
                                
                                @endphp
                                <input type="hidden" name="tongmomo" value="{{$tong_con}}">
                                <!-- <input type="submit" class="btn btn-primary" name="payUrl" value="Thanh toán" /> -->
                            </div>
                            <input type="submit" class="btn btn-primary" name="payUrl" value="Thanh toán" />

                            <!-- <input type="submit" class="btn btn-primary" value="Thanh toán" /> -->
                        </form>

                    </div>

                    <!-- /.box-->
                </div>
                <div class="col-lg-3">
                    <div id="order-summary" class="card">
                        <div class="card-header">
                            <h3 class="mt-4 mb-4">Thong tin don hang</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>
                            <div class="table-responsive">
                                <table class="table">

                                    <tbody>
                                        <tr>
                                            <td>Tổng thành tiền</td>
                                            <th>{{ number_format(intval(str_replace(',', '', Cart::subtotal())), 0, '', '.') }}đ</th>
                                        </tr>
                                        <?php $tong = 0; ?>
                                        @foreach (Cart::content() as $item)
                                        <?php $tong += $item->qty * $item->price; ?>
                                        @endforeach
                                        @if(Cart::count()>0)
                                        @if(Session::has('coupon'))
                                        @foreach(Session::get('coupon') as $cou)
                                        <tr>
                                            <td>Mã giảm:</td>
                                            @if($cou['tinhnangma'] == 0)
                                            <th>{{ number_format($cou['sotiengiam'],0,',','.') }} %</th>
                                            @php
                                            $tong_coupon = ($tong * $cou['sotiengiam']) / 100;
                                            @endphp
                                            @elseif($cou['tinhnangma'] == 1)
                                            <th>{{ number_format($cou['sotiengiam'],0,',','.') }}đ</th>
                                            @php
                                            $tong_coupon = $cou['sotiengiam'];
                                            @endphp
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="total">Tổng thanh toán:</td>
                                            <?php $tong_con = $tong - $tong_coupon ?>
                                            @if($cou['tinhnangma'] == 0)
                                            <th>{{ number_format($tong_con,0,',','.') }}đ</th>
                                            <?php $tong_con = $tong - $cou['sotiengiam'] ?>
                                            @elseif($cou['tinhnangma'] == 1)
                                            <th>{{ number_format($tong_con,0,',','.') }}đ</th>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @else
                                        <?php $tong_con = $tong ?>
                                        <td class="total">Tổng thanh toán:</td>
                                        <th>{{ number_format($tong_con,0,',','.') }}đ</th>
                                        @endif
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-9-->
                <div class="col-lg-9">
                    <div id="order-summary" class="card">
                        <div class="card-header">
                            <h3 class="mt-4 mb-4">Thong tin don hang</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>
                            <div class="table-responsive">
                                <table class="table">

                                    @foreach(Cart::content() as $item)
                                    <tbody>
                                        <tr>
                                            <td><img src="{{asset('storage/img/'.$item->options->img)}}" style="width:100px" alt=""></td>
                                            <th>{{$item->name}}</th>
                                            <th>So luong: {{$item->qty}}</th>
                                            <th>{{number_format($item->price, 0, ',', '.')}}đ</th>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.col-lg-3-->
            </div>
        </div>
    </div>
</div>

@stop