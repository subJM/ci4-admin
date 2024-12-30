<div class="modal fade" id="edit-user-password-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" data-backdrop="static">
        <form class="modal-content" action="<?= route_to('send-password-reset-link')?>" method="POST" id="change_user_password_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    비밀번호 초기화
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?=csrf_token()?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <input type="text" name="email" id="auth_email" style="border:#c7c7c7 1px solid; border-radius: 5px; text-align: center;" readonly>로 인증메일이 발송됩니다
                <input type="hidden" name="category_id">
                <div>
                    비밀번호를 초기화 하시겠습니까?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary action">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>