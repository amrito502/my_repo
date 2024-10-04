

@extends('layouts.app')
@section('title', 'Assgin')
@section('description', 'Assgin.')
@section('breadcrumb01', 'Assgin')
@section('breadcrumb02', 'Assgin')
@section('app-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Send SMS</h2>
            </div>
            <div class="body">
                <form id="form_validation" action="{{route('sendStudentSms')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row clearfix">
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
                                        <option value="">Select Section</option>

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
                                    <select name="shift" id="shift" class="form-control show-tick">
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
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <label class="form-label">Message</label>
                                    <textarea id="message" name="message" class="form-control" style="height:150px"></textarea>
                                    @if ($errors->has('message'))
                                        <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> {{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    </br>
                    <a href="{{ route('assgin.index') }}" class="btn btn-raised btn-default waves-effect">Back</a>
                    <button class="btn btn-raised btn-primary waves-effect" type="submit">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


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
