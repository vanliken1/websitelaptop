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
                            <li aria-current="page" class="breadcrumb-item active">Laptop {{$sptheocpu[0]->cpus->tenCPU}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <!--
              *** MENUS AND FILTERS ***
              _________________________________________________________
              -->
                    <form action="/laptop/{{$slugdanhmuc}}" method="get">
                        <div class="card sidebar-menu mb-4">
                            <div class="card-header">
                                <h3 class="h4 card-title"><a href="/laptop/{{$slugdanhmuc}}">Làm mới <i class="fa fa-undo"></i></a></h3>
                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">Thương hiệu</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($thuonghieu as $item)
                                    <div class="checkbox">

                                        <label>
                                            <input type="checkbox" name="brand[]" value="{{$item->slug_thuonghieu}}" {{ in_array($item->slug_thuonghieu, $selectedBrands) ? 'checked' : '' }} onchange="this.form.submit()"> {{$item->tenthuonghieu}}
                                        </label>

                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">RAM</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($ram as $item)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="ram[]" {{ in_array($item->slug_ram, $selectedRAMs) ? 'checked' : '' }} onchange="this.form.submit()" value="{{$item->slug_ram}}">{{$item->tenram}}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">Lưu trữ</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($luutru as $item)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="luutru[]" {{ in_array($item->slug_luutru, $selectedLTs) ? 'checked' : '' }} onchange="this.form.submit()" value="{{$item->slug_luutru}}">{{$item->tenluutru}}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">Đồ họa</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($dohoa as $item)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="dohoa[]" {{ in_array($item->slug_dohoa, $selectedDHs) ? 'checked' : '' }} onchange="this.form.submit()" value="{{$item->slug_dohoa}}">{{$item->tendohoa}}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">Nhu cầu</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($loaisp as $item)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="nhucau[]" {{ in_array($item->slug_loai, $selectedNCs) ? 'checked' : '' }} onchange="this.form.submit()" value="{{$item->slug_loai}}">{{$item->tenloai}}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">Kích thước màn hình</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    @foreach($manhinh as $item)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="manhinh[]" {{ in_array($item->slug_manhinh, $selectedMHs) ? 'checked' : '' }} onchange="this.form.submit()" value="{{$item->slug_manhinh}}">{{$item->tenmanhinh}}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>

                            </div>
                            <div class="card-header">
                                <h3 class="h4 card-title">Mức giá</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" {{ in_array('under_10', $selectedPrices) ? 'checked' : '' }} name="gia[]" onchange="this.form.submit()" value="under_10"> Dưới 10 triệu
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" {{ in_array('10_to_15', $selectedPrices) ? 'checked' : '' }} name="gia[]" onchange="this.form.submit()" value="10_to_15"> 10-15 triệu
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" {{ in_array('15_to_20', $selectedPrices) ? 'checked' : '' }} name="gia[]" onchange="this.form.submit()" value="15_to_20"> 15-20 triệu
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" {{ in_array('20_to_25', $selectedPrices) ? 'checked' : '' }} name="gia[]" onchange="this.form.submit()" value="20_to_25"> 20-25 triệu
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" {{ in_array('over_25', $selectedPrices) ? 'checked' : '' }} name="gia[]" onchange="this.form.submit()" value="over_25"> Trên 25 triệu
                                        </label>
                                    </div>


                                </div>
                            </div>


                            <!-- <button type="submit" class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Lọc</button> -->
                        </div>

                        <!-- *** MENUS AND FILTERS END ***-->

                </div>

                <div class="col-lg-9">

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-md-12 col-lg-9 products-showing"><strong>Hiển thị tổng {{ $totalSanPham }} sản phẩm</strong></div>
                            <div class="products-sort-by ml-auto">

                                <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
                                    <option value="all" selected>--Tất cả--</option>

                                    <option value="tangdan" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'tangdan') echo 'selected'; ?>>--Giá tăng dần--</option>
                                    <option value="giamdan" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'giamdan') echo 'selected'; ?>>--Giá giảm dần--</option>
                                    <option value="hot" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'hot') echo 'selected'; ?>>--Hot--</option>

                                </select>

                            </div>



                            <!-- <div class="products-number"><strong>Show</strong><a href="#" class="btn btn-sm btn-primary">12</a><a href="#" class="btn btn-outline-secondary btn-sm">24</a><a href="#" class="btn btn-outline-secondary btn-sm">All</a><span>products</span></div> -->

                        </div>
                        </form>
                    </div>
                    <div class="row products">
                        @foreach($sptheocpu as $item)
                        <div class="col-lg-4 col-md-6">

                            <div class="product">

                                <div>
                                    <div>
                                        <div><a href="detail.html"><img src="{{asset('storage/img/'.$item->img)}}" width="250px" height="350px" alt=""></a></div>

                                    </div>
                                </div>
                                <div class="text">

                                    <h3><a href="detail.html">{{$item->tensanpham}}</a></h3>
                                    <?php $phantram = (($item->gia - $item->giakhuyenmai) / $item->gia) * 100 ?>
                                    @if($phantram!=0)
                                    <p class="price">

                                        <del>{{ number_format($item->gia, 0, ',', '.') }} đ</del>
                                        <caption>-{{ $phantram }}%</caption>
                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        {{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ
                                    </div>

                                    </p>
                                    @else
                                    <p class="price">

                                        <caption>...</caption>

                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        {{ number_format($item->gia, 0, ',', '.') }} đ
                                    </div>

                                    </p>
                                    @endif
                                    @if($item->soluong>0)
                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        Còn hàng
                                    </div>
                                    @endif
                                    <p class="buttons">
                                        <a href="/chitiet/{{$item->slug_sanpham}}" class="btn btn-outline-secondary">Thông tin</a>
                                        <a class="btn btn-primary add-to-cart" data-id="{{$item->idsanpham}}"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                    </p>

                                </div>

                                <!-- /.text-->

                                <!-- /.ribbon-->
                                @if($item->hot == 1)
                                <div class="ribbon gift">
                                    <div class="theribbon">HOT</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                @endif

                                @if($item->gia > $item->giakhuyenmai)
                                <div class="ribbon sale">
                                    <div class="theribbon">SALES</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                @endif
                                <!-- /.ribbon-->
                            </div>


                            <!-- /.product            -->
                        </div>
                        @endforeach


                        <!-- /.products-->
                    </div>
                    <div class="pages">
                        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                            <ul class="pagination">
                                <li>{{ $sptheocpu->appends(Request::all())->links() }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /.col-lg-9-->
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
    $(document).ready(function() {
        $('.add-to-cart').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            var url = "/cart/add/" + productId;
            // alert('hehe')
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {

                        // Swal.fire({
                        //     title: "Thêm vào giỏ hàng thành công",
                        //     icon: "success",
                        //     position: "top-end",
                        //     showConfirmButton: false,
                        //     timer: 4000,
                        //     toast: true,
                        //     timerProgressBar: true,
                        // }).then(function() {
                        //     location.reload();
                        // });
                        Swal.fire({
                            title: "Thêm vào giỏ hàng thành công",
                            text: "Bạn có muốn xem tiếp sản phẩm hoặc chuyển đến giỏ hàng?",
                            icon: "success",
                            position: "top-center",
                            showCancelButton: true,
                            confirmButtonText: "Xem tiếp",
                            cancelButtonText: "Chuyển đến giỏ hàng",
                            confirmButtonColor: "#4fbfa8",
                            cancelButtonColor: "#FFD700",
                            reverseButtons: true,
                        }).then((result) => {
                            if (result.value) {
                                // Người dùng đã nhấp vào "Xem tiếp"
                                // Thực hiện hành động xem tiếp sản phẩm tại đây
                                location.reload();
                            } else {
                                // Người dùng đã nhấp vào "Chuyển đến giỏ hàng"
                                // Thực hiện hành động chuyển đến đường dẫn giỏ hàng tại đây
                                window.location.href = "/cart";
                            }
                        });

                    } else {
                        Swal.fire({
                            title: "Sản phẩm đã tồn tại trong giỏ hàng",
                            icon: "error",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            timerProgressBar: true,


                        }).then(function() {
                            location.reload();
                        });

                    }
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 2000);

                },
                // error: function(xhr, status, error) {
                //     alert('An error occurred while adding the product to the cart.');
                // }
            });
        });

    });
</script>
@stop