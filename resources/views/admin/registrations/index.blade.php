@extends('layouts.master')

@section('title', 'Visitor Registrations')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="row">
        <div class="col-12">

            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                <h4 class="mb-sm-0 font-size-18">
                    Visitor Registrations
                </h4>

                <div class="page-title-right">

                    <a href="{{ route('registration.create') }}" target="_blank" class="btn btn-soft-info">

                        <i class="fas fa-plus"></i>
                        Create

                    </a>

                </div>

            </div>

        </div>
    </div>

    {{-- FILTER --}}
    <div class="row">
        <div class="col-12">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="card-title mb-0">
                        Filter
                    </h4>

                    <button id="reset-filter" class="btn btn-light">

                        <i class="fa fa-undo"></i>
                        Reset

                    </button>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Search
                            </label>

                            <input type="text" id="search" class="form-control"
                                placeholder="Registration No / Name / Company / Email">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Status
                            </label>

                            <select id="status" class="form-control select2-class2" data-placeholder="Choose Status">

                                <option value=""></option>

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="row">
        <div class="col-12">

            <div class="card border">

                <div class="card-body">

                    <table id="data-table" class="table table-bordered dt-responsive nowrap w-100">

                        <thead>

                            <tr>

                                <th>Registration No</th>

                                <th>Name</th>

                                <th>Company</th>

                                <th>Phone</th>

                                <th>Email</th>

                                <th class="text-center">
                                    Status
                                </th>

                                <th class="text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

@endsection

@section('script')

    <script>
        $(function() {

            let table = $('#data-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: {

                    url: "{{ route('admin.registrations.list') }}",

                    data: function(d) {

                        d.search = $('#search').val();

                        d.status = $('#status').val();

                    }

                },

                columns: [

                    {
                        data: 'registration_no',
                        name: 'registration_no',
                    },

                    {
                        data: 'full_name',
                        name: 'full_name',
                    },

                    {
                        data: 'company_name',
                        name: 'company_name',
                    },

                    {
                        data: 'phone',
                        name: 'phone',
                    },

                    {
                        data: 'email',
                        name: 'email',
                    },

                    {
                        data: null,
                        name: 'status',
                        className: 'text-center',

                        mRender: function(data, type, row) {

                            return `
                        <div class="square-switch">

                            <input type="checkbox"
                                   id="status-switch-${row.id}"
                                   class="change-status"
                                   switch="status"
                                   data-id="${row.id}"
                                   ${row.status == 1 ? 'checked' : ''}>

                            <label for="status-switch-${row.id}"
                                   data-on-label="Yes"
                                   data-off-label="No">
                            </label>

                        </div>
                    `;

                        }

                    },

                    {
                        data: null,

                        orderable: false,

                        searchable: false,

                        className: 'text-center',

                        render: function(data, type, row) {

                            let viewUrl = "{{ route('admin.registrations.view', ':id') }}"
                                .replace(':id', row.id);

                            let editUrl = "{{ route('admin.registrations.update.index', ':id') }}"
                                .replace(':id', row.id);

                            let deleteUrl = "{{ route('admin.registrations.delete', ':id') }}"
                                .replace(':id', row.id);

                            return `
                                <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">

                                    <a href="${viewUrl}"
                                    class="btn btn-primary btn-sm waves-effect waves-light">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <a href="${editUrl}"
                                    class="btn btn-soft-info btn-sm waves-effect waves-light">

                                        <i class="bx bx-pencil"></i>

                                    </a>

                                    <button type="button"
                                            class="btn btn-soft-danger btn-sm waves-effect waves-light delete-entry"
                                            data-href="${deleteUrl}">

                                        <i class="bx bx-trash"></i>

                                    </button>

                                </div>
                            `;
                        }
                    }

                ]

            });

            $(document).on('keyup', '#search', function() {

                table.ajax.reload();

            });

            $('#status').change(function() {

                table.ajax.reload();

            });

            $('#reset-filter').click(function() {

                $('#search').val('');

                $('#status')
                    .val('')
                    .trigger('change');

                table.ajax.reload();

            });

            $(document).on('change', '.change-status', function() {

                let checkbox = $(this);

                let id = checkbox.data('id');

                checkbox.prop('disabled', true);

                let statusUrl = "{{ route('admin.registrations.change.status', ':id') }}"
                    .replace(':id', id);

                $.get(statusUrl)

                    .done(function() {

                        table.ajax.reload(null, false);

                    })

                    .fail(function() {

                        checkbox.prop('checked', !checkbox.prop('checked'));

                    })

                    .always(function() {

                        checkbox.prop('disabled', false);

                    });

            });

        });
    </script>

@endsection
