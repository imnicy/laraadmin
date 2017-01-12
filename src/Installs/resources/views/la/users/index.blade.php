@extends("la.layouts.app")

@section("contentheader_title", trans('label.users'))
@section("contentheader_description", trans('label.users_listing'))
@section("section", trans('label.users'))
@section("sub_section", trans('label.listing'))
@section("htmlheader_title", trans('label.users_listing'))

@section("headerElems")

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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/user_dt_ajax') }}",
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
    $("#user-add-form").validate({
        
    });
});
</script>
@endpush
