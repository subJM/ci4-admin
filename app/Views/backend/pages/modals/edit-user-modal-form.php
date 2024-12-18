<div class="modal fade" id="edit-category-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" data-backdrop="static">
        <form class="modal-content" action="<?= route_to('update-user')?>" method="POST" id="update_category_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    EDIT USER
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?=csrf_token()?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <input type="hidden" name="category_id">
                <div class="form-group">
                    <label>Withdraw Block(송금 차단)</label>
                    <select
                        class="user-block form-control"
                        name="user_block"
                        style="width: 100%; height: 38px"
                    >
                        <option value="NO" selected>해제</option>
                        <option value="YES">차단</option>
                    </select>
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