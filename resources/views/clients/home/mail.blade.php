<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="border-radius:12px;padding:15px;">
        <div class="col-md-12">
            <div class="row" style="background-color: pink;padding:15px">
                <div class="col-md-6" style="text-align: center;color:blue;font-weight:bold;font-size:30px">
                    <h4 style="margin:0">CÔNG TY CÔNG NGHỆ BÁN LAPTOP HẠO VĂN</h4>
                    <h6 style="margin:0">DỊCH VỤ BÁN HÀNG-NHẬP KHẨU LAPTOP CHUYÊN NGHIỆP</h6>
                </div>
                <div class="col-md-6 logo" style="color:#fff">
                    <p>Chào bạn <strong style="color:#000;text-decoration:underline;">{{ $dataEmail['tennguoinhan'] }}</strong></p>
                </div>
                <div class="col-md-12">
                    <p style="color:#fff;font-size:17px">Bạn hoặc một người bạn nào đó của bạn đã đăng ký dịch vụ tại shop của chúng tôi với những thông tin sau:</p>
                    <h4 style="color: #000;text-transform:uppercase">Thông tin đơn hàng</h4>
                    <p>Mã đơn hàng:<strong style="text-transform:uppercase;color:#fff">{{$dataEmail['madonhang']}}</strong></p>
                    <p>Mã giảm giá áp dụng:<strong style="text-transform:uppercase;color:#fff">@if($dataEmail['magiamgia']!='no'){{$dataEmail['magiamgia']}}@else{{'Không có'}}@endif</strong></p>
                    <h4 style="color:#000;text-transform:uppercase;">Thông tin người nhận</h4>
                    <p>
                        Họ tên người nhận:{{ $dataEmail['tennguoigui'] }}
                    </p>
                    <p>
                        Địa chỉ nhận hàng:{{ $dataEmail['diachinguoinhan'] }}
                    </p>
                    <p>
                        Số điện thoại:{{ $dataEmail['sdtnguoinhan'] }}
                    </p>
                    <p>
                        Ghi chú:{{ $dataEmail['ghichu'] }}
                    </p>
                    <p>
                        Hình thức thanh toán:
                        @if($dataEmail['hinhthucthanhtoan']==0)
                        {{'Tiền mặt'}}
                        @else
                        {{'Chuyển khoản'}}
                        @endif
                    </p>
                    <p>Nếu thông tin người dùng không đúng có thể liên hệ với người đặt hàng để trao đổi thông tin về đơn hàng này</p>
                    <h4>Sản phẩm đã đặt</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Số lượng đặt</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $tong = 0; ?>
                            @foreach($dataEmail['cart'] as $item)
                            <?php $tong += $item->qty * $item->price; ?>
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{number_format($item->price, 0, ',', '.')}}đ</td>
                                <td>{{$item->qty}}</td>
                                <td>{{number_format($item->qty * $item->price, 0, ',', '.')}}đ</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>Tổng tiền thanh toán:</td>
                                <td>{{number_format($tong, 0, ',', '.')}}</td>
                            </tr>
                            <?php $tong2=0 ?>
                            @foreach ($dataEmail['cart'] as $item)
                            <?php $tong2 += $item->qty * $item->price; ?>
                            @endforeach
                            @if($dataEmail['cart']->count()>0)
                            @if(Session::has('coupon'))
                            @foreach($dataEmail['session_coupon'] as $cou)
                            <tr>
                                <td>Mã giảm:</td>
                                @if($cou['tinhnangma'] == 0)
                                <td>{{ number_format($cou['sotiengiam'],0,',','.') }} %</td>
                                @php
                                $tong_coupon = ($tong2 * $cou['sotiengiam']) / 100;
                                @endphp
                                @elseif($cou['tinhnangma'] == 1)
                                <td>{{ number_format($cou['sotiengiam'],0,',','.') }}đ</td>
                                @php
                                $tong_coupon = $cou['sotiengiam'];
                                @endphp
                                @endif
                            </tr>
                            <tr>
                                <td class="total">Tổng giảm:</td>
                                @if($cou['tinhnangma'] == 0)
                                <td>{{ number_format($tong2 - $tong_coupon,0,',','.') }}đ</td>
                                @elseif($cou['tinhnangma'] == 1)
                                <td>{{ number_format($tong2-$cou['sotiengiam'],0,',','.') }}đ</td>
                                @endif
                            </tr>
                            @endforeach
                            @endif
                            @endif

                        </tbody>

                    </table>



                </div>
                <p>Mọi chi tiết liên hệ website tại:<a href="http://127.0.0.1:8000/">laptopvanhao.com</a>, hoặc liên hệ hotline 0985142764.Xin cảm ơn quý khách đã đặt hàng</p>

            </div>
        </div>
    </div>
</body>

</html>