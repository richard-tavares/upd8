@extends('layouts.app')
@include('partials.create-city-modal')
@include('partials.update-city-modal')
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
            <form id="filters" method="GET" action="{{ route('cities.index') }}" autocomplete="off" class="row g-3">
                <div class="col-sm-12 col-md-6">
                    <label for="state" class="form-label">Estado:</label>
                    <select class="form-select state-select" id="state" name="state">
                        <option value="" selected disabled>Todos</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6">
                    <label for="name" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                    <a href="{{ route('cities.index') }}" class="btn btn-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card mb-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Cidades</h5>
        <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createModal">Cadastrar Cidade</button>
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

        getStates();

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
                url: '/api/v1/cities',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#createModal').modal('hide');
                    form[0].reset();
                    $('#table').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Cidade cadastrada com sucesso!',
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
                    url: `/api/v1/cities/${id}`,
                    method: 'GET'
                });

                $('#update_name').val(client.name);
                $('#update_state').val(client.state);
                $('#updateModal').modal('show');
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao buscar dados da cidade.'
                });
            }
        });

        $('#updateForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#update_id').val();
            const form = $(this);
            const formData = form.serialize();

            $.ajax({
                url: `/api/v1/cities/${id}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#updateModal').modal('hide');
                    form[0].reset();
                    $('#table').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Cidade atualizada com sucesso!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let message = 'Erro ao atualizar cidade.';

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
                    url: `/api/v1/cities/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Excluído!',
                            text: 'Cidade foi excluída com sucesso.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#table').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        let message = 'Erro ao excluir a cidade.';

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

    async function getStates() {
        const stateSelect = $('#state');

        if (stateSelect.children('option').length > 1) {
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
        } catch (error) {
            console.error('Erro ao carregar estados.', error);
        }
    }

    function initializeDataTable() {
        $('#table').DataTable({
            ajax: {
                url: '/api/v1/cities',
                data: function(d) {
                    d.name = $('#name').val();
                    d.state = $('#state').val();
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
                    title: 'Cidade',
                    data: 'name',
                    className: 'text-center'
                },
                {
                    title: 'Estado',
                    data: 'state',
                    className: 'text-center'
                },
            ],
            responsive: true,
            searching: false,
            lengthChange: false,
            info: false
        });
    }
</script>
@endpush
