@extends('layouts.app')
@include('partials.create-client-modal')
@include('partials.update-client-modal')
@section('content')
<div class="card mb-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Filtros</h5>
        <button id="btn-toggle-filtros" class="btn btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiltros" aria-expanded="true" aria-controls="collapseFiltros">
            <i class="bi bi-chevron-up"></i>
        </button>
    </div>

    <div id="collapseFiltros" class="collapse show">
        <div class="card-body">
            <form id="filters" method="GET" action="{{ route('clients.index') }}" autocomplete="off" class="row g-3">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" value="{{ request('cpf') }}">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <label for="name" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <label for="birth_date" class="form-label">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ request('birth_date') }}">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <span class="form-label d-block">Gênero:</span>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="gender_m" name="gender" value="M" {{ request('gender') == 'M' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_m">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="gender_f" name="gender" value="F" {{ request('gender') == 'F' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gender_f">Feminino</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <label for="state" class="form-label">Estado:</label>
                    <select class="form-select state-select" id="state" name="state">
                        <option value="" selected disabled>Todos</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <label for="city" class="form-label">Cidade:</label>
                    <select class="form-select" id="city" name="city" disabled>
                        <option value="" selected disabled>Todas</option>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card mb-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Clientes</h5>
        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createModal">Cadastrar Cliente</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped w-100"></table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#collapseFiltros').on('show.bs.collapse', function() {
            $('#btn-toggle-filtros i').removeClass('bi-chevron-down').addClass('bi-chevron-up');
        });

        $('#collapseFiltros').on('hide.bs.collapse', function() {
            $('#btn-toggle-filtros i').removeClass('bi-chevron-up').addClass('bi-chevron-down');
        });

        $('#cpf, #create_cpf, #update_cpf').mask('000.000.000-00');

        $(document).on('hidden.bs.modal', '.modal', function() {
            $(this).find('form').each(function() {
                this.reset();
            });
        });

        getStatesFromClients();

        $('#state').on('change', function() {
            getCitiesByState($(this).val());
        });

        $('#filters').on('submit', function(e) {
            e.preventDefault();
            $('#table').DataTable().ajax.reload();
        });

        initializeDataTable();

        $('#createModal').on('show.bs.modal', function() {
            getStates('#create_state');
        });

        $(document).on('change', '#create_state', function() {
            getCitiesByState('#create_state', '#create_city');
        });

        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();

            $.ajax({
                url: '/api/v1/clients',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#createModal').modal('hide');
                    form[0].reset();
                    $('#table').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente cadastrado com sucesso!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let message = 'Erro ao cadastrar cliente.';

                    if (xhr.responseJSON?.errors) {
                        message = '<ul class="text-start">';
                        Object.values(xhr.responseJSON.errors).forEach(function(errorArray) {
                            errorArray.forEach(function(error) {
                                message += `<li>${error}</li>`;
                            });
                        });
                        message += '</ul>';
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: message
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', async function() {
            const id = $(this).data('id');

            $('#update_id').val(id);

            try {
                const client = await $.ajax({
                    url: `/api/v1/clients/${id}`,
                    method: 'GET'
                });

                $('#update_name').val(client.name);
                $('#update_cpf').val(client.cpf);
                $('#update_birth_date').val(client.birth_date);
                $('#update_gender').val(client.gender);
                $('#update_address').val(client.address);

                await getStates('#update_state', client.state);

                await getCitiesByState('#update_state', '#update_city', client.city_id);

                $('#updateClientModal').modal('show');

            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao buscar dados do cliente.'
                });
            }
        });

        $(document).on('change', '.state-select', function() {
            const stateSelectId = `#${$(this).attr('id')}`;
            const citySelectId = stateSelectId.replace('state', 'city');

            getCitiesByState(stateSelectId, citySelectId);
        });

        $('#updateClientForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#update_id').val();
            const form = $(this);
            const formData = form.serialize();

            $.ajax({
                url: `/api/v1/clients/${id}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#updateClientModal').modal('hide');
                    form[0].reset();
                    $('#table').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente atualizado com sucesso!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let message = 'Erro ao atualizar cliente.';

                    if (xhr.responseJSON?.errors) {
                        message = '<ul class="text-start">';
                        Object.values(xhr.responseJSON.errors).forEach(function(errorArray) {
                            errorArray.forEach(function(error) {
                                message += `<li>${error}</li>`;
                            });
                        });
                        message += '</ul>';
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        html: message
                    });
                }
            });
        });
    });

    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Tem certeza?',
            text: 'Essa ação não poderá ser desfeita!',
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Excluindo...',
                    text: 'Por favor, aguarde.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `/api/v1/clients/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Excluído!',
                            text: 'O cliente foi excluído com sucesso.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#table').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        let message = 'Erro ao excluir o cliente.';

                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: message
                        });
                    }
                });
            }
        });
    });

    function getStatesFromClients() {
        $.ajax({
            url: '/api/v1/clients/get-states-from-clients',
            method: 'GET',
            success: function(states) {
                const stateSelect = $('#state');
                states.forEach(function(state) {
                    const option = $('<option>', {
                        value: state,
                        text: state
                    });
                    stateSelect.append(option);
                });

                if ("{{ request('state') }}") {
                    $('#state').val("{{ request('state') }}").trigger('change');
                }
            },
            error: function() {
                console.error('Erro ao carregar estados para filtros.');
            }
        });
    }

    async function getStates(selectId, selectedValue = null) {
        const stateSelect = $(selectId);

        if (stateSelect.children('option').length > 1) {
            if (selectedValue) {
                stateSelect.val(selectedValue);
            }
            return;
        }

        try {
            const response = await $.ajax({
                url: '/api/v1/cities/get-states',
                method: 'GET'
            });

            response.forEach(function(state) {
                const option = $('<option>', {
                    value: state,
                    text: state
                });
                stateSelect.append(option);
            });

            if (selectedValue) {
                stateSelect.val(selectedValue);
            }
        } catch (error) {
            console.error('Erro ao carregar estados.', error);
        }
    }

    async function getCitiesByState(stateSelectId, citySelectId, selectedCityId = null) {
        const state = $(stateSelectId).val();
        const citySelect = $(citySelectId);

        if (!state) {
            citySelect.html('<option>Selecione o estado primeiro</option>').prop('disabled', true);
            return;
        }

        citySelect.prop('disabled', true).html('<option>Carregando cidades...</option>');

        try {
            const response = await $.ajax({
                url: `/api/v1/cities/get-cities-by-state/${state}`,
                method: 'GET'
            });

            citySelect.empty().append('<option value="">Selecione a cidade</option>');

            response.forEach(function(city) {
                citySelect.append(`<option value="${city.id}">${city.name}</option>`);
            });

            citySelect.prop('disabled', false);

            if (selectedCityId) {
                citySelect.val(selectedCityId);
            }
        } catch (error) {
            console.error('Erro ao carregar cidades.', error);
            citySelect.html('<option>Erro ao carregar cidades</option>').prop('disabled', true);
        }
    }

    function initializeDataTable() {
        $('#table').DataTable({
            ajax: {
                url: '/api/v1/clients',
                data: function(d) {
                    d.cpf = $('#cpf').val();
                    d.name = $('#name').val();
                    d.birth_date = $('#birth_date').val();
                    d.gender = $('input[name="gender"]:checked').val();
                    d.state = $('#state').val();
                    d.city = $('#city').val();
                },
                dataSrc: ''
            },
            language: {
                paginate: {
                    previous: "Anterior",
                    next: "Próximo"
                }
            },
            order: [
                [2, 'asc']
            ],
            columns: [{
                    title: 'Editar',
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<button class="btn btn-warning btn-sm btn-edit" data-id="${row.id}" type="button">Editar</button>`;
                    }
                },
                {
                    title: 'Excluir',
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Excluir</button>`;
                    }
                },
                {
                    title: 'Nome',
                    data: 'name',
                    className: 'text-center'
                },
                {
                    title: 'CPF',
                    data: 'cpf',
                    className: 'text-center'
                },
                {
                    title: 'Data de Nascimento',
                    data: 'birth_date',
                    className: 'text-center',
                    render: function(data) {
                        return Utils.formatDateBr(data);
                    }
                },
                {
                    title: 'Estado',
                    data: 'state',
                    className: 'text-center'
                },
                {
                    title: 'Cidade',
                    data: 'city',
                    className: 'text-center'
                },
                {
                    title: 'Gênero',
                    data: 'gender',
                    className: 'text-center'
                }
            ],
            responsive: true,
            searching: false,
            lengthChange: false,
            info: false
        });
    }
</script>
@endpush
