@extends("la.layouts.app")

@section("contentheader_title", trans('label.roles'))
@section("contentheader_description", trans('label.roles_listing'))
@section("section", trans('label.roles'))
@section("sub_section", trans('label.listing'))
@section("htmlheader_title", trans('label.roles_listing'))

@section("headerElems")
@la_access("Roles", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ trans('label.role_add') }}</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>{{ trans('label.actions') }}</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@la_access("Roles", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{ trans('label.role_add') }}</h4>
			</div>
			{!! Form::open(['action' => 'LA\RolesController@store', 'id' => 'role-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_input($module, 'name', null, null, "form-control text-uppercase", ["placeholder" => "Role Name in CAPITAL LETTERS with '_' to JOIN e.g. 'SUPER_ADMIN'"])
					@la_input($module, 'display_name')
					@la_input($module, 'description')
					@la_input($module, 'parent')
					@la_input($module, 'dept')
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('label.close') }}</button>
				{!! Form::submit( trans('label.submit'), ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/role_dt_ajax') }}",
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "{{ trans('datatable.searchPlaceholder') }}",
            emptyTable: "{{ trans('datatable.emptyTable') }}",
            info: "{{ trans('datatable.info') }}",
            infoEmpty: "{{ trans('datatable.infoEmpty') }}",
            zeroRecords: "{{ trans('datatable.zeroRecords') }}",
            paginate: {
                first: "{{ trans('datatable.paginate.first') }}",
                last: "{{ trans('datatable.paginate.last') }}",
                next: "{{ trans('datatable.paginate.next') }}",
                previous: "{{ trans('datatable.paginate.previous') }}"
            }
        },
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#role-add-form").validate({
		
	});
});
</script>
@endpush