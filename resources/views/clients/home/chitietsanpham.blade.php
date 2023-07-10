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
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/laptop">Laptop</a></li>
                            <li class="breadcrumb-item">{{$sanpham[0]->tensanpham}}</li>
                           
                        </ol>
                    </nav>
                </div>
           
            
                <div class="col-lg-12 order-1 order-lg-2">
                    <div id="productMain" class="row">
                        @foreach($sanpham as $item)
                        <div class="col-md-6">
                            <div class="owl-carousel shop-detail-carousel">
                                <div><a href="detail.html"><img src="{{asset('storage/img/'.$item->img)}}" width="450px" height="450px" alt=""></a></div>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="box">
                                <h1 class="text-center">{{$item->tensanpham}}</h1>
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

                                    <!-- <caption>...</caption> -->

                                <caption style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                    {{ number_format($item->gia, 0, ',', '.') }} đ
                                </caption>

                                </p>
                                @endif
                                @if($item->soluong>0)
                                <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                    Còn hàng
                                </div>
                                @endif
                                <hr>

                                <p class="goToDescription"><a href="#details" class="scroll-to">Xem chi tiết thông số</a></p>


                                <p class="text-center buttons">
                                    <a href="/cart/add/{{$item->idsanpham}}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Mua ngay</a>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div id="details" class="box">
                        <p></p>
                        <h4 style="text-align: center;">Thông tin chi tiết</h4>
                        <div style="display: flex; justify-content: center;">

                            <table class="table table-striped" style="width:400px;">

                                <tbody>
                                    <tr>
                                        <th scope="row">Mã sản phẩm</th>
                                        <td>{{$item->idsanpham}}</td>
                                        <!-- 
                                  
                                    
                                    
                                    <th scope="row">Nhu cầu sử dụng</th> -->
                                    </tr>
                                    <tr>
                                        <th scope="row">Thương hiệu</th>
                                        <td>{{$item->thuonghieu->tenthuonghieu}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">CPU</th>
                                        <td>{{$item->cpus->tenCPU}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Card đồ họa</th>
                                        <td>{{$item->dohoas->tendohoa}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">RAM</th>
                                        <td>{{$item->rams->tenram}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ổ cứng</th>
                                        <td>{{$item->luutrus->tenluutru}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Màn hình</th>
                                        <td>{{$item->manhinhs->tenmanhinh}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nhu cầu sử dụng</th>
                                        <td>{{$item->loaisp->tenloai}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h4>Mô tả sản phẩm</h4>
                        <p>{!!$item->noidung!!}</p>

                        <hr>
                        <div class="social">
                            <h4>Show it to your friends</h4>
                            <p><a href="#" class="external facebook"><i class="fa fa-facebook"></i></a><a href="#" class="external gplus"><i class="fa fa-google-plus"></i></a><a href="#" class="external twitter"><i class="fa fa-twitter"></i></a><a href="#" class="email"><i class="fa fa-envelope"></i></a></p>
                        </div>
                        @endforeach
                    </div>

                    <div class="row same-height-row">
                        <div class="col-md-3 col-sm-6">
                            <div class="box same-height">
                                <h3>Sản phẩm có thương hiệu tương tự</h3>
                            </div>
                        </div>
                        @foreach($sanphamlienquan as $item)
                        <div class="col-md-3 col-sm-6">
                            <div class="product same-height">
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <div><img src="{{asset('storage/img/'.$item->img)}}" width="150px" height="150px" alt=""></div>
                                </div>
                                <div class="text">
                                    <h3><a href="/chitiet/{{$item->slug_sanpham}}">{{$item->tensanpham}}</a></h3>
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
                                </div>
                            </div>
                            <!-- /.product-->
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.col-md-9-->
            </div>
        </div>
    </div>
</div>

@stop