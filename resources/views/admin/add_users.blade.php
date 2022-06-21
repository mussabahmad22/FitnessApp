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
                                            {{' user name is required'}}
                                            @enderror
                                        </span>
                                    </div>
                                    <label for="exampleInputEmail1" class="form-label ">Email address*</label>
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
                                <br>
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0" id="dynamicAddRemove">
                                            <tr>
                                                <th>Add Multiple Emails</th>
                                                <th>Action</th>
                                            </tr>
                                            @if(count($multiple_emails) == 0)
                                            <tr>
                                                <td><input type="email" name="moreFields[]" placeholder="Enter Email"
                                                        class="form-control" /></td>
                                                <td><button type="button" name="add" id="add-btn"
                                                        class="btn btn-success">+ Add
                                                        More</button></td>
                                            </tr>
                                            @else
                                            @foreach($multiple_emails as $key => $email)
                                            <tr>
                                                <td>
                                                    <input type="email" name="moreFields[]"
                                                        value="{{ isset($email->multiple_emails)?$email->multiple_emails:'' }}"
                                                        placeholder="Enter Email" class="form-control" />
                                                </td>
                                                @if($key == 0)
                                                <td><button type="button" name="add" id="add-btn"
                                                        class="btn btn-success">+ Add
                                                        More</button>
                                                </td>
                                                @else
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-tr">-
                                                        Remove
                                                    </button>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @endif
                                        </table>
                                        <span class="text-danger">
                                            @error('moreFields.*')
                                            Minimum 1 email is required
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" id="submit" class="btn btn-dark btn-lg">{{$text}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    var i = 0;
    $("#add-btn").click(function () {
        ++i;

        $("#dynamicAddRemove").append('<tr><td><input type="email" name="moreFields[]" placeholder="Enter Email" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">- Remove</button></td></tr>');

    });
    $(document).on('click', '.remove-tr', function () {
        $(this).parents('tr').remove();
    });  
</script>


@endsection