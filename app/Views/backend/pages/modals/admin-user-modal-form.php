<div class="modal fade" id="admin-user-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" data-backdrop="static">
        <form class="modal-content" action="<?= route_to('add-admin-user')?>" method="POST" id="add_admin_user_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Large modal
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?=csrf_token()?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <div class="form-group">
                    <label for=""><b>User ID</b></label>
                    <input type="text" name="user_id" class="form-control user_id" placeholder="Enter User ID">
                    <span class="text-danger error-text category_name_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>User Name</b></label>
                    <input type="text" name="user_name" class="form-control user_name" placeholder="Enter User Name">
                    <span class="text-danger error-text category_name_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>User Email</b></label>
                    <input type="text" name="email" class="form-control email" placeholder="Enter User Email">
                    <span class="text-danger error-text category_name_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>User Password</b></label>
                    <input type="password" name="password" class="form-control password" placeholder="Enter User Password">
                    <span class="text-danger error-text category_name_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary action">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>