@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            <h6>{{$title}}</h6>
                        </div>
                        <div class="card-body">
                            <form type="submit" action="{{$url}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Equipment
                                        Title*</label>
                                    <input type="text" class="form-control" name="eqp_title" id="eqp_title" value="{{ isset($record->eqp_name)?$record->eqp_name:'' }}">
                                    <span class="text-danger">
                                        @error('eqp_title')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label ">Title Image
                                        :</label><br>
                                    <input class="form-control" type="file"
                                        name="file_title" accept="image/*" value="#">
                                        <span class="text-danger">
                                            @error('file_title')
                                            {{$message}}
                                            @enderror
                                        </span>
                                </div>
                                <br> <br>
                                <div class="form-group">
                                    <label><strong>Equipments Description*</strong></label>
                                    <textarea class="form-control" name="eqp_desc">{{ isset($record->eqp_desc)?$record->eqp_desc:'' }}</textarea>
                                    <span class="text-danger">
                                        @error('eqp_desc')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Upload Video*</label>
                                    <input class="filepond" type="file" name="video_file" id="file" multiple
                                        data-max-file-size="10000000000MB" data-max-files="30">
                                        <span class="text-danger">
                                            @error('video_file')
                                            {{$message}}
                                            @enderror
                                        </span>
                                </div>
                                <input type="hidden" name="video_path" id="video_path">
                                <button type="submit" id="btn" class="btn btn-dark " {{$variable_text}} >{{$text}}</button>
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

</script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>


@endsection