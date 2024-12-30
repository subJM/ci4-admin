<div class="modal fade" id="edit-admin-user-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" data-backdrop="static">
        <form class="modal-content" action="<?= route_to('change-admin-password')?>" method="POST" id="update_admin_user_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Edit Admin
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?=csrf_token()?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <input type="hidden" name="category_id">
                <div class="form-group">
                    <label for=""><b>Current Password</b></label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter Current Password">
                    <span class="text-danger error-text current_password_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>New Password</b></label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter Change Password">
                    <span class="text-danger error-text new_password_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>Confirm New Password</b></label>
                    <input type="password" name="confirm_new_password" class="form-control" placeholder="Enter Change Password">
                    <span class="text-danger error-text confirm_new_password_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary action">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>