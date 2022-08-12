@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Update QR Image</h5>
                        </div>
                        <div class="card-body">
                            <form type="submit" action="{{route('QR')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label ">QR Image :</label><br>
                                    <input class="form-control" type="file" name="file_title" accept="image/*"
                                        value="#">
                                    <span class="text-danger">
                                        @error('file_title')
                                        {{ 'QR Image is required' }}
                                        @enderror
                                    </span>
                                </div>
                                <button type="submit" id="btn" class="btn btn-dark">Update</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> QR Image</h5>
                        </div>
                        <div class="intro-y datatable-wrapper box p-5 mt-1">
                            @foreach($query as $que)

                            <img src="{{asset('public/storage/'. $que->qr_img)}}" width="150" height="150">

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection