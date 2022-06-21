@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5>Equipments</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <div style="float: right; margin-right:50px;">
                                    <a href="{{route('show_add_equipments')}}"><button type="button"
                                            class="btn btn-Success text-dark mb-0">+ Add
                                            Equipments</button></a>
                                </div>
                                <!-- BEGIN: Datatable -->
                                <div class="intro-y datatable-wrapper box p-5 mt-1">
                                    <table id="myTable"
                                        class="table table-report table-report--bordered display w-full">
                                        <thead>
                                            <tr>
                                                <th class="border-b-2  whitespace-no-wrap">
                                                    Sr.</th>

                                                <th class="border-b-2 whitespace-no-wrap">
                                                    Equipment Name*</th>

                                                <th class="border-b-2 whitespace-no-wrap">
                                                    Equipment Image</th>

                                                <th class="border-b-2 whitespace-no-wrap">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  $i = 0; ?>
                                            @foreach($query as $que)
                                            <?php $i++; ?>
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                
                                                <td>
                                                    <?= $que->eqp_name?>
                                                </td>
                                                <td>
                                                    <img src="{{asset('public/storage/'. $que->eqp_img)}}" width="50"
                                                        height="50">
                                                </td>
                                                <td>
                                                    <a class="flex items-center text-theme-1 mr-3 btn text-info"
                                                        href="{{route('edit_equipment',['id' => $que->id])}}"> <img
                                                            src="{{asset('img/edit.svg')}}"> Edit </a>


                                                    <button style="border:none;" type="button" value="{{ $que->id}}"
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
                                <!-- //======================Delete Equipment Modal================================= -->
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Equipment
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form type="submit" action="{{route('equipment_delete')}}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                                        <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                            <input type="hidden" name="delete_equipment_id"
                                                                id="deleting_id"></input>
                                                            <p>Are you sure! want to Delete Equipment?</p>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="flex items-center text-theme-1 mr-3 btn text-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="flex items-center text-theme-1 mr-3 btn text-danger">Delete</button>
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
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

    $(document).on('click', '.deletebtn', function () {
        var query_id = $(this).val();
        $('#deleteModal').modal('show');
        $('#deleting_id').val(query_id);
    });
</script>

@endsection