@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            <h5>{{$title}}</h5>
                        </div>
                        <div class="card-body">
                            <form type="submit" action="{{$url}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label ">Class Title*</label>
                                    <input type="text" class="form-control" name="clas_title" id="clas_title"
                                        value="{{ isset($record->clas_name)?$record->clas_name:'' }}">
                                    <span class="text-danger">
                                        @error('eqp_title')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label ">Title Image :</label><br>
                                    <input class="form-control" type="file" name="file_title" value="#">
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label class="form-label ">Choose Equipment*</label>
                                    <select name="eqp_title_id" class="form-control" id="eqp_title_id" class="category"
                                        value="{{ isset($record->eqp_id)?$record->eqp_id:'' }}">
                                        <option disable selected>select category</option>
                                        @foreach($eqps as $eqp)
                                        <option value="{{ $eqp->id }}" @if(isset($record->eqp_id)) {{ $record->eqp_id ==
                                            $eqp->id ?'selected':'' }}
                                            @endif >{{ $eqp->eqp_name}}</option>
                                        @endforeach
                                        <span class="text-danger">
                                            @error('eqp_title')
                                            {{$message}}
                                            @enderror
                                        </span>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-white font-weight-bold px-0">Upload Video*</label>
                                    <input class="filepond" type="file" name="video_file" id="file" multiple
                                        data-max-file-size="10000000000MB" data-max-files="30">
                                    <span class="text-danger">
                                        @error('video_file')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                                <br>
                                <input type="hidden" name="video_path" id="video_path">
                                <button type="submit" id="btn" class="btn btn-dark "
                                    {{$variable_text}}>{{$text}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const inputElement = document.querySelector('input[id="file"]');
    const pond = FilePond.create(inputElement);

    // $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize) = function () {

    //     $.fn.filepond.setDefaults({
    //         maxFileSize: '1000000MB',
    //     });
    // }

    FilePond.setOptions({
        server: {
            url: '/upload',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                chunkUploads: true,
                chunkForce: true,
                timeout: 7000,
            },
            process: {
                onload: (res) => {
                    $('#video_path').val(res);
                    $('#btn').removeAttr('disabled');
                }
            }


        }
    });

    $('#btn').click(function () {
        swal({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
            button: "Aww yiss!",
            allowEnterKey: true,
            
        });
        
    });

</script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>



@endsection