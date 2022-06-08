@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Ratings</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <!-- <div style="float: right; margin-right:50px;">
                                    <button type="button" class="btn btn-dark" data-toggle="modal"
                                        data-target="#exampleModal">+ Add
                                        Licence</button>
                                </div> -->
                                <!-- BEGIN: Datatable -->
                                <div class="intro-y datatable-wrapper box p-5 mt-1">
                                    <table id="exercisetbl"
                                        class="table table-report  table-report--bordered display w-full">
                                        <thead>
                                            <tr>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Sr.</th>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    User Name</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Ratings</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Comment</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <th scope="row">1</th>
                                                <td>
                                                    Mussab
                                                </td>
                                                <td>
                                                    5 star
                                                </td>
                                                <td>
                                                    Excellent
                                                </td>
                                                <td>
                                                    <button style="border:none;" type="button" value=""
                                                        class="deletebtn btn"><a
                                                            class="flex items-center text-theme-1 mr-3  text-danger "
                                                            data-toggle="modal" data-target="#myModal" href=""> <img
                                                                src="{{asset('img/del.svg')}}">
                                                            Delete </a>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
</script>

@endsection