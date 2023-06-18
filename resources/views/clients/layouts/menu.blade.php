<nav class="navbar navbar-expand-lg">
  <div class="container"><a href="index.html" class="navbar-brand home"><img src="img/logo.png" alt="Obaju logo" class="d-none d-md-inline-block"><img src="img/logo-small.png" alt="Obaju logo" class="d-inline-block d-md-none"><span class="sr-only">Obaju - go to homepage</span></a>
    <div class="navbar-buttons">
      <button type="button" data-toggle="collapse" data-target="#navigation" class="btn btn-outline-secondary navbar-toggler"><span class="sr-only">Toggle navigation</span><i class="fa fa-align-justify"></i></button>
      <button type="button" data-toggle="collapse" data-target="#search" class="btn btn-outline-secondary navbar-toggler"><span class="sr-only">Toggle search</span><i class="fa fa-search"></i></button><a href="basket.html" class="btn btn-outline-secondary navbar-toggler"><i class="fa fa-shopping-cart"></i></a>
    </div>
    <div id="navigation" class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a href="/" class="nav-link ">Home</a></li>
        <li class="nav-item dropdown menu-large"><a href="/laptop" data-hover="dropdown" data-delay="200" class="dropdown-toggle nav-link">Laptop<b class="caret"></b></a>
          <ul class="dropdown-menu megamenu">
            <li>
              <div class="row">
                <div class="col-md-10 col-lg-3">
                  <h5>Laptop theo thương hiệu</h5>
                  <ul class="list-unstyled mb-3">
                    @foreach($thuonghieu as $item)
                    <li class="nav-item"><a href="/laptop/{{$item->slug_thuonghieu}}" class="nav-link">{{$item->tenthuonghieu}}</a></li>
                    @endforeach

                  </ul>
                </div>
                <div class="col-md-10 col-lg-3">
                  <h5>Laptop theo cấu hình</h5>
                  <ul class="list-unstyled mb-3">
                    @foreach($cpu as $item)
                    <li class="nav-item"><a href="/laptop/{{$item->slug_CPU}}" class="nav-link">{{$item->tenCPU}}</a></li>
                    @endforeach

                  </ul>
                </div>
                <div class="col-md-10 col-lg-3">
                  <h5>Laptop theo nhu cầu</h5>
                  <ul class="list-unstyled mb-3">
                    @foreach($loaisp as $item)
                    <li class="nav-item"><a href="/laptop/{{$item->slug_loai}}" class="nav-link">{{$item->tenloai}}</a></li>
                    @endforeach
                  </ul>
                </div>

                <!-- <div class="col-md-6 col-lg-3">
                        <h5>Featured</h5>
                        <ul class="list-unstyled mb-3">
                          <li class="nav-item"><a href="category.html" class="nav-link">Trainers</a></li>
                          <li class="nav-item"><a href="category.html" class="nav-link">Sandals</a></li>
                          <li class="nav-item"><a href="category.html" class="nav-link">Hiking shoes</a></li>
                        </ul>
                        <h5>Looks and trends</h5>
                        <ul class="list-unstyled mb-3">
                          <li class="nav-item"><a href="category.html" class="nav-link">Trainers</a></li>
                          <li class="nav-item"><a href="category.html" class="nav-link">Sandals</a></li>
                          <li class="nav-item"><a href="category.html" class="nav-link">Hiking shoes</a></li>
                        </ul>
                      </div> -->
              </div>
            </li>
          </ul>
        </li>

      </ul>
      <div class="navbar-buttons d-flex justify-content-end">
        <!-- /.nav-collapse-->
        <div id="search-not-mobile" class="navbar-collapse collapse"></div><a data-toggle="collapse" href="#search" class="btn navbar-btn btn-primary d-none d-lg-inline-block"><span class="sr-only">Toggle search</span><i class="fa fa-search"></i></a>
        <div id="qty" class="navbar-collapse collapse d-none d-lg-block"><a href="/cart" class="btn btn-primary navbar-btn qty"><i class="fa fa-shopping-cart"></i><span>{{Cart::count()}} sản phẩm trong giỏ hàng</span></a></div>
      </div>
    </div>
  </div>
</nav>
<div id="search" class="collapse">
  <div class="container">
    <form role="search" class="ml-auto form-search" action="/search" method="GET">
      <div class="input-group">
        <input type="text" placeholder="Search" name="keyword" class="form-control">
        <div class="input-group-append">
          <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </div>
      </div>
    </form>
  </div>
</div>

</header>