@extends('layouts.master')

@section('title', 'Create Company')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="row">
        <div class="col-12">

            <div class="page-title-box d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Create Company
                </h4>

                <a href="{{ route('admin.companies.index') }}" class="btn btn-primary">

                    <i class="fas fa-arrow-left"></i>
                    Back

                </a>

            </div>

        </div>
    </div>

    <form id="createFrm" enctype="multipart/form-data">

        @csrf

        <div class="row">

            {{-- LEFT --}}
            <div class="col-lg-8">

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title mb-0">
                            Company Information
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- COMPANY NAME --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Company Name

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="name" class="form-control" placeholder="Enter Company Name">

                            </div>

                            {{-- USERNAME --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Username

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="username" class="form-control" placeholder="Enter Username">

                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Email

                                </label>

                                <input type="email" name="email" class="form-control" placeholder="Enter Email">

                            </div>

                            {{-- MOBILE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Mobile

                                </label>

                                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile">

                            </div>

                            {{-- WEBSITE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Website

                                </label>

                                <input type="text" name="website" class="form-control" placeholder="https://example.com">

                            </div>

                            {{-- PINCODE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Pincode

                                </label>

                                <input type="text" name="pincode" class="form-control" placeholder="Enter Pincode">

                            </div>

                            {{-- CITY --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    City

                                </label>

                                <input type="text" name="city" class="form-control" placeholder="Enter City">

                            </div>

                            {{-- STATE --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    State

                                </label>

                                <input type="text" name="state" class="form-control" placeholder="Enter State">

                            </div>

                            {{-- COUNTRY --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label fw-bold">

                                    Country

                                </label>

                                <input type="text" name="country" value="India" class="form-control">

                            </div>

                            {{-- ADDRESS --}}
                            <div class="col-12 mb-3">

                                <label class="form-label fw-bold">

                                    Address

                                </label>

                                <textarea name="address" rows="4" class="form-control" placeholder="Enter Address"></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- LOGIN DETAILS --}}
                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title mb-0">
                            Login Details
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- PASSWORD --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Password

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="password" name="password" class="form-control" placeholder="Enter Password">

                            </div>

                            {{-- CONFIRM PASSWORD --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Confirm Password

                                    <span class="text-danger">*</span>

                                </label>

                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirm Password">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-lg-4">

                {{-- STATUS --}}
                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title mb-0">
                            Company Status
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <label class="fw-bold mb-0">
                                Status
                            </label>

                            <input type="hidden" name="status" value="0">

                            <div class="square-switch">

                                <input type="checkbox" id="switch-status" name="status" switch="status" value="1"
                                    checked>

                                <label for="switch-status" data-on-label="Yes" data-off-label="No">
                                </label>

                            </div>

                        </div>

                        <div class="d-grid gap-2">

                            <button type="button" id="createBtn" class="btn btn-success">

                                Save Company

                            </button>

                            <button type="reset" class="btn btn-warning">

                                Clear

                            </button>

                        </div>

                    </div>

                </div>

                {{-- LOGO --}}
                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title mb-0">
                            Company Logo
                        </h4>

                    </div>

                    <div class="card-body">

                        <input type="file" name="logo" class="dropify" accept="image/*">

                        <small class="text-muted">

                            <b>Recommended :</b>

                            300 x 300 PNG/JPG

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@section('script')

    <script>
        $(document).ready(function() {

            $('#createBtn').click(function(e) {

                e.preventDefault();

                let btn = $(this);

                let formData = new FormData($('#createFrm')[0]);

                $.ajax({

                    url: "{{ route('admin.companies.create') }}",

                    type: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    cache: false,

                    beforeSend: function() {

                        btn.prop('disabled', true);

                        btn.html(`
                        <span class="spinner-border spinner-border-sm"></span>
                        Saving...
                    `);

                    },

                    success: function(response) {

                        showToastr(
                            'success',
                            response.message
                        );

                        setTimeout(function() {

                            window.location.href =
                                "{{ route('admin.companies.index') }}";

                        }, 500);

                    },

                    error: function(xhr) {

                        let message = 'Something went wrong.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message = xhr.responseJSON.message;

                        }

                        showToastr(
                            'error',
                            message
                        );

                    },

                    complete: function() {

                        btn.prop('disabled', false);

                        btn.html('Save Company');

                    }

                });

            });

        });
    </script>

@endsection
