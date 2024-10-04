@extends('layouts.app')
@section('title', 'Student Add')
@section('description', 'Student Add')
@section('breadcrumb01', 'Student')
@section('breadcrumb02', 'Student Add')
@section('app-content')

<style>
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<!-- Input Group -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2> Upload CSV file </h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-8">
                        @if (session('success'))
                            <div>{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('student.csv.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input class="mt-3 py-1 pl-1" style="" type="file"
                                name="csv_file" id="csv_file" accept=".csv">
                            @if($errors->has('csv_file'))
                                <div class="error mt-3 text-danger"><i class="fas fa-exclamation-triangle"></i>
                                    {{ $errors->first('csv_file') }}</div>
                            @endif

                            <button class="btn btn-raised btn-success waves-effect ml-3 button_csv_upload" 
                                type="submit">Upload CSV</button>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
<!-- #END# Input Group -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/css/custom/image-preview.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
    <script src="{{ asset('admin/js/custom/admin-profile.js') }}"></script>
@endpush

<!-- Include jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap and Bootstrap-select if not already included -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#class_id').change(function () {
            var classId = $(this).val();

            // alert(classId);

            if (classId) {
                $.ajax({
                    url: '{{ url("/get-sections-by-class") }}/' + classId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#section_id').empty();

                        //console.log(data);

                        $.each(data, function (key, value) {

                            console.log(key, value);

                            $('#section_id').append('<option value="' + key + '">' + value + '</option>');
                        });

                        $('#section_id').selectpicker('refresh');

                    }
                });
            } else {
                $('#section_id').empty();
                $('#section_id').selectpicker('refresh');
            }
        });
    });
</script>