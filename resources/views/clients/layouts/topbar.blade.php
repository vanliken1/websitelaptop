<div id="top">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offer mb-3 mb-lg-0"><a href="#" class="btn btn-success btn-sm">Offer of the day</a><a href="#" class="ml-1">Get flat 35% off on orders over $50!</a></div>
      <div class="col-lg-6 text-center text-lg-right">
        <ul class="menu list-inline mb-0">
        @auth
            <li class="list-inline-item"  style="color: red;"><p>Welcome, {{ auth()->user()->tennguoidung }}</p></li>
            <li class="list-inline-item">
              <form action="/dangxuat" method="post">
                @csrf
                <button type="submit" class="btn btn-link">Logout</button>
              </form>
            </li>
            <li class="list-inline-item"><a href="/history">Thông tin</a></li>
          @else
            <li class="list-inline-item"><a href="/dangnhap">Login</a></li>
          @endauth
          <li class="list-inline-item"><a href="contact.html">Contact</a></li>
          <li class="list-inline-item"><a href="#">Recently viewed</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- *** TOP BAR END ***-->


</div>