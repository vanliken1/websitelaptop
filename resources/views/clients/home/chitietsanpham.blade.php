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
                            <li class="breadcrumb-item"><a href="#">Ladies</a></li>
                            <li class="breadcrumb-item"><a href="#">Tops</a></li>
                            <li aria-current="page" class="breadcrumb-item active">White Blouse Armani</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-3 order-2 order-lg-1">
                    <!--
              *** MENUS AND FILTERS ***
              _________________________________________________________
              -->
                    <div class="card sidebar-menu mb-4">
                        <div class="card-header">
                            <h3 class="h4 card-title">Categories</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column category-menu">
                                <li><a href="category.html" class="nav-link">Men <span class="badge badge-secondary">42</span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="category.html" class="nav-link">T-shirts</a></li>
                                        <li><a href="category.html" class="nav-link">Shirts</a></li>
                                        <li><a href="category.html" class="nav-link">Pants</a></li>
                                        <li><a href="category.html" class="nav-link">Accessories</a></li>
                                    </ul>
                                </li>
                                <li><a href="category.html" class="nav-link active">Ladies <span class="badge badge-light">123</span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="category.html" class="nav-link">T-shirts</a></li>
                                        <li><a href="category.html" class="nav-link">Skirts</a></li>
                                        <li><a href="category.html" class="nav-link">Pants</a></li>
                                        <li><a href="category.html" class="nav-link">Accessories</a></li>
                                    </ul>
                                </li>
                                <li><a href="category.html" class="nav-link">Kids <span class="badge badge-secondary">11</span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="category.html" class="nav-link">T-shirts</a></li>
                                        <li><a href="category.html" class="nav-link">Skirts</a></li>
                                        <li><a href="category.html" class="nav-link">Pants</a></li>
                                        <li><a href="category.html" class="nav-link">Accessories</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card sidebar-menu mb-4">
                        <div class="card-header">
                            <h3 class="h4 card-title">Brands <a href="#" class="btn btn-sm btn-danger pull-right"><i class="fa fa-times-circle"></i> Clear</a></h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Armani (10)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Versace (12)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Carlo Bruni (15)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Jack Honey (14)
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>
                            </form>
                        </div>
                    </div>
                    <div class="card sidebar-menu mb-4">
                        <div class="card-header">
                            <h3 class="h4 card-title">Colours <a href="#" class="btn btn-sm btn-danger pull-right"><i class="fa fa-times-circle"></i> Clear</a></h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"><span class="colour white"></span> White (14)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"><span class="colour blue"></span> Blue (10)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"><span class="colour green"></span> Green (20)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"><span class="colour yellow"></span> Yellow (13)
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"><span class="colour red"></span> Red (10)
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>
                            </form>
                        </div>
                    </div>
                    <!-- *** MENUS AND FILTERS END ***-->
                    <div class="banner"><a href="#"><img src="img/banner.jpg" alt="sales 2014" class="img-fluid"></a></div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div id="productMain" class="row">
                        @foreach($sanpham as $item)
                        <div class="col-md-6">
                            <div class="owl-carousel shop-detail-carousel">
                                <div><a href="detail.html"><img src="{{asset('storage/img/'.$item->img)}}" width="250px" height="350px" alt=""></a></div>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="box">
                                <h1 class="text-center">{{$item->tensanpham}}</h1>
                                <p class="price"> @if ($item->phantramkhuyenmai > 0 && $item->trangthaictkm == 1)
                                    <del>{{ number_format($item->gia, 0, ',', '.') }} đ</del>
                                    <caption>-{{ $item->phantramkhuyenmai }}%</caption>
                                <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                    {{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ
                                </div>
                                @else
                                <caption>{{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ</caption>
                                <div style="text-align: center;">...</div>
                                @endif</p>
                                <p class="text-center buttons"><a href="/cart/add/{{$item->idsanpham}}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to cart</a><a href="basket.html" class="btn btn-outline-primary"><i class="fa fa-heart"></i> Add to wishlist</a></p>
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
                        <p>{{$item->noidung}}</p>

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
                                <div><img src="{{asset('storage/img/'.$item->img)}}" width="150px" height="150px"  alt=""></div>
                                </div>
                                <div class="text">
                                    <h3><a href="/chitiet/{{$item->slug_sanpham}}">{{$item->tensanpham}}</a></h3>
                                    <p class="price">
                                    @if ($item->phantramkhuyenmai > 0 && $item->trangthaictkm == 1)
                                        <del>{{ number_format($item->gia, 0, ',', '.') }} đ</del>
                                        <caption>-{{ $item->phantramkhuyenmai }}%</caption>
                                    <div style="text-align: center; font-size: 1.125rem; font-weight: 300; color: #4fbfa8">
                                        {{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ
                                    </div>
                                    @else
                                    <caption>{{ number_format($item->giakhuyenmai, 0, ',', '.') }} đ</caption>
                                    <div style="text-align: center;">...</div>
                                    @endif
                                    </p>
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