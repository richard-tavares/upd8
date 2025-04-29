<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Cadastrar Representante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="row g-3">
                        <div class="col-md-12 col-lg-6">
                            <label for="create_name" class="form-label">Nome:</label>
                            <input type="text" class="form-control" id="create_name" name="name" required>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="create_cpf" class="form-label">CPF:</label>
                            <input type="text" class="form-control" id="create_cpf" name="cpf" required>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="create_birth_date" class="form-label">Data de Nascimento:</label>
                            <input type="date" class="form-control" id="create_birth_date" name="birth_date" required>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="create_gender" class="form-label">Gênero:</label>
                            <select class="form-select" id="create_gender" name="gender" required>
                                <option value="" selected disabled>Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <label for="create_state" class="form-label">Estado:</label>
                            <select id="create_state" name="state" class="form-select state-select" required>
                                <option value="" selected disabled>Selecione</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="create_city" class="form-label">Cidade:</label>
                            <select id="create_city" name="city_id" class="form-select" disabled required>
                                <option value="" selected disabled>Selecione o estado</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="createForm" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
