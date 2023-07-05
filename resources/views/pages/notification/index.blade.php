@extends('layout.master')
@section('content')
@section('title',"Notification")
@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Notification</li>
    </ol>
</nav>

<!-- add_notification_modal -->
<div class="modal fade  bd-example-modal-lg" id="notification_modal" tabindex="-1"
    aria-labelledby="title_notification_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_notification_modal">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" method="POST" name="notification_form" id="notification_form">
                    @csrf
                    <div>
                    <input type="hidden" name="notification_id" class="notification_id" value="{{ encryptid('0') }}">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control title" id="title" name="title" placeholder="Enter Title">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="2" cols="4">
                        </textarea>
                       
                    </div>
                    <button class="btn btn-primary submit_notification" type="button"></button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- End add_notification_modal -->


<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Notification</h6>
                <div class="heading-elements text-end" style="margin-bottom: 12px;">
                @if($auth_id == 1)
                    <a class="btn btn-primary add_notification" data-id="{{ encryptid('0') }}">Add <i class="fa fa-plus"
                            aria-hidden="true"></i></a>
                    <a class="btn btn-danger delete_all" id="delete_selected">Delete<i class="fa fa-trash position-left" aria-hidden="true"></i></a>
              @endif
                </div>
                <div class="table-responsive">
                    <table id="notification_tbl" class="table" style="width: 98% !important;">
                        <thead>
                            <tr>
                                <th width="20px"><input type="checkbox" name="select_all" id="select_all" class="styled " onclick="select_all(this);"  ></th>
                                <th>Title</th>
                                <th>Message</th>
				                <th width="200px">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/common/custom.js') }}"></script>
<script src="{{ asset('assets/js/notification/notification.js') }}"></script>
@endpush