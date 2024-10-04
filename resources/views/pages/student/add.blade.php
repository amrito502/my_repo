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
                    <h2> Student Add </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                role="button" aria-haspopup="true" aria-expanded="false"> <i
                                    class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="body">
                    <form id="form_validation" action="{{ route('student.store') }}" method="post" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                                            placeholder="First name" class="form-control" required>
                                        @if ($errors->has('first_name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                                            placeholder="Last name" class="form-control" required>
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <!-- <small>Asign role</small> -->
                                        <select name="gender" id="gender" class="form-control show-tick" required>
                                            <option value="">Select gender</option>
                                            <option value="Boy" {{ old('gender') == 'Boy' ? 'selected' : '' }}>Boy
                                            </option>
                                            <option value="Girl" {{ old('gender') == 'Girl' ? 'selected' : '' }}>Girl
                                            </option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                            class="form-control" required>
                                        @if ($errors->has('email'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                            placeholder="SMS Phone number" class="form-control" required>
                                        @if ($errors->has('phone_number'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="gurdian_phone_number" value="{{ old('gurdian_phone_number') }}"
                                            placeholder="Gurdian Phone number" class="form-control" required>
                                        @if ($errors->has('gurdian_phone_number'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('gurdian_phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="address" value="{{ old('address') }}"
                                            placeholder="Address" class="form-control" required>
                                        @if ($errors->has('address'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label class="form-label">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control show-tick" required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('name') == $data->name ? 'selected' : '' }}>
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="section_id" id="section_id" class="form-control show-tick"
                                            required>
                                            <option value="">Select Branch</option>
                                        </select>
                                        @if ($errors->has('name'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <!-- <small>Asign role</small> -->
                                        <select name="shift" id="shift" class="form-control show-tick" required>
                                            <option value="">Select Shift</option>
                                            <option value="Morning" {{ old('shift') == 'Morning' ? 'selected' : '' }}>Morning
                                            </option>
                                            <option value="Day" {{ old('shift') == 'Day' ? 'selected' : '' }}>Day
                                            </option>
                                        </select>
                                        @if ($errors->has('shift'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                {{ $errors->first('shift') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            </br>
                        </div>
                        <br />
                        <a href="{{ route('dashboard') }}" class="btn btn-raised btn-default waves-effect mr-3">Back</a>
                        <button class="btn btn-raised btn-success waves-effect" type="submit">Add Student</button>
                    </form>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#class_id').change(function() {
            var classId = $(this).val();

            // alert(classId);

            if(classId) {
                $.ajax({
                    url: '{{ url("/get-sections-by-class") }}/' + classId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#section_id').empty();

                        //console.log(data);

                        $.each(data, function(key, value) {

                            console.log(key, value);

                            $('#section_id').append('<option value="'+ key +'">'+ value +'</option>');
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
