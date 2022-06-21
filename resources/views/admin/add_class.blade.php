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
                                        @error('clas_title')
                                        {{ 'Class Title is required' }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label ">Title Image :</label><br>
                                    <input class="form-control" type="file" name="file_title" accept="image/*" value="#">
                                    <span class="text-danger">
                                        @error('file_title')
                                        {{ 'Class Image is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label class="form-label ">Workout Level*</label>
                                    <input type="text" class="form-control" name="workout_level" id="workout_level" placeholder="Internee / Intermidiate / Expert"
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
                                    <select name="eqp_title_id[]" class="form-control"  id="eqp_title_id" class="category"  multiple="multiple"
                                        value="{{ isset($record->eqp_id)?$record->eqp_id:'' }}">
                                        <option disabled value="0">No Choosen</option>
                                        @foreach($eqps as $eqp)
                                           
                                            <option value="{{ $eqp->id }}"
                                                 <?php if(in_array($eqp->id, $mltp_eqp_array)) echo 'selected';
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
                                <br>
                                <div class="mb-3">
                                    <label class="form-label">Upload Video*</label>
                                    <input class="filepond" type="file" name="video_file" id="file" 
                                        data-max-file-size="100000MB" data-max-files="3">
                                    <span class="text-danger">
                                        @error('video_file')
                                        {{ 'Upload Video' }}
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
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
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


    // FilePond.registerPlugin(
 
    //     FilePondPluginFileValidateSize,
        
    // );


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



    // $('#btn').click(function () {
    //     swal({
    //         title: "Good job!",
    //         text: "You clicked the button!",
    //         icon: "success",
    //         button: "Aww yiss!",
    //         allowEnterKey: true,
            
    //     });
        
    // });

</script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>



@endsection