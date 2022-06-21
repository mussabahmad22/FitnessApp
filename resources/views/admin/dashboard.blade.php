@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <!-- <div class="container-fluid">
      <h4 class="display-7 text-white font-weight-bold px-0">
        Dashboard
      </h4> -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <!-- <h6>Authors table</h6> -->
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-info mb-3">
                        <div class="card-header font-weight-bold ">Total Users</div>
                        <div class="card-body">
                          <span class="display-4  text-white font-weight-bold px-0">{{ $users }}</span>
                          <i class="nav-icon fas fa-users  text-white font-weight-bold px-0"></i>
                          <p class="card-text  text-white font-weight-bold px-0" id="users"> Manage Users <i
                              class="fas fa-arrow-circle-right"></i></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-info mb-3">
                        <div class="card-header font-weight-bold">Total Equipments</div>
                        <div class="card-body">
                          <span class="display-4  text-white font-weight-bold px-0">{{ $categoury }}</span>
                          <i class="fas fa-chart-pie  text-white font-weight-bold px-0"></i>
                          <p class="card-text  text-white font-weight-bold px-0" id="category">Manage Equipments <i
                              class="fas fa-arrow-circle-right"></i></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-info mb-3">
                        <div class="card-header font-weight-bold">Total Classes</div>
                        <div class="card-body">
                          <span class="display-4  text-white font-weight-bold px-0">{{ $class }}</span>
                          <i class="ni ni-app  text-white font-weight-bold px-0"></i>
                          <p class="card-text  text-white font-weight-bold px-0" id="class">Manage Classes <i
                              class="fas fa-arrow-circle-right"></i></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-info mb-3">
                        <div class="card-header font-weight-bold">Total Licences</div>
                        <div class="card-body">
                          <span class="display-4  text-white font-weight-bold px-0">{{ $lice }}</span>
                          <i class="ni ni-key-25 text-white font-weight-bold px-0"></i>
                          <p class="card-text  text-white font-weight-bold px-0" id="lice">Manage Licences <i
                              class="fas fa-arrow-circle-right"></i></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {

    $('#users').on('click', function () {
      window.location.href = '{{route("users")}}';
    });

    $('#category').on('click', function () {
      window.location.href = '{{route("equipments")}}';
    });
    $('#class').on('click', function () {
      window.location.href = '{{route("classes")}}';
    });
    $('#lice').on('click', function () {
      window.location.href = '{{route("licence")}}';
    });

  });
</script>

@endsection