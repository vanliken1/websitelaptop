@extends('admin/layouts/masteradmin')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <form action="/admin/khuyenmai/them" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input for="exampleInputEmail1" class="form-label" name="idkhuyenmai" value="{{$id}}"></input>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>

                    @foreach($sp as $item)
                    @if(!in_array($item->idsanpham, $existingValues))
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" name="sanpham[]" value="{{$item->idsanpham}}" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{$item->idsanpham}}
                        </label>
                    </div>
                    @endif
                    <!-- <option value="{{$item->idsanpham}}">{{$item->idsanpham}}</option> -->
                    @endforeach

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <!-- <select class="select" multiple>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
  <option value="4">Four</option>
  <option value="5">Five</option>
  <option value="6">Six</option>
  <option value="7">Seven</option>
  <option value="8">Eight</option>
</select> -->
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<!-- <script>
    $(function() {

$('#chkveg').multiselect({
  includeSelectAllOption: true
});

$('#btnget').click(function() {
  alert($('#chkveg').val());
});
}); -->

@stop