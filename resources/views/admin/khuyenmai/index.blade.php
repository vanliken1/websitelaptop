@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý khuyến mãi</h6>
                <p><button class='addkhuyenmai btn btn-primary'>Thêm</button></p>
                <form class="form-inline mb-10" action="/admin/khuyenmai" method="GET">

                    <input class="form-control-sm" type="search" name="keyword" placeholder="Search">
                    Ngày: <input type="date" id="datepicker" class="form-control-sm" name="tu_ngay" value="{{ $selectedDays }}">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>

                </form>
                @if(session()->has('mess'))
                <p class="alert alert-primary sm-4">
                    {{session('mess')}}
                </p>
                @endif
                @if(session()->has('errors'))
                <?php
                $mess = session()->get('errors');
                foreach ($mess as $i) {
                ?>
                    <p class="alert alert-danger sm-4">
                        <?php echo $i ?> trùng ngày nên không thêm đc
                    </p>
                <?php
                }
                ?>
                @endif
                <form action="/admin/khuyenmai/capnhat" method="POST">
                    @csrf
                    @foreach($khuyenmai as $item)
                    @if($item->ngaybatdau <= $today && $item->ngayketthuc >= $today && $item->trangthaictkm == 0 )
                        <input type="hidden" name="idkhuyenmai[]" value="{{$item->idkhuyenmai}}">
                        <!-- <input type="text"   name="idsanpham[]" value="{{$item->idsanpham}}"> -->
                        @endif

                        @endforeach
                        <!-- <input type="submit"> -->
                </form>
                <form id="them" method="POST">
                    @csrf
                    @foreach($khuyenmai as $item)
                    @if($item->ngaybatdau <= $today && $item->ngayketthuc >= $today && $item->trangthaictkm == 0 )
                        <input type="hidden" name="idkhuyenmai[]" value="{{$item->idkhuyenmai}}">
                        <!-- <input type="text"   name="idsanpham[]" value="{{$item->idsanpham}}"> -->
                        @endif

                        @endforeach

                </form>
                <!-- <button class="btn btn-primary btn_ajax"> AJAX</button> -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khuyến mãi</th>
                                <th scope="col">Ngay bat dau</th>
                                <th scope="col">Ngay ket thuc</th>
                                <th>📄</th>
                                <th>📄</th>
                                <th>📄</th>
                                <th>🗑️</th>
                                <th>✏️</th>
                            </tr>
                        </thead>
                        @foreach($khuyenmai as $item)

                        <tbody>
                            <tr>
                                <td>{{$item->idkhuyenmai}}</td>
                                <td>{{$item->tenkhuyenmai}}</td>
                                <td>{{$item->ngaybatdau}}</td>
                                <td>{{$item->ngayketthuc}}</td>
                                <td>
                                    <a href="/admin/khuyenmai/chitiet/{{$item->idkhuyenmai}}" class="btn btn-info"> Xem chi tiết</a>
                                </td>
                                @if($item->ngayketthuc >= $today)
                                <td>
                                    <form action="/admin/khuyenmai/destroy/{{$item->idkhuyenmai}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="submit" value="xóa" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <button class='editkhuyenmai btn btn-success' data-id='{{$item->idkhuyenmai}}'>Sửa Ajax</button>
                                </td>
                                <td>
                                    <a class='btn btn-warning' href='/admin/khuyenmai/editform/{{$item->idkhuyenmai}}'>Sửa</button>
                                </td>

                                <td>
                                    <a href="/admin/khuyenmai/them/{{$item->idkhuyenmai}}" class="btn btn-primary"> Thêm chi tiết </a>
                                </td>
                                @else
                                <td>
                                    <button disabled class="btn btn-danger">Xóa</button>
                                </td>
                                <td>
                                    <button disabled class="btn btn-success">Sửa Ajax</button>
                                </td>
                                <td>
                                    <button disabled class="btn btn-warning"> Sửa </a>
                                </td>
                                <td>
                                    <button disabled class="btn btn-primary">Thêm chi tiết</button>
                                </td>

                                @endif

                            </tr>
                        </tbody>
                        @endforeach

                    </table>
                    <div class="" style="float: right;"> {{$khuyenmai->appends(Request::all())->links()}}</div>

                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="hidden" class="form-control" id="idkhuyenmai" name="idkhuyenmai">
                            <span class="text-danger error-text idkhuyenmai_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tenkhuyenmai' id="tenkhuyenmai" class='form-control mt-3'>
                            <label for="floatingInput">Tên khuyenmai</label>
                            <span class="text-danger error-text tenkhuyenmai_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngaybatdau' id="ngaybatdau" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text ngaybatdau_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngayketthuc' id="ngayketthuc" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text ngayketthuc_err"></span>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/khuyenmai" class="btn btn-secondary">Thoát</a>
                <button type="button" class="btn btn-primary storekhuyenmai">Save..</button>
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
                            <input type="text" class="form-control" id="idkhuyenmai" name="idkhuyenmai" readonly>
                            <label for="floatingInput">ID</label>
                            <span class="text-danger error-text idkhuyenmai_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tenkhuyenmai' id="tenkhuyenmai" class='form-control mt-3'>
                            <label for="floatingInput">Tên khuyenmai</label>
                            <span class="text-danger error-text tenkhuyenmai_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngaybatdau' id="ngaybatdau" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text ngaybatdau_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngayketthuc' id="ngayketthuc" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text ngayketthuc_err"></span>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/khuyenmai" class="btn btn-secondary">Thoat</a>

                <button type="button" class="btn btn-primary updatekhuyenmai">Save..</button>
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
    $(document).ready(function() {
        // $('button.btn_ajax').click(function() {
        //     //var a = [];
        //     // $("input[name='idkhuyenmai']").each(function() {
        //     //     a.push($(this).val());
        //     // });
        //     // console.log(a);
        //     var data = $('#them').serializeArray()
        //     console.log(data)
        //     $.ajax({
        //         url: '/admin/khuyenmai/capnhat',
        //         type: 'POST',
        //         data: data,
        //         dataType: 'json',
        //         success: function(s) {
        //             console.log(s)

        //         },
        //         error: function(s) {
        //             console.log(s)
        //         }
        //     })
        // })

        $('button.addkhuyenmai').click(
            function() {
                $('#modelId').modal('show');
            }
        );

        $('button.storekhuyenmai').click(function() {

            let data = new FormData($('#modelId form')[0]); // you can consider this as 'data bag'
            //  files.append('fileName', $('#img')[0].files[0]);
            // let formData = new FormData();
            // formData.append('img', $('#img')[0].files[0]);
            // alert('hello');
            // e.preventDefault();
            //var ten = $("#ten").val();
            $.ajax({
                url: '/admin/khuyenmai/store',
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

    });
    $(document).ready(
        function() {
            $('button.editkhuyenmai').click(
                function() {
                    //let data = new FormData( $('#modelId form')[0] );

                    $('#modelId1').modal('show');
                    $.ajax({
                        url: '/admin/khuyenmai/edit/' + $(this).data('id'),
                        type: 'get',
                        data: {
                            id: 1
                        },
                        dataType: 'json',
                        success: function(data2) {
                            console.log(data2);
                            $('#modelId1 form #idkhuyenmai').val(data2.idkhuyenmai);
                            $('#modelId1 form #tenkhuyenmai').val(data2.tenkhuyenmai);
                            $('#modelId1 form #ngaybatdau').val(data2.ngaybatdau);
                            $('#modelId1 form #ngayketthuc').val(data2.ngayketthuc);


                        }
                    })
                }
            );
            $('button.updatekhuyenmai').click(function() {
                // alert('update');
                //     let data = {_token: $('input[name="_token"]:eq(0)').val() };//new FormData( $('#modelId1 form')[0] );
                //  console.log(data);
                // return;
                let data = new FormData($('#modelId1 form')[0])
                $.ajax({
                    url: '/admin/khuyenmai/update',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    processData: false, // tell jQuery not to process the data
                    contentType: false,
                    success: function(s) {
                        console.log(s);
                        if ($.isEmptyObject(s.error)) {
                            //console.log()
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
    // $(function() {
    //     var fiveSecond = 30000;
    //     var oneMinute = 1000 * 60;
    //     setInterval(function() {
    //         // var date = new Date();
    //         // var current_date = date.getHours()+"-"+date.getMinutes();
    //         // if(current_date == "0-0"){
    //         //     $.ajax({
    //         //         url: "/auto",
    //         //         type: "GET",
    //         //         success: function (data) {
    //         //             console.log(data)
    //         //         },
    //         //     });
    //         // }
    //         $.ajax({
    //             url: "/admin/khuyenmai/capnhatajax",
    //             type: "POST",
    //             success: function(data) {
    //                 console.log('da chay');
    //             },
    //         });
    //     }, fiveSecond);
    // })
</script>
@stop