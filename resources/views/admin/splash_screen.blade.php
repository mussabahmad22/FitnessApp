@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Update Splash Screen Video & App Logo</h5>
                        </div>
                        <div class="card-body">
                            <form type="submit" action="{{route('splash_screen')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload Video</label>
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
                                <div class="mb-3 {{isset($video->splash_video_path)?'':'d-none'}}" id="videoid">
                                    <div>
                                        <video id="video_load" width="380" height="300" controls>
                                            <source class="videosrc"
                                                src="{{isset($video->splash_video_path)?asset('public/storage/'.$video->splash_video_path):''}}"
                                                type="video/mp4">
                                            <source class="videosrc"
                                                src="{{isset($video->splash_video_path)?asset('public/storage/'.$video->splash_video_path):''}}"
                                                type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label ">App Logo</label><br>
                                    <input class="form-control" type="file" name="file_title" accept="image/*"
                                        value="#">
                                    <span class="text-danger">
                                        @error('file_title')
                                        {{ 'App Logo is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 {{isset($video->logo)?'':'d-none'}}" >
                                    <img src="{{asset('public/storage/'. $video->logo)}}" width="100"
                                                height="100">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label ">App Logo Text</label>
                                    <input type="text" class="form-control" name="logo_text" value="{{ isset($video->logo_text)?$video->logo_text:'' }}">
                                    <span class="text-danger">
                                        @error('logo_text')
                                        {{ 'Workout Level is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <input type="hidden" name="video_path" id="video_path">
                                <button type="submit" id="btn" class="btn btn-dark">Update</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/plupload/js/plupload.full.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var path = "{{ asset('/plupload/js/') }}";

        var uploader = new plupload.Uploader({
            browse_button: 'pickfiles',
            container: document.getElementById('file-input'),
            url: '{{ route("chunk.store") }}',
            chunk_size: '2Mb', // 1 MB
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