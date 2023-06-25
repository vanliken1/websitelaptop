@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý thương hiệu</h6>
                <p><button class='addBrand btn btn-primary'>Thêm</button></p>
                <form class="col-sm-6 mb-4" action="/admin/brand" method="GET">
                    <div class="form-group">
                        <input class="form-control-sm" type="search" name="keyword" maxlength="255" placeholder="Search" required>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                @if(session()->has('mess'))
                <div class="alert alert-primary sm-4">
                    {{session('mess')}}
                </div>
                @endif

                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên thương hiệu</th>
                                <th>Trạng thái</th>
                                <th>🗑️</th>
                                <th>✏️</th>
                            </tr>
                        </thead>

                        @foreach($thuonghieu as $item)
                        <tbody>

                            <tr>
                                <td>{{$item->idthuonghieu}}</td>
                                <td>{{$item->tenthuonghieu}}</td>
                                <td>
                                    @if($item->trangthai==0)
                                    {{'Ẩn'}}
                                    @else
                                    {{'Hiện'}}
                                    @endif
                                </td>
                                <td>
                                    <form action="/admin/brand/destroy/{{$item->idthuonghieu}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="submit" value="xóa" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <button class='editBrand btn btn-success' data-id='{{$item->idthuonghieu}}'>Sửa</button>
                                </td>

                            </tr>
                        </tbody>
                        @endforeach
                    </table>

                    <div class="" style="float: right;"> {{$thuonghieu->appends(Request::all())->links()}}</div>

                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Thương hiệu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="hidden" class="form-control" id="idthuonghieu" name="idthuonghieu">
                            <span class="text-danger error-text idthuonghieu_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tenthuonghieu' class='form-control mt-3'>
                            <label for="floatingInput">Tên thương hiệu</label>
                            <span class="text-danger error-text tenthuonghieu_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='slug_thuonghieu' class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text slug_thuonghieu_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <textarea style="height: 150px;" name="motathuonghieu" id="motathuonghieu" class='form-control'></textarea>
                            <label for="floatingInput">Mô tả</label>
                            <span class="text-danger error-text motathuonghieu_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='trangthai' class='form-select mt-3'>
                                <option value="0">Ẩn</option>
                                <option value="1" selected>Hiện</option>
                            </select>
                            <label for="floatingInput">Trạng thái</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/brand" class="btn btn-secondary">Thoát</a>
                <button type="button" class="btn btn-primary storeBrand">Save..</button>
            </div>


        </div>
    </div>
</div>
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <form method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="idthuonghieu" name="idthuonghieu" readonly>
                            <label for="floatingInput">ID</label>
                            <span class="text-danger error-text idthuonghieu_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tenthuonghieu' id="tenthuonghieu" class='form-control mt-3'>
                            <label for="floatingInput">Tên thương hiệu</label>
                            <span class="text-danger error-text tenthuonghieu_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='slug_thuonghieu' id="slug_thuonghieu" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text slug_thuonghieu_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <textarea style="height: 150px;" name="motathuonghieu" id="motathuonghieu" class='form-control'></textarea>
                            <label for="floatingInput">Mô tả</label>
                            <span class="text-danger error-text motathuonghieu_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='trangthai' id="trangthai" class='form-select mt-3'>
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                            <label for="floatingInput">Trạng thái</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/brand" class="btn btn-secondary">Thoat</a>

                <button type="button" class="btn btn-primary updateBrand">Save..</button>
            </div>


        </div>
    </div>
</div>
<!-- Table End -->
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

            $('button.addBrand').click(
                function() {
                    $('#modelId').modal('show');
                }
            );

            $('button.storeBrand').click(function() {

                let data = new FormData($('#modelId form')[0]); // you can consider this as 'data bag'
                //  files.append('fileName', $('#img')[0].files[0]);
                // let formData = new FormData();
                // formData.append('img', $('#img')[0].files[0]);
                // alert('hello');
                // e.preventDefault();
                //var ten = $("#ten").val();
                $.ajax({
                    url: '/admin/brand/store',
                    type: 'POST',
                    //  data: $('#modelId form').serializeArray(),files,
                    data: data,
                    dataType: 'json',
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    // async: false,
                    // cache: false,
                    // enctype: 'multipart/form-data',
                    success: function(s) {
                        console.log(s);
                        if ($.isEmptyObject(s.error)) {
                            alert("Thêm thành công");
                            location.reload();
                            $('#modelId').modal('hide');
                        } else {
                            printErrorMsg(s.error);
                            // $.each( s.error , function(k,v){
                            //     alert(k+'->'+v);
                            // })
                        }
                        //$('#modelId form #ten2').val(s.error);
                        //location.reload();
                        // location.reload();
                        // $('#modelId').modal('hide');
                    },

                });

                function printErrorMsg(msg) {
                    $.each(msg, function(key, value) {
                        console.log(key);
                        $('.' + key + '_err').text(value);
                    });
                }
            });

        }
    );
    $(document).ready(
        function() {
            $('button.editBrand').click(
                function() {
                    //let data = new FormData( $('#modelId form')[0] );

                    $('#modelId1').modal('show');
                    $.ajax({
                        url: '/admin/brand/edit/' + $(this).data('id'),
                        type: 'get',
                        data: {
                            id: 1
                        },
                        dataType: 'json',
                        success: function(data2) {
                            console.log(data2);
                            $('#modelId1 form #tenthuonghieu').val(data2.tenthuonghieu);
                            $('#modelId1 form #idthuonghieu').val(data2.idthuonghieu);
                            $('#modelId1 form #motathuonghieu').val(data2.motathuonghieu);
                            $('#modelId1 form #slug_thuonghieu').val(data2.slug_thuonghieu);

                            $('#modelId1 form #trangthai').val(data2.trangthai);

                        }
                    })
                }
            );
            $('button.updateBrand').click(function() {
                // alert('update');
                //     let data = {_token: $('input[name="_token"]:eq(0)').val() };//new FormData( $('#modelId1 form')[0] );
                //  console.log(data);
                // return;
                let data = new FormData($('#modelId1 form')[0])
                $.ajax({
                    url: '/admin/brand/update',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    processData: false, // tell jQuery not to process the data
                    contentType: false,
                    success: function(s) {
                        console.log(s);
                        if ($.isEmptyObject(s.error)) {
                            alert("Sua thanh cong");
                            location.reload();
                            $('#modelId1').modal('hide');
                        } else {
                            printErrorMsg(s.error);
                            // $.each( s.error , function(k,v){
                            //     alert(k+'->'+v);
                            // })
                        }
                    },
                    // error: function(mess) {
                    //     console.log(mess);
                    // }

                });

                function printErrorMsg(msg) {
                    $.each(msg, function(key, value) {
                        console.log(key);
                        $('.' + key + '_err').text(value);
                    });
                }
            });
        }
    );
</script>
@stop