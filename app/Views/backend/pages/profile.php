<?= $this->extend('backend/layout/pages-layout'); ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="javascript:;" onclick="event.preventDefault();document.getElementById('user_profile_file').click();" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <input type="file"  name="user_profile_file" id="user_profile_file" class="d-none">
                <img src="<?= get_user()->picture ==null ? '/backend/vendors/images/photo1.jpg' : '/images/users/'.get_user()->picture ?>" alt="" class="avatar-photo">
            </div>
            <h5 class="text-center h5 mb-0 ci-user-name"><?= get_user()->name ?></h5>
            <p class="text-center text-muted font-14">
                <?= get_user()->email?>
            </p>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#Personal_detail" role="tab">Personal details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="Personal_detail" role="tabpanel">
                            <div class="pd-20">
                                <?php $validation = \Config\Services::validation(); ?>
                                <form action="<?= route_to('update-personal-details') ?>" method="POST" id="personal_details_from">
                                    <?= csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">name</label>
                                                <input type="text" name="name"  class="form-control" placeholder="Enter full name" value="<?= get_user()->name ?>">
                                                <span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username"  class="form-control" placeholder="Enter full username" value="<?= get_user()->username ?>">
                                                <span class="text-danger error-text username_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Bio</label>
                                        <textarea name="bio" id="" cols="30" rows="10" class="form-control" placeholder="Bio...." ><?= get_user()->bio ?></textarea>
                                        <span class="text-danger error-text bio_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Save change
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Timeline Tab End -->
                        <!-- Tasks Tab start -->
                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                <form action="<?= route_to('change-password') ?>" method="POST" id="change_password_form">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Current password</label>
                                                <input type="password" class="form-control" placeholder="Enter current password" name="current_password">
                                                <span class="text-danger error-text current_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">New password</label>
                                                <input type="password" class="form-control" placeholder="Enter new password" name="new_password">
                                                <span class="text-danger error-text new_password_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Confirm new password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" placeholder="Retype new password" name="confirm_new_password" id="confirm_new_password">
                                                    <div class="input-group-append">
                                                        <button class="btn " type="button" style="border-left-color: #ffffff;border-top-color:#d4d4d4;border-bottom-color:#d4d4d4;border-right-color:#d4d4d4;" id="toggleConfirmPassword">
                                                            <i class="fa fa-eye" aria-hidden="true" style="color:#6b6b6b"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <span class="text-danger error-text confirm_new_password_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Change password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Tasks Tab End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts')?>
<script>

$("#toggleConfirmPassword").on("click", function() {
    var confirmPasswordField = $("#confirm_new_password");
    var fieldType = confirmPasswordField.attr("type");
    
    // 비밀번호 확인 필드의 타입을 토글
    confirmPasswordField.attr("type", fieldType === "password" ? "text" : "password");
    
    // 눈 모양 아이콘 변경
    $(this).find("i").toggleClass("fa-eye fa-eye-slash");
});


    $('#personal_details_from').on('submit', function(e){
        e.preventDefault();
        var form = this;
        var formdata = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforesend:function(){
                console.log('test');
                toastr.remove();
                $('form').find('span.error-text').text('');
            },
            success: function(response){
                console.log(response);
                if( $.isEmptyObject(response.error)){
                    if(response.status == 1){
                        $('.ci-user-name').each(function(){
                            $(this).html(response.user_info.name);
                        });
                        toastr.success(response.msg);
                    }else{
                        toastr.error('실패')
                    }
                }else{
                    $.each(response.error ,function(prefix,val){
                        console.log('prefix: '+ prefix);
                        $(form).find('span.'+prefix+'_error').text(val);
                    });
                }
            }
        });
    })
    $('#user_profile_file').ijaboCropTool({
          preview : '.ci-avatar-photo',
          setRatio:1,
          allowedExtensions: ['jpg', 'jpeg','png'],
          processUrl:'<?= route_to('update-profile-picture'); ?>',
          withCSRF:['<?= csrf_token() ?>','<?= csrf_hash() ?>'],
          onSuccess:function(message, element, status){
            if(status ==1){
                toastr.success(message);
            }else{
                toastr.success(message);
            }
          },
          onError:function(message, element, status){
            alert(message);
          }
      });   

      //Change password
      $('#change_password_form').on('submit',function(e){
        e.preventDefault();
        var csrfName = $('.ci_csrf_data').attr('name');  //CSRF Token name
        var csrfHash = $('.ci_csrf_data').val();
        var form = this;
        var formdata = new FormData(form);
            formdata.append(csrfName, csrfHash);
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data:formdata,
            processData:false,
            dataType: 'json',
            contentType: false,
            cache:false,
            beforeSend:function(){
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response){
                $('.ci_csrf_data').val(response.token);
                if($.isEmptyObject(response.error)){
                    if(response.status == 1){
                        $(form)[0].reset();
                        toastr.success(response.msg);
                    }else{
                        toastr.error(response.msg);
                    }
                }else{
                    $.each(response.error , function(prefix,val){
                        $(form).find('span.'+prefix+'_error').text(val);
                        toastr.error(val);
                    })
                }
            }
        });
      });


</script>
<?= $this->endSection()?>