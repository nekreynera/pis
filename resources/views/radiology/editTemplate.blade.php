@component('partials/header')

    @slot('title')
        PIS | Edit Templates
    @endslot

@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('public/css/radiology/master.css') }}">
@stop



@section('header')
    @include('radiology/navigation')
@stop



@section('content')

    <div class="container-fluid">
        <div class="container">


            <div class="container">

                <h3>
                    Edit Templates
                </h3>

                <hr>

                @include('radiology.store.templatesTabs')


                <div class="tab-content">
                    <div id="addResultWrapper" class="tab-pane fade in active">
                        <br>
                        <form action="{{ url('editTemplate') }}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $template->id }}" />


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <small class="help text-danger">Required Field</small>
                                        <input type="text" name="description" value="{{ $template->description }}"
                                               class="form-control" placeholder="Enter Description" required />
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                        <strong class="">{{ $errors->first('description') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <small class="help text-danger">Optional Field</small> &nbsp;
                                        <small class="text-muted">Please select a service where this template will be preloaded.</small>
                                        <select name="subcategory_id" id="" class="form-control">
                                            <option value="">--Template For--</option>
                                            @foreach($radiology as $row)
                                                <option value="{{ $row->id }}" {{ ($row->id == $template->subcategory_id)? 'selected':'' }}>
                                                    {{ $row->sub_category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>





                            <textarea name="result" class="my-editor" id="" cols="30" rows="40">{{ $template->content }}</textarea>
                        </form>
                    </div>
                </div>


            </div>


        </div>
    </div>

@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/js/radiology/templates/ultrasound.js') }}"></script>
    <script src="{{ asset('public/js/radiology/templates/xray.js') }}"></script>
    <script src="{{ asset('public/js/radiology/richtexteditor.js') }}"></script>
    <script src="{{ asset('public/plugins/js/preventDelete.js') }}"></script>
@stop


@endcomponent
