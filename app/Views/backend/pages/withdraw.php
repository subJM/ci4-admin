<?= $this->extend('backend/layout/pages-layout'); ?>
<?= $this->section('content') ?>


<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Users</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home')?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $pageTitle ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">
                        <div class="form-group m-0">
                            <select class="form-control coinSelect" id="coinSelect" name="coinSelect">
                                <option value="TRON">TRON</option>
                                <option value="EVC">SAC</option>
                            </select>
                        </div>
                    </div>
                    <div class="pull-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless table-hover table-striped" id="categories-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User Num</th>
                            <th scope="col">User ID</th>
                            <th scope="col">From</th>
                            <th scope="col">To</th>
                            <th scope="col">amount</th>
                            <th scope="col">Fee</th>
                            <th scope="col">Status</th>
                            <th scope="col">Create</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <th scope="row">Id</th>
                            <td>User ID</td>
                            <td>User Name</td>
                            <td>Email</td>
                            <td>Bio</td>
                            <td>Create</td>
                            <td>Update</td>
                            <td>action</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<?php include('modals/user-modal-form.php')?>
<?php include('modals/edit-user-modal-form.php')?>
<?php include('modals/edit-user-password-modal-form.php')?>

<?= $this->endSection() ?>
<?= $this->section('stylesheets')?>
    <link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.theme.min.css">
