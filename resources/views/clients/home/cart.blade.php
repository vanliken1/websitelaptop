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
                        <form method="post" action="checkout1.html">
                            <h1>Shopping cart</h1>
                            @if(isset($mess))
                                <div>{{ $mess }}</div>
                            @else
                            <div class="table-responsive">
                                <table class="table" id='cart'>
                                    <thead>
                                        <tr>
                                            <th colspan="2">Product</th>
                                            <th>Mã sản phẩm</th>
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
                                                <input type="number" value="{{$item->qty}}" class="form-control" data-id='{{$item->rowId}}'>
                                            </td>
                                            <td>{{number_format($item->options->giagoc, 0, ',', '.')}}</td>
                                            <td>{{number_format($item->price, 0, ',', '.')}}</td>
                                            <td>{{number_format($item->qty*$item->price,0, ',', '.')}}</td>
                                            <td><a href="/cart/remove/{{$item->rowId}}"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th colspan="2">{{ number_format(intval(str_replace(',', '', Cart::subtotal())), 0, '', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @endif
                            <!-- /.table-responsive-->
                            <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
                                <div class="left"><a href="category.html" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i> Continue shopping</a></div>
                                <div class="right">
                                    <button type="submit" class="btn btn-primary">Proceed to checkout <i class="fa fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </form>
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
                                        <td>Tổng</td>
                                        <th>{{ number_format(intval(str_replace(',', '', Cart::subtotal())), 0, '', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <td>Shipping and handling</td>
                                        <th>0</th>
                                    </tr>
                                    <tr class="total">
                                        <td>Thành tiền</td>
                                        <th>{{Cart::subtotal()}}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h4 class="mb-0">Coupon code</h4>
                        </div>
                        <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control"><span class="input-group-append">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-gift"></i></button></span>
                            </div>
                            <!-- /input-group-->
                        </form>
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
                if ($(this).val() <= 0) {
                    $(this).val(1);
                    return;
                }

                $.ajax({
                    url: '/cart/edit',
                    type: 'post',
                    data: {
                        rowId: $(this).data('id'),
                        qty: $(this).val(),
                        _token: $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function(dataReturn) {
                        console.log(dataReturn);
                        $('#qty').html(dataReturn.n);
                        location.reload();
                    }
                });
            });
        }
    );
</script>
@stop