@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý chi tiết Khuyến Mãi</h6>
                <!-- <p><button class='addkm btn btn-primary'>Thêm</button></p> -->
                <form class="col-sm-12 mb-4" action="/admin/khuyenmai/chitiet/{{$id}}" method="GET">

                    <input class="form-control-sm" type="search" name="keyword" maxlength="255" placeholder="Search">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>

                </form>
                @if(session()->has('mess'))
                <!-- <p class="alert alert-primary sm-4">
                    {{session('mess')}}
                </p> -->
                <script>
                    // Lấy giá trị từ session message
                    var message = "{{ session('mess') }}";

                    // Hiển thị thông báo bằng SweetAlert
                    Swal.fire({
                        title: "Thông báo",
                        text: message,
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true,
                        timerProgressBar: true
                    })
                </script>
                @endif
                @if(session()->has('loi'))
                <?php
                $mess = session()->get('loi');
                foreach ($mess as $i) {
                ?>
                    <p class="alert alert-danger sm-4">
                        <?php echo $i ?> lỗi trùng ngày nên không thêm đc
                    </p>
                <?php
                }
                ?>
                @endif
                @if(session()->has('themthanhcong'))
                <?php
                $mess = session()->get('themthanhcong');

                foreach ($mess as $i) {
                ?>
                    <p class="alert alert-primary sm-4">
                        <?php echo $i ?> thêm thành công
                    </p>
                <?php
                }
                ?>
                @endif
                @if(session()->has('them'))
                <?php
                $mess = session()->get('them');
                foreach ($mess as $i) {
                ?>
                    <p class="alert alert-primary sm-4">
                        <?php echo $i ?> thêm thành công
                    </p>
                <?php
                }
                ?>
                @endif
                @if(session()->has('kiemtra'))
                <?php
                $mess = session()->get('kiemtra');
                //var_dump($mess);
                foreach ($mess as $i) {

                    if ($i['check'] == 'addNew' || $i['check'] == 'true') {
                    } else
                        if ($i['check'] == 'false') {
                        if ($i['trangthaictkm'] == 0) {
                ?>
                            <p class="alert alert-danger sm-4">
                                <?php echo $i['idsanpham'] ?> Không thêm được
                            </p>
                        <?php
                        }
                    } elseif ($i['check'] == 'truonghopmoi') {
                        if ($i['trangthaictkm'] == 1) {
                        ?>
                            <p class="alert alert-danger sm-4">
                                <?php echo $i['idsanpham'] ?> khong them duoc-truonghopmoi
                            </p>
                        <?php
                        }
                    } else {
                        ?>
                        <p class="alert alert-danger sm-4">
                            <?php echo $i['idsanpham'] ?> khong them duoc do ngay
                        </p>
                <?php
                    }
                }
                ?>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th>%</th>
                                <th>Trạng thái</th>
                                <th>🗑️</th>
                                <th>✏️</th>
                            </tr>
                        </thead>
                        @foreach($data as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->idkhuyenmai}}</td>
                                <td>{{$item->products->tensanpham}}</td>
                                <td>{{$item->phantramkhuyenmai}}</td>
                                <td>
                                    @if($item->trangthaictkm==0)
                                    <span style="color: red;">Hết hạn</span>
                                    @elseif($item->trangthaictkm==1)
                                    <span style="color: green;">Đang hoạt động</span>
                                    @else
                                    {{'Sắp hoạt động'}}
                                    @endif
                                </td>

                                @if($khuyenmai->ngayketthuc >= $today)
                                <td>
                                    <form action="/admin/khuyenmai/destroykm/{{$item->idsanpham}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="hidden" name="vanngu" value="{{$item->idkhuyenmai}}">
                                        <input type="submit" value="xóa" onclick="confirmXoa(event)" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <!-- <input type="text" id="idkhuyenmai" value="{{$item->idkhuyenmai}}"> -->
                                    <button class='editkm btn btn-success' data-idkhuyenmai="{{$item->idkhuyenmai}}" data-id='{{$item->idsanpham}}'>Sửa</button>
                                </td>
                                @else
                                <td>
                                    <button disabled class='btn btn-danger'>Xóa</button>
                                </td>
                                <td>
                                    <!-- <input type="text" id="idkhuyenmai" value="{{$item->idkhuyenmai}}"> -->
                                    <button disabled class='btn btn-success'>Sửa</button>
                                </td>
                                @endif

                            </tr>
                        </tbody>
                        @endforeach

                    </table>
                    <div class="" style="float: right;"> {{$data->appends(Request::all())->links()}}</div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa chi tiết khuyến mãi</h5>

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

                            <input type="number" min="1" step="1" name='phantramkhuyenmai' id="phantramkhuyenmai" class='form-control mt-3'>
                            <label for="floatingInput">Phần trăm khuyến mãi</label>
                            <span class="text-danger error-text phantramkhuyenmai_err"></span>
                        </div>
                        <div class="form-floating mb-3">
                            <input name='idsanpham' id="idsanpham" class='form-control mt-3' readonly>

                            <label for="floatingInput">Mã sp </label>
                            <span class="text-danger error-text idsanpham_err"></span>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/khuyenmai/chitiet/{{$id}}" class="btn btn-secondary">Thoat</a>

                <button type="button" class="btn btn-primary updatekm">Save..</button>
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
    function confirmXoa(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của sự kiện onchange

        Swal.fire({
            title: "Xác nhận xóa",
            text: "Bạn có chắc chắn muốn xóa?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                // Hành động xóa khi người dùng xác nhận
                event.target.form.submit();
            }
        });
    }
    $(document).ready(
        function() {

            $('button.addkm').click(
                function() {
                    $('#modelId').modal('show');
                }
            );

            $('button.storekm').click(function() {

                let data = new FormData($('#modelId form')[0]); // you can consider this as 'data bag'
                //  files.append('fileName', $('#img')[0].files[0]);
                // let formData = new FormData();
                // formData.append('img', $('#img')[0].files[0]);
                // alert('hello');
                // e.preventDefault();
                //var ten = $("#ten").val();
                $.ajax({
                    url: '/admin/khuyenmai/storekm',
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
            $('button.editkm').click(
                function() {
                    //let data = new FormData( $('#modelId form')[0] );
                    // Lấy giá trị ID từ thuộc tính "data-id" của nút
                    var idKhuyenMai = $(this).data('idkhuyenmai')
                    console.log(idKhuyenMai)
                    $('#modelId1').modal('show');
                    $.ajax({
                        url: '/admin/khuyenmai/editkm/' + $(this).data('id'),
                        type: 'get',
                        data: {
                            idkhuyenmai: idKhuyenMai
                            //     // id: $(this).data('id')
                        },
                        dataType: 'json',
                        success: function(data2) {
                            console.log(data2);
                            $('#modelId1 form #idkhuyenmai').val(data2[0].idkhuyenmai);
                            $('#modelId1 form #idsanpham').val(data2[0].idsanpham);
                            $('#modelId1 form #phantramkhuyenmai').val(data2[0].phantramkhuyenmai);
                            $('#modelId1 form #trangthai').val(data2[0].trangthaictkm);

                        }
                    })
                }
            );
            $('button.updatekm').click(function() {
                // alert('update');
                //     let data = {_token: $('input[name="_token"]:eq(0)').val() };//new FormData( $('#modelId1 form')[0] );
                //  console.log(data);
                // return;
                let data = new FormData($('#modelId1 form')[0])
                $.ajax({
                    url: '/admin/khuyenmai/updatekm',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    processData: false, // tell jQuery not to process the data
                    contentType: false,
                    success: function(s) {
                        console.log(s);
                        if ($.isEmptyObject(s.error)) {
                            Swal.fire({
                                title: "Sửa thành công",
                                icon: "success",
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                toast: true,
                                timerProgressBar: true,
                            }).then(function() {
                                location.reload();
                                $('#modelId1').modal('hide');
                            });
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