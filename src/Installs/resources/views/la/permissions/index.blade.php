@extends("la.layouts.app")

@section("contentheader_title", trans('label.permissions'))
@section("contentheader_description", trans('label.permissions_listing'))
@section("section", trans('label.permissions'))
@section("sub_section", trans('label.listing'))
@section("htmlheader_title", trans('label.permissions_listing'))

@section("headerElems")
@la_access("Permissions", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ trans('label.permission_add') }}</button>
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

@la_access("Permissions", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{ trans('label.permission_add') }}</h4>
			</div>
			{!! Form::open(['action' => 'LA\PermissionsController@store', 'id' => 'permission-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'display_name')
					@la_input($module, 'description')
					--}}
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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/permission_dt_ajax') }}",
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
	$("#permission-add-form").validate({
		
	});
});
</script>
@endpush
