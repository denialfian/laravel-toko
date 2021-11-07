@extends($master_template)

@section('content')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                {{ strtoupper($title_header) }}
            </h3>
        </div>
    </div>
    <div class="card-body">
        <form id="form-role">
            <input type="hidden" value="{{ $role->id }}" name="id" id="role-input-id">
            <div class="mb-3">
                <label>ROLE NAME</label>
                <input type="text" class="form-control" name="name" value="{{ $role->name }}" required>
            </div>
            <div class="mb-3">
                <label>PERMISSION NAME</label>
                <br>
                <table class="table">
                    @foreach($permissions as $group => $permission)
                    <tr>
                        <th>{{ $group }}</th>
                    </tr>
                    <tr>
                        @foreach($permission as $p)
                        <td>
                            <input type="checkbox" class="form-check-input" name="permission_id" value="{{ $p['id'] }}" id="permission-id-{{ $p['id'] }}" {{ $p["checked"] }}>
                            <label class="form-check-label" for="permission-id-{{ $p['id'] }}">{{ $p['name'] }}</label>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </table>
            </div>
            <button type="submit" class="btn btn-sm btn-primary font-weight-bold btn-square"> <i class="fa fa-plus"></i> SAVE</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function() {
        var $form = new FormService($('#form-role')).withArrayField(['permission_id']);
        var $http = new HttpService({
            formService: $form,
        });

        $form.onSubmit(function(data) {
            $http.put(`/api/admin/roles/${data.id}/update`, data).then(function(resp) {
                HelperService.redirect('/admin/roles');
            })
        })
    })
</script>
@endsection