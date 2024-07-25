@component('partials/header')

    @slot('title')
        PIS | REPORTS-Consultation Logs
    @endslot

@section('pagestyle')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/admin/reports.css') }}">
    <style>
        span.asteresk{
            font-size: 20px;
            color: red;
            font-weight: bolder;
        }
    </style>
@stop



@section('header')
    @include('admin/navigation')
@stop



@section('content')
    <div class="container" >
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>Doctor Consulted Patient List</label>
                   
                </div>
                <div class="panel-body">
                    <div class="pull-right asteresk">
                        <p>
                            
                        <small>Fields mark with <span class="text-danger asteresk">*</span> are required</small>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <form class="form-horizontal" method="GET" id="doctor_consulted_patient_list">
                            <div class="form-group">
                                <label>Export By <span class="text-danger asteresk">*</span></label>
                                <select class="form-control export_by" name="export_by" style="width: 100%;" required>
                                    <option value="clinic">Clinic</option>
                                    <option value="doctor">Doctor</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Clinic <span class="text-danger asteresk">*</span></label>
                                <select class="form-control clinic_id" name="clinic_id" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($clinics as $clinic)
                                        <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group doctor" hidden>
                                <label>Doctor <span class="text-danger asteresk">*</span></label> 
                                <select class="form-control doctor_id" name="doctor_id" style="width: 100%;" required>
                                    
                                </select>
                            <input type="hidden" name="doctor_name" class="doctor_name">
                            </div>

                            <div class="form-group">
                                <label>Start Day <span class="text-danger asteresk">*</span></label>
                                <input type="date" name="start_day" class="form-control start_day" required>
                            </div>
                            <div class="form-group">
                                <label>End Day <span class="text-danger asteresk">*</span></label>
                                <input type="date" name="end_day" class="form-control start_day" required>
                            </div>
                            <div class="form-group">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel-footer pull-right">
                    <button type="submit" class="btn btn-success btn-md" form="doctor_consulted_patient_list"><span class="fa fa-file-text-o"></span> Generate Excel File</button>
                </div>
            </div>
        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select.doctor_id').select2();
            $('select.clinic_id').select2({
                placeholder: 'Select clinic 1st'
            });
            $('select.export_by').select2({
                placeholder: 'Select Export By 1st'
            })
        });


        $(document).on('select2:select', 'select.clinic_id',function (e) {
            var data = e.params.data;
            getclinicdoctors(data.id);
        });

        $(document).on('select2:select', 'select.doctor_id',function (e) {
            var data = e.params.data;
            $('input.doctor_name').val(data.text);
        });

        $(document).on('select2:select', 'select.export_by',function (e) {
            var data = e.params.data;
            $('div.form-group.doctor').prop('hidden', (data.id == 'doctor')?false:true);
        });

        function getclinicdoctors(id) {
            request = $.ajax({
                url: baseUrl+'/getclinicdoctors/'+id,
                type: "get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json"
            });
            request.done(function (response, textStatus, jqXHR) {
                appendatatodoctorselectiontag(response);
            });
            request.fail(function (jqXHR, textStatus, errorThrown){
                console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
                toastr.error('Oops! something went wrong.');
            });
            request.always(function (response){
                console.log("To God Be The Glory...");
            });
        }
        function appendatatodoctorselectiontag(response){
            $('select.doctor_id').empty();
            for (var i = 0; i < response.length; i++) {
                var option = $('<option>').val(response[i].id).text('Dr. '+capitalize(response[i].last_name)+', '+capitalize(response[i].first_name));
                $('select.doctor_id').append(option);
            }
        }

        function capitalize(yourtext){
            return yourtext.substr(0,1).toUpperCase()+yourtext.substr(1).toLowerCase();
        }        
    </script>
    
@stop


@endcomponent
