@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <section class="content">
        <!-- <div class="container-fluid">
            <h2 class="display-7 text-white font-weight-bold px-0">
                {{$title}}
            </h2> -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">
                            <h6>{{$title}}</h6>
                        </div>
                        <div class="card-body">
                            <form type="submit" action="{{$url}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label ">Name*</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ isset($record->name)?$record->name:'' }}">
                                        <span class="text-danger">
                                            @error('name')
                                            {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                    <label for="exampleInputEmail1"
                                        class="form-label ">Email address*</label>
                                    <input type="email" class="form-control " name="email" id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                        value="{{ isset($record->email)?$record->email:'' }}">
                                    <span class="text-danger">
                                        @error('email')
                                        {{$message}}
                                        @enderror
                                    </span>
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        id="exampleInputPassword1"
                                        value="{{ isset($record->password)?$record->password:'' }}">
                                    <span class="text-danger">
                                        @error('password')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                                <button type="submit" id="submit" class="btn btn-dark">{{$text}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection