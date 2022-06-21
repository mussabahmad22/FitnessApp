@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Bookings of session</h5>
                        </div>
                        <div class="card-header pb-0">
                            <form action="{{url('booking_export')}}" method="GET">
                                <div class="row">

                                    <div class="col-3">

                                        <div class=" mb-3">
                                            <label class="input-group ">Start Date*</label>
                                            <input type="date" class="form-control" name="start_date">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class=" mb-3">
                                            <label class="input-group">End Date*</label>
                                            <input type="date" class="form-control" name="end_date">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group-append mt-4">
                                            <!-- <div style="float: right; margin-right:50px;"> -->
                                            <button class="btn btn-outline-dark mb-0" type="submit">+ Export
                                                Data</button>
                                            <!-- </div> -->
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div class="intro-y datatable-wrapper box p-5 mt-1">
                                    <table id="exercisetbl"
                                        class="table table-report  table-report--bordered display w-full">
                                        <thead>
                                            <tr>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Sr.</th>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Username</th>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Email</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Phone </th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Type Session </th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Date </th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  $i = 0; ?>
                                            @foreach($booking as $book)
                                            <?php $i++; ?>

                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>
                                                    <?= $book->user_name?>
                                                </td>
                                                <td>
                                                    <?= $book->user_email?>
                                                </td>
                                                <td>
                                                    <?= $book->phone?>
                                                </td>
                                                <td>
                                                    <?= $book->class_type?>
                                                </td>
                                                <td>
                                                    <?= $book->created_at->format('d-m-Y')?>
                                                </td>

                                                <td>
                                                    <button style="border:none;" type="button" value="{{$book->id}}"
                                                        class="deletebtn btn"><a
                                                            class="flex items-center text-theme-1 mr-3  text-danger "
                                                            data-toggle="modal" data-target="#myModal" href=""> <img
                                                                src="{{asset('img/del.svg')}}">
                                                            Delete </a>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- //======================Delete Booking Modal================================= -->
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete booking Details
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form type="submit" action="{{route('booking_delete')}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                                <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                    <input type="hidden" name="delete_booking_id"
                                                        id="deleting_id"></input>
                                                    <p>Are you sure! want to Delete User's Details?</p>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class="flex items-center text-theme-1 mr-3 btn text-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit"
                                            class="flex items-center text-theme-1 mr-3 btn text-danger">Delete</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#exercisetbl').DataTable();
    });

    $(document).on('click', '.deletebtn', function () {
        var query_id = $(this).val();
        $('#deleteModal').modal('show');
        $('#deleting_id').val(query_id);
    });
</script>

@endsection