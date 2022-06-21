@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Licence</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div style="float: right; margin-right:50px;">
                                    <button type="button" class="btn btn-Success text-dark mb-0" data-toggle="modal"
                                        data-target="#exampleModal">+ Add
                                        Licence</button>
                                </div>
                                <!-- BEGIN: Datatable -->
                                <div class="intro-y datatable-wrapper box p-5 mt-1">
                                    <table id="exercisetbl"
                                        class="table table-report  table-report--bordered display w-full">
                                        <thead>
                                            <tr>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Sr.</th>
                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    licence ID</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Start Date</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    End Date</th>

                                                <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  $i = 0; ?>
                                            @foreach($licences as $licence)
                                            <?php $i++; ?>
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>
                                                    {{ $licence->licence_key }}
                                                </td>
                                                <td>
                                                    <?= $licence->start_date_time ?>
                                                </td>
                                                <td>
                                                    <?= $licence->end_date_time ?>
                                                </td>
                                                <td>
                                                    <button style="border:none;" type="button" value="{{$licence->id}}"
                                                        class="editbtn btn"><a
                                                            class="flex items-center text-theme-1 mr-3 text-info "
                                                            data-toggle="modal" data-target="#myModal1" href=""><img
                                                                src="{{asset('img/edit.svg')}}">
                                                            Edit </a></button>

                                                    <button style="border:none;" type="button" value="{{$licence->id}}"
                                                        class="deletebtn btn"><a
                                                            class="flex items-center text-theme-1 mr-3  text-danger "
                                                            data-toggle="modal" data-target="#myModal" href=""> <img
                                                                src="{{asset('img/del.svg')}}">
                                                            Delete </a></button>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                                <!-- //======================Delete licence Modal================================= -->
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Licence
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form type="submit" action="{{route('licence_delete')}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                                        <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                            <input type="hidden" name="delete_exercise_id"
                                                                id="deleting_id"></input>
                                                            <p>Are you sure! want to Delete Licence?</p>
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

                                <!-- ==============================ADD licence Modal============================================ -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Licence*</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form type="submit" action="{{route('add_licence')}}" method="post">
                                                    @csrf
                                                    <div class="intro-y col-span-12 lg:col-span-8 p-5">

                                                        <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                            
                                                            <label class="input-group mb-3">licence ID*</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control "
                                                                    name="licence_id" id="licence_id" required>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-dark mb-0"
                                                                        type="button" onclick="gfg();">Generate
                                                                        ID</button>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger">
                                                                @error('licence_id')
                                                                {{$message}}
                                                                @enderror
                                                            </span>
                                                            <div class="mb-3 ">
                                                                <label class="form-label">Start Date :</label>
                                                                <input type="date" class="form-control" id="start_date"
                                                                    name="start_date" required>
                                                                <span class="text-danger">
                                                                    @error('start_date')
                                                                    {{$message}}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">End Date :</label>
                                                                <input type="date" class="form-control" id="end_date"
                                                                    name="end_date" required>
                                                                <span class="text-danger">
                                                                    @error('end_date')
                                                                    {{$message}}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-dark">Save changes</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- ======================== Update licence Modal==================================== -->
                                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabe3" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabe3">Update Licence</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form type="submit" action="{{route('licence_update')}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                                        <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                            <input type="hidden" name="query_id" id="query_id"></input>
                                                            <div class="mb-3">
                                                                <label class="form-label">licence ID*</label>
                                                                <input type="text" class="form-control"
                                                                    name="licence_id" id="licence_id1">
                                                                <span class="text-danger">
                                                                    @error('licence_id')
                                                                    {{$message}}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                            <div class="mb-3 ">
                                                                <label class="form-label">Start Date :</label>
                                                                <input type="date" class="form-control" id="start_date1"
                                                                    name="start_date">
                                                                <span class="text-danger">
                                                                    @error('start_date')
                                                                    {{$message}}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">End Date :</label>
                                                                <input type="date" class="form-control" id="end_date1"
                                                                    name="end_date">
                                                                <span class="text-danger">
                                                                    @error('end_date')
                                                                    {{$message}}
                                                                    @enderror
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-dark">Update</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- ======================== End Update Exercise Modal==================================== -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var up = document.getElementById('GFG_UP');
    var down = document.getElementById('num');

    function gfg() {
        var minm = 1000000;
        var maxm = 9999999;
        $random = Math.floor(Math
            .random() * (maxm - minm + 1)) + minm;
        $('#licence_id').val($random);
    }
</script>
<script>
    $(document).ready(function () {

        //===================Script For Edit Exercise ====================================
        $(document).on('click', '.editbtn', function () {
            var query_id = $(this).val();
            console.log(query_id);


            $.ajax({
                type: "GET",
                url: "edit_licence/" + query_id,
                success: function (response) {
                    console.log(response);
                    $('#query_id').val(query_id);
                    $('#licence_id1').val(response.licence.licence_key);
                    $('#start_date1').val(response.licence.start_date_time);
                    $('#end_date1').val(response.licence.end_date_time);
                }
            });

        });
        //===================Script For Delete Exercise ====================================
        $(document).on('click', '.deletebtn', function () {
            var query_id = $(this).val();
            $('#deleteModal').modal('show');
            $('#deleting_id').val(query_id);
        });
    });
</script>
<script> 
    $(document).ready(function () {
        $('#exercisetbl').DataTable();
    });
</script>

@endsection