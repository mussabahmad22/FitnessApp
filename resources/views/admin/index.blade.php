@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <section class="content">
        <!-- <div class="container-fluid">
            <h4 class="display-7 text-white font-weight-bold px-0">
                All Users
            </h4> -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5>Users List</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">

                                <div style="float: right; margin-right:50px;">
                                    <a href="{{route('userform')}}"><button type="button" class="btn btn-Success text-dark mb-0">
                                            + Add
                                            User</button></a>
                                </div>


                                <!-- BEGIN: Datatable -->
                                <div class="intro-y datatable-wrapper box p-5 mt-1">
                                    <table id="myTable"
                                        class="table table-report table-report--bordered display w-full ">
                                        <thead>
                                            <tr>
                                                <th class="border-b-2  whitespace-no-wrap">
                                                    Sr.</th>

                                                <th class="border-b-2  whitespace-no-wrap">
                                                    User Name*</th>

                                                <th class="border-b-2  whitespace-no-wrap">
                                                    User Email*</th>

                                                <th class="border-b-2  whitespace-no-wrap">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  $i = 0; ?>
                                            @foreach($users as $user)
                                            <?php $i++; ?>
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>
                                                    <?= $user->name?>
                                                </td>
                                                <td>
                                                    <?= $user->email?>
                                                </td>
                                                <td>
                                                    <a class="flex items-center text-theme-1 mr-3 btn text-info"
                                                        href="{{route('edit_user',['id' => $user->id])}}"> <img
                                                            src="{{asset('img/edit.svg')}}"> Edit </a>


                                                    <button style="border:none;" type="button" value="{{ $user->id}}"
                                                        class="deletebtn btn"><a
                                                            class="flex items-center text-theme-1 mr-3 text-danger "
                                                            data-toggle="modal" data-target="#myModal" href="">
                                                            <img src="{{asset('img/del.svg')}}"> Delete </a></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete User
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form type="submit" action="{{route('delete_user')}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                                        <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                            <input type="hidden" name="delete_user_id"
                                                                id="deleting_id"></input>
                                                            <p>Are you sure! want to Delete User?</p>
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
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

    $(document).on('click', '.deletebtn', function () {
        var user_id = $(this).val();
        $('#deleting_id').val(user_id);
    });

</script>

@endsection