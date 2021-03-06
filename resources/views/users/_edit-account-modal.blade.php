<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title font-weight-bold text-white" id="editAccountModalLabel">
          <i class="fas fa-user-plus fa-fw mr-1"></i>Cadastrar novo usuário
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        @include('users._form', ['method' => 'PATCH'])
      </div>
    </div>
  </div>
</div>