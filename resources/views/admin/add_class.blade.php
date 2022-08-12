@extends('admin.layouts.main')

@section('main-container')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                        @error('clas_title')
                                        {{ 'Class Title is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label ">Class Description*</label>
                                    <textarea type="text" class="form-control input-lg " name="desc" id="desc"
                                    >{{ isset($record->desc)?$record->desc:'' }}</textarea>
                                    <span class="text-danger">
                                        @error('desc')
                                        {{ 'Class Description is required' }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label ">Title Image :</label><br>
                                    <input class="form-control" type="file" name="file_title" accept="image/*"
                                        value="#">
                                    <span class="text-danger">
                                        @error('file_title')
                                        {{ 'Class Image is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label ">Video Thumb Image :</label><br>
                                    <input class="form-control" type="file" name="video_thumb_img" accept="image/*"
                                        value="#">
                                    <span class="text-danger">
                                        @error('video_thumb_img')
                                        {{ 'Video Thumb Image is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label ">QR Image :</label><br>
                                    <input class="form-control" type="file" name="qr_img" accept="image/*"
                                        value="#">
                                    <span class="text-danger">
                                        @error('qr_img')
                                        {{ 'QR Image is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label ">Choose Category* </label>
                                    <select name="cat_id" class="form-control " id=""
                                        class="category"  aria-label
                                        value="">
                                        <option disabled selected>Select Category</option>
                                        @foreach($categories as $cat)

                                        <option value="{{ $cat->id }}"  <?php if(isset($record->cat_id)){ echo 'selected'; }  ?> >{{ $cat->category_title}}</option>

                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('eqp_title_id')
                                        {{ 'Choose Equipment Category' }}
                                        @enderror
                                    </span>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label class="form-label ">Workout Level*</label>
                                    <input type="text" class="form-control" name="workout_level" id="workout_level"
                                        placeholder="Internee / Intermidiate / Expert"
                                        value="{{ isset($record->workout_level)?$record->workout_level:'' }}">
                                    <span class="text-danger">
                                        @error('workout_level')
                                        {{ 'Workout Level is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label ">Trainer Name*</label>
                                    <input type="text" class="form-control" name="trainer_name" id="trainer_name"
                                        value="{{ isset($record->trainer_name)?$record->trainer_name:'' }}">
                                    <span class="text-danger">
                                        @error('trainer_name')
                                        {{ 'Class Title is required' }}
                                        @enderror
                                    </span>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label ">Choose Equipment </label>
                                    <select name="eqp_title_id[]" class="form-control selectpicker" id="eqp_title_id"
                                        class="category" multiple aria-label="size 3 select example"
                                        value="{{ isset($record->eqp_id)?$record->eqp_id:'' }}">
                                        @foreach($eqps as $eqp)

                                        <option value="{{ $eqp->id }}" <?php if(in_array($eqp->id, $mltp_eqp_array))
                                            echo 'selected';
                                            ?>
                                            >{{ $eqp->eqp_name}}</option>

                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('eqp_title_id')
                                        {{ 'Choose Equipment Category' }}
                                        @enderror
                                    </span>
                                </div>
                          
                                <div class="mb-3">
                                    <label class="form-label">Upload Video*</label>
                                    <div class="form-group" id="file-input">
                                        <input class="form-control" type="file" name="video_file" id="pickfiles">
                                        <div id="filelist"></div>
                                    </div>
                                    <!-- Progress bar -->
                                    <div class="progress"></div>
                                    <span class="text-danger">
                                        @error('video_file')
                                        {{ 'Upload Video' }}
                                        @enderror
                                    </span>
                                </div>
                                <br>

                                <div class="mb-3 {{isset($record->clas_video_path)?'':'d-none'}}" id="videoid">
                                    <div>
                                        <video id="video_load" width="380" height="300" controls>
                                            <source class="videosrc"
                                                src="{{isset($record->clas_video_path)?asset('public/storage/'.$record->clas_video_path):''}}"
                                                type="video/mp4">
                                            <source class="videosrc"
                                                src="{{isset($record->clas_video_path)?asset('public/storage/'.$record->clas_video_path):''}}"
                                                type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>

                                </div>

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
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<!-- <script>
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginFileValidateType);

    // ... FilePond initialisation code here
</script>

<script>
    const inputElement = document.querySelector('input[id="file"]');
    const pond = FilePond.create(inputElement,{
    acceptedFileTypes: ['video/*'],
    fileValidateTypeDetectType: (source, type) =>
        new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise

            resolve(type);
        }),
    });


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

</script> -->
<script src="{{ asset('/plupload/js/plupload.full.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var path = "{{ asset('/plupload/js/') }}";

        var uploader = new plupload.Uploader({
            browse_button: 'pickfiles',
            container: document.getElementById('file-input'),
            url: '{{ route("chunk.store") }}',
            chunk_size: '10Mb', // 1 MB
            max_retries: 2,
            filters: {
                max_file_size: '100000mb',
                mime_types: [
                    { title: "Video files", extensions: "mp4,avi,mpeg,mpg,mov,wmv" },
                ]
            },
            multipart_params: {
                // Extra Parameter
                "_token": "{{ csrf_token() }}"
            },

            init: {
                PostInit: function () {
                    document.getElementById('filelist').innerHTML = '';
                },
                FilesAdded: function (up, files) {
                    plupload.each(files, function (file) {
                        console.log('FilesAdded');
                        console.log(file);
                        document.getElementById('filelist').innerHTML = '<div class="text-primary" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                    });
                    uploader.start();
                },
                UploadProgress: function (up, file) {
                    console.log('UploadProgress');
                    console.log(file);
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    document.querySelector(".progress").innerHTML = '<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: ' + file.percent + '%; height: 15px;">' + file.percent + '%</div>';
                },
                FileUploaded: function (up, file, result) {

                    console.log('FileUploaded');
                    console.log(file);
                    console.log(JSON.parse(result.response));
                    responseResult = JSON.parse(result.response);

                    $('#video_path').val(responseResult.file);
                    $('.videosrc').attr('src', 'https://wh717090.ispot.cc/fitness/public/storage/files/' + responseResult.file);
                    $('#video_load')[0].load();
                    $('#videoid').removeClass('d-none');
                    $('#btn').removeAttr('disabled');


                    if (responseResult.ok == 0) {
                        toastr.error(responseResult.info, 'Error Alert', { timeOut: 5000 });
                    }
                    if (result.status != 200) {
                        toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', { timeOut: 5000 });
                    }
                    if (responseResult.ok == 1 && result.status == 200) {
                        toastr.success('Your File Uploaded Successfully!!', 'Success Alert', { timeOut: 5000 });
                    }
                },
                UploadComplete: function (up, file) {
                    toastr.success('Your File Uploaded Successfully!!', 'Success Alert', { timeOut: 5000 });

                },
                Error: function (up, err) {
                    // DO YOUR ERROR HANDLING!
                    toastr.error('Your File Uploaded Not Successfully!!', 'Error Alert', { timeOut: 5000 });
                    console.log(err);
                }
            }
        });
        uploader.init();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
    integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>



@endsection