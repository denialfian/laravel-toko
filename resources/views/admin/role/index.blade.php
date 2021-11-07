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
            <a href="{{ url('/admin/roles/create') }}" class="btn btn-sm btn-primary font-weight-bold btn-square"><i class="fa fa-plus"></i> ADD NEW ROLE</a>
        </div>
    </div>
    <div class="card-body">
        <table id="role-table"></table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function() {
        var $table = $('#role-table');
        var $http = new HttpService({
            bootrapTable: $table,
        });

        $table.bootstrapTable({
            sortName: 'name',
            sortOrder: 'ASC',
            url: HelperService.base_url + '/api/admin/roles',
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
                            HelperService.redirect(`/admin/roles/${row.id}/edit`)
                        },
                        'click .delete': function(e, value, row) {
                            $http.delete(`/api/admin/roles/${row.id}/delete`)
                        }
                    }
                },
            ]
        });
    })
</script>
@endsection