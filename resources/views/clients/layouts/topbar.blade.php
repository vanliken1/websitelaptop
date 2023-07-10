<div id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offer mb-3 mb-lg-0"></div>
      <div class="col-lg-6 text-center text-lg-right">
        <ul class=" list-inline mb-0">
        @if(auth()->check())
            <li class="list-inline-item "  style="color: red;"><p>Welcome, {{ auth()->user()->tennguoidung }}</p></li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item ">
              <form action="/dangxuat" method="post">
                @csrf
                <button type="submit" class="btn btn-link">Logout</button>
              </form>
            </li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item"><a href="/history">Thông tin</a></li>
            <li class="list-inline-item">|</li>
          @else
            <li class="list-inline-item"><a href="/dangnhap">Đăng nhập/Đăng ký</a></li>
            <li class="list-inline-item">|</li>
          @endif
          <li class="list-inline-item"><a href="#">Contact</a></li>
          <li class="list-inline-item">|</li>
          <li class="list-inline-item"><a href="#">Recently viewed</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- *** TOP BAR END ***-->


</div>