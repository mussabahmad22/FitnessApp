@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Reviews</h5>
                        </div>

                        <div class="container">
                            <span id="rateMe2" class="empty-stars"></span>
                        </div>

                        <!-- rating.js file -->
                        <script src="js/addons/rating.js"></script>
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
        $('#exercisetbl').DataTable();
    });
    // Rating Initialization
    $(document).ready(function () {
        $('#rateMe2').mdbRate();
    });
</script>

@endsection