<?= $this->endSection()?>
<?= $this->section('scripts')?>
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/extra-assets/jquery-ui-1.13.2/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    var selectedCoin = $('#coinSelect').val(); // 기본 선택값 가져오기

    // ✅ 초기 DataTable 설정
    var categories_DT = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route_to('get-all-withdraw', 'TRON') ?>", // 기본값 설정
        dom: "Brtip",
        info: true,
        rowReorder: false, // 🚀 드래그 비활성화
        fnCreatedRow: function(row, data, index){
            $('td', row).eq(0).html(index + 1);
        },
        columnDefs: [
            {
                targets: [3, 4, 5, 6], // 글자수 제한
                render: function(data, type, row) {
                    var maxLength = 10;
                    return data.length > maxLength ? data.substring(0, maxLength) + "...": data;
                }
            }
        ],
        order: [[8, 'asc']]
    });

    // ✅ `coinSelect` 값이 변경될 때 AJAX URL 업데이트
    $('#coinSelect').on('change', function() {
        var selectedCoin = $(this).val(); // 선택된 값 가져오기

        // ✅ PHP에서 직접 만든 URL을 쓰지 않고 JavaScript에서 동적으로 URL 설정
        var newUrl = "/admin/get-all-withdraw/" + encodeURIComponent(selectedCoin);
        // ✅ DataTables에 새로운 URL을 설정하고 데이터 새로고침
        categories_DT.ajax.url(newUrl).load();
    });
});


    //입출금 제한
    $(document).on('click', '.editUserBtn' , function(e){
        e.preventDefault();
        var category_id = $(this).data('id');
        var url = "<?= route_to('get-user')?>";
        $.get(url,{category_id:category_id }, function(res){
            var modal_title = 'Edit category';
            var modal_btn_text = 'Save changes';
            var modal = $('body').find('div#edit-category-modal');
            modal.find('form').find('input[type="hidden"][name="category_id"]').val(category_id);
            modal.find('modal-title').html(modal_title);
            modal.find('modal-footer > button.action').html(modal_btn_text);
            modal.find('input[type="text"]').val(res.data.name);
            modal.find('span.error-text').html('');
            modal.modal('show');
        },'json');
    });

    //비밀번호 변경
    $(document).on('click', '.editUserPasswordBtn' , function(e){
        e.preventDefault();
        var category_id = $(this).data('id');
        var email = $(this).data('email');
        console.log(email);
        var url = "<?= route_to('get-user')?>";
        console.log(url);
        $.get(url,{category_id:category_id ,email:email }, function(res){
            var modal_title = 'Password Change';
            var modal_btn_text = 'Save changes';
            var modal = $('body').find('div#edit-user-password-modal');
            modal.find('form').find('input[type="hidden"][name="category_id"]').val(category_id);
            modal.find('modal-title').html(modal_title);
            modal.find('modal-footer > button.action').html(modal_btn_text);
            modal.find('input[type="text"]').val(email);
            modal.find('span.error-text').html('');
            modal.modal('show');
        },'json');
    });

    $('#change_user_password_form').on('submit', function(e) {
        e.preventDefault();
  //CSRF
        var csrfName = $('.ci_csrf_data').attr('name');
        var csrfHash = $('.ci_csrf_data').val();

        var form = this;
        var modal = $('body').find('div#edit-user-password-modal');
        var formdata = new FormData(form);
        form.append(csrfName,csrfHash);
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:formdata,
            processData: false,
            dataType: 'json',
            contentType:false,
            cache: false,
            beforeSend: function(){
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(res){
                //Update CSRF Hash
                $('.ci_csrf_hash').val(res.token);

                if($.isEmptyObject(res.error)){
                    if(res.status == 1){
                        modal.modal('hide');
                        toastr.success(res.msg);
                        categories_DT.ajax.reload(null, false); //update datatable
                    }else{
                        toastr.error(res.msg);
                    }
                }else{
                    $.each(res.error, function(prefix,val){
                        $form.find('span.'+prefix+'_error').text(val);
                    })
                }

            }
        });

    })

    $('#update_category_form').on('submit',function(e){
        e.preventDefault();
        
        //CSRF
        var csrfName = $('.ci_csrf_data').attr('name');
        var csrfHash = $('.cicsrf_data').val();
        var user_block = $('.user_block').val();
        var form = this;
        var modal = $('body').find('div#edit-category-modal');
        var formdata = new FormData(form);
        form.append(csrfName,csrfHash);
        form.append('user_block',user_block);
        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:formdata,
            processData: false,
            dataType: 'json',
            contentType:false,
            cache: false,
            beforeSend: function(){
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(res){
                //Update CSRF Hash
                $('.ci_csrf_hash').val(res.token);

                if($.isEmptyObject(res.error)){
                    if(res.status == 1){
                        modal.modal('hide');
                        toastr.success(res.msg);
                        categories_DT.ajax.reload(null, false); //update datatable
                    }else{
                        toastr.error(res.msg);
                    }
                }else{
                    $.each(res.error, function(prefix,val){
                        $form.find('span.'+prefix+'_error').text(val);
                    })
                }

            }
        });
    })

    // $(document).on('click', '.deleteCategoryBtn', function(e){
    //     e.preventDefault();
    //     var category_id = $(this).data('id');
    //     var url = "<?= route_to('delete-category') ?>";
    //     swal.fire({
    //         title: 'ara you sure?',
    //         html: 'You want to delete this category',
    //         showCloseButten: true,
    //         showCancelButton:true,
    //         cancelButtonText:'Cancel',
    //         confirmButtonText:'Yes, Delect',
    //         cancelButtonColor: '#d33',
    //         confirmButtonColor: '#3085d6',
    //         width:300,
    //         allowOutsideClick:false
    //     }).then(function(result){
    //         if(result.value){
    //             $.get(url,{category_id: category_id},function(res){
    //                 if(res.status ==1){
    //                     categories_DT.ajax.reload(null,false);
    //                     subcategoriesDT.ajax.reload(null,false);
    //                     toastr.success(res.msg);
    //                 }else{
    //                     toastr.error(res.msg);
    //                 }
    //             },'json');
    //         }
    //     });
    // });

    $('table#categories-table').find('tbody').sortable({
        update: function(event, ui){
            $(this).children().each(function(index){
                if($(this).attr('data-ordering') != (index+1)){
                    $(this).attr('data-ordering', (index+1)).addClass('updated');
                }
            });
            var positions = [];

            $('.updated').each(function(){
                positions.push([$(this).data('index'), $(this).data('ordering')]); 
                $(this).removeClass('updated');
            });

            var url = "<?= route_to('reorder-categories') ?>";
            $.get(url, {positions:positions}, function(res){
                if(res.status == 1){
                    categories_DT.ajax.reload(null, false);
                    toastr.success(res.msg);
                }
            },'json');
        }
    });

</script>
<?= $this->endSection()?>