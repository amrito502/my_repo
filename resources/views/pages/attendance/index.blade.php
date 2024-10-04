@extends('layouts.app')
@section('title', 'Attendance')
@section('description', 'Attendance')
@section('breadcrumb01', 'Attendance')
@section('breadcrumb02', 'Attendance ')
@section('app-content')
    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">

                <div class="body">
                    <form id="form_validation" action="{{route('attendance.store')}}" method="post" enctype="multipart/form-data">
                            @csrf

                        <div class="row clearfix">

                            <div class="col-sm-4">
                                <label class="form-label">Select Class</label>
                                <select required name="class_id" id="class_id" class="form-control show-tick">
                                    <option value=""> -- Select Class -- </option>
                                    @foreach($classes as $data)
                                        <option value="{{$data->id}}" {{ old('class_id') == $data->id ? 'selected' : '' }}> {{$data->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class_id'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('class_id') }}</span>
                                @endif
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label">Select Branch</label>

                                <select required name="section_id" id="section_id" class="form-control show-tick">

                                </select>

                                @if ($errors->has('section_id'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('section_id') }}</span>
                                @endif
                            </div>

                            {{-- <div class="col-sm-4">
                                <label class="form-label">Select Class</label>
                                <select  name="class_id" id="class_id" class="form-control show-tick">
                                 @foreach($classes as $data)
                                  <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div> --}}
                            {{-- <div class="col-sm-4">
                                <label class="form-label">Select Section</label>
                                <select  name="section_id" id="section_id" class="form-control show-tick">
                                 @foreach($sections as $data)
                                  <option value="{{$data->id}}" {{old('name') == $data->name ? 'selected' : '' }}> {{$data->name}}</option>
                                 @endforeach
                                </select>
                                 @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                @endif
                            </div> --}}
                            <div class="col-md-4">
                                <label class="form-label">Select Shift</label>
                                <select  name="shift" id="shift" class="form-control show-tick">
                                    <option value="Day" {{old('shift') == 'Day' ? 'selected' : '' }}> Day</option>
                                    <option value="Morning" {{old('shift') == 'Morning' ? 'selected' : '' }}> Morning</option>
                                </select>
                                 @if ($errors->has('shift'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('shift') }}</span>
                                @endif
                            </div>
                        </div>
                        </br>

                        <div class="form-group form-float">
                            <label class="form-label">Attendance Date</label>
                            <div class="form-line">
                               <input type="text" class="form-control date" name="date" id="date" value="{{ \Carbon\Carbon::now()->format('d-m-Y')}}" placeholder="Date: {{ \Carbon\Carbon::now()->format('d-m-Y')}}" readonly />
                                @if ($errors->has('name'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                        {{ $errors->first('date') }}</span>
                                @endif

                            </div>
                        </div>
                        <a href="{{ route('attendance.index') }}" class="btn btn-raised btn-default waves-effect mr-3">Back</a>
                        <button class="btn btn-raised btn-primary waves-effect" type="submit">Continue</button>
                    </form>
                </div>



                {{-- <div class="body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Roll No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>sadasda</td>
                                <td>asdsa</td>

                                <td>
                                    <div class="action__buttons">
                                        <div class="form-group">
                                            <input type="radio" name="gender" id="male" class="with-gap">
                                            <label for="male">Present</label>
                                            <input type="radio" name="gender" id="female" class="with-gap">
                                            <label for="female" class="m-l-20">Absent</label>

                                        </div>
                                       @can('edit_attendance')
                                            <a href="{{ route('exam.edit', [$data->uuid]) }}" class="btn-action">
                                                <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="edit">
                                            </a>
                                        @endcan
                                        @can('delete_attendance')
                                            <a class="btn-action delete"
                                                onclick="return confirm('Are you sure? You want to delete')"
                                                href="{{ route('exam.delete', $data->uuid) }}"> <img
                                                    src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="trash"></a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}




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
