@extends($master_template)

@section('content')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                {{ strtoupper($title_header) }}
            </h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-primary font-weight-bold btn-square add-user-btn">
                <i class="fa fa-plus"></i> ADD NEW USER
            </button>
        </div>
    </div>
    <div class="card-body">
        <table id="user-table"></table>
    </div>
</div>

<form id="user-create-form">
    <div id="user-create-modal" class="modal fade" tabindex="-1" aria-labelledby="user-create-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white" id="user-create-modalLabel">ADD NEW USER</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="" placeholder="enter name">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" placeholder="enter email">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="" placeholder="enter password">
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-control col-12" name="role_id" required>
                            <option selected value="">Choose...</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold btn-square" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold btn-square">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="user-edit-form">
    <div id="user-edit-modal" class="modal fade" tabindex="-1" aria-labelledby="user-edit-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white" id="user-edit-modalLabel">EDIT USER
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" />
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="" placeholder="enter name" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" placeholder="enter email" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select class="form-control col-12" name="role_id" required>
                            <option selected value="">Choose...</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold btn-square" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold btn-square">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
    $(function() {
        var $table = $('#user-table');
        var $modalCreate = $('#user-create-modal');
        var $modalEdit = $('#user-edit-modal');

        var $formCreate = new FormService($('#user-create-form'));
        var $formEdit = new FormService($('#user-edit-form'));

        var $http = new HttpService();

        var $httpCreate = new HttpService({
            formService: $formCreate,
            bootrapTable: $table,
            bootrapModal: $modalCreate,
        });

        var $httpEdit = new HttpService({
            formService: $formEdit,
            bootrapTable: $table,
            bootrapModal: $modalEdit,
        });

        $table.bootstrapTable({
            sortName: 'name',
            sortOrder: 'asc',
            url: HelperService.base_url + '/api/admin/users',
            columns: [{
                    title: 'NO',
                    sortable: true,
                    formatter: function(value, row, index) {
                        return index + 1;
                    }
                },
                {
                    title: 'NAME',
                    field: 'name',
                    sortable: true,
                    formatter: function(value, row, index) {
                        return value;
                    }
                },
                {
                    title: 'EMAIL',
                    field: 'email',
                    sortable: true,
                },
                {
                    title: 'ACTION',
                    formatter: function(value, row, index) {
                        var link = '';
                        link += '<button type="button" class="btn btn-sm btn-warning font-weight-bold btn-square mr-2 edit">';
                        link += '<i class="fa fa-pencil-alt"></i> EDIT';
                        link += '</button>';
                        link += '<button type="button" class="btn btn-sm btn-danger font-weight-bold btn-square mr-2 delete">';
                        link += '<i class="fa fa-trash-alt"></i> DELETE';
                        link += '</button>';
                        return link;
                    },
                    events: {
                        'click .edit': function(e, value, row) {
                            $formEdit.emptyFormData();
                            $modalEdit.modal('show')
                            $formEdit.setFormData({
                                id: row.id,
                                name: row.name,
                                email: row.email,
                                role_id: row.roles[0].id,
                            });
                        },
                        'click .delete': function(e, value, row) {
                            HelperService.confirm(function() {
                                $http.delete(`/api/admin/users/${row.id}/delete`)
                                    .then(function(resp) {
                                        $table.bootstrapTable('refresh');
                                    })
                            })
                        }
                    }
                },
            ]
        });

        $('.add-user-btn').click(function() {
            $formCreate.emptyFormData();
            $modalCreate.modal('show')
        });

        $formCreate.onSubmit(function(data) {
            $httpCreate.post('/api/admin/users', data);
        });

        $formEdit.onSubmit(function(data) {
            $httpEdit.put(`/api/admin/users/${data.id}/update`, data)
        });
    })
</script>
@endsection