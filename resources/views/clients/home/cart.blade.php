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
                            <li aria-current="page" class="breadcrumb-item active">Shopping cart</li>
                        </ol>
                    </nav>
                </div>
                <div id="basket" class="col-lg-9">
                    <div class="box">

                        <h1>Shopping cart</h1>
                        @if(isset($mess))
                        <div>{{ $mess }}</div>
                        @else
                        @if(session()->has('message'))
                        <p class="alert alert-primary sm-4">
                            {{session('message')}}
                        </p>
                        @elseif(session()->has('error'))
                        <p class="alert alert-danger sm-4">
                            {{session('error')}}
                        </p>
                        @endif
                        <div class="table-responsive">
                            <table class="table" id='cart'>
                                <thead>
                                    <tr>
                                        <th colspan="2">Product</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Tình trạng</th>
                                        <th>Số lượng</th>
                                        <th>Giá gốc</th>
                                        <th>Giá khuyến mãi</th>
                                        <th colspan="2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach(Cart::content() as $item)

                                    <tr>
                                        <td><img src="{{asset('storage/img/'.$item->options->img)}}" style="width:50px" alt=""></td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->id}}</td>
                                        <td>
                                            @if($item->options->soluongkho)
                                                <span style="color: green;">Còn hàng</span>
                                           

                                            @endif
                                           
                                        </td>
                                        <td>
                                            <input type="number" value="{{$item->qty}}" style="width: 60px;" class="form-control" data-id='{{$item->rowId}}'>
                                            <input type="hidden" class="soluongton_{{$item->rowId}}" value="{{$item->options->soluongkho}}">

                                        </td>


                                        <td>{{number_format($item->options->giagoc, 0, ',', '.')}}đ </td>
                                        <td>{{number_format($item->price, 0, ',', '.')}}đ </td>
                                        <td>{{number_format($item->qty * $item->price, 0, ',', '.')}}đ </td>
                                        <td><a href="/cart/remove/{{$item->rowId}}"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                </tbody>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Tổng thành tiền</th>
                                        <th colspan="2">{{ number_format(intval(str_replace(',', '', Cart::subtotal())), 0, '', '.') }}đ</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5"></th>
                                        <th colspan="2">
                                            @if(Session::has('coupon'))
                                            <a class="btn btn-primary checkcoupon" href="/xoama">Xóa mã giảm Giá</a>
                                            @endif
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endif
                        <!-- /.table-responsive-->
                        <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
                            <div class="left"><a href="category.html" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i> Continue shopping</a></div>
                            @if(Cart::count()>0)
                            <div class="right">
                                <a href="/thanhtoan" class="btn btn-primary">Proceed to checkout <i class="fa fa-chevron-right"></i></a>
                            </div>
                            @endif
                        </div>

                    </div>
                    <!-- /.box-->

                </div>
                <!-- /.col-lg-9-->

                <div class="col-lg-3">
                    <div id="order-summary" class="box">
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
                                        <td class="total">Tổng giảm:</td>
                                        @if($cou['tinhnangma'] == 0)
                                        <th>{{ number_format($tong - $tong_coupon,0,',','.') }}đ</th>
                                        @elseif($cou['tinhnangma'] == 1)
                                        <th>{{ number_format($tong-$cou['sotiengiam'],0,',','.') }}đ</th>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @endif
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box">
                        @if(Cart::count()>0)
                        <div class="box-header">
                            <h4 class="mb-0">Coupon code</h4>
                        </div>
                        <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
                        <form action="/checkcoupon" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="coupon" class="form-control"><span class="input-group-append">
                                    <button type="submit" name="checkcoupon" class="btn btn-primary checkcoupon"><i class="fa fa-gift"></i></button></span>
                            </div>

                            <!-- /input-group-->
                        </form>
                        @endif
                    </div>

                </div>

                <!-- /.col-md-3-->
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).ready(
        function() {
            $('#cart input[type=number]').on('change', function() {
                // alert($(this).val() );
                // alert( $(this).data('id') );
                var quantity = $(this).val();
                var rowId = $(this).data('id');
                var stockQuantity = $('.soluongton_' + rowId).val();

                if (quantity <= 0) {
                    $(this).val(1);
                    return;
                }

                $.ajax({
                    url: '/cart/edit',
                    type: 'post',
                    data: {
                        rowId: $(this).data('id'),
                        qty: $(this).val(),
                        stockQuantity: stockQuantity,
                        _token: $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function(dataReturn) {
                        console.log(dataReturn);
                        if(dataReturn.error){
                            alert(dataReturn.error)
                        }else{
                        $('#qty').html(dataReturn.n);
                        }
                        location.reload();
                    }
                });
            });
        }
    );
</script>
@stop