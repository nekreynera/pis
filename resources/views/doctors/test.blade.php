@component('partials/header')

    @slot('title')
        PIS | Consultation
    @endslot

@section('pagestyle')
    <link href="{{ asset('public/css/doctors/consultation.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/css/doctors/reset.css') }}" rel="stylesheet" />
    @if(Auth::user()->theme == 2)
        <link href="{{ asset('public/css/doctors/darkstyle.css') }}" rel="stylesheet" />
    @else
        <link href="{{ asset('public/css/doctors/greenstyle.css') }}" rel="stylesheet" />
    @endif
@endsection



@section('header')
    @include('doctors.navigation')
@stop



@section('content')
    @component('doctors/dashboard')
@section('main-content')






    <div class="content-wrapper">
        <br/>
        <br/>
        <div class="container-fluid">

            <form action="{{ url('consultationstore') }}" method="post">
                {{ csrf_field()  }}
                <div class="form-group">
                    <textarea name="consultation" class="my-editor" rows="100">{!! $content !!}</textarea>
                </div>
                <button class="btn btn-default" type="submit">SUBMIT</button>
            </form>

        </div>
    </div> <!-- .content-wrapper -->







@endsection
@endcomponent
@endsection





@section('footer')
@stop



@section('pagescript')
    @include('message.toaster')
    <script src="{{ asset('public/plugins/js/modernizr.js') }}"></script>
    <script src="{{ asset('public/plugins/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('public/js/doctors/main.js') }}"></script>

    <script src="{{ asset('public/plugins/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        var table = '<table style="border-collapse:collapse; width:100%;height:1600px;" border="1">' +
            '<thead>' +
            '<tr style="background-color: #ccc;width: 400px">' +
            '<th style="padding:5px;width:130px;">DATE/TIME</th>' +
            '<th style="padding:5px;">DOCTOR\'S CONSULTATION</th>' +
            '<th style="padding:5px;width:230px;">NURSE\'S NOTES</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr style="width: 300px;">' +
            '<td valign="top" style="width:130px;" id="dateAndTime"></td>' +
            '<td valign="top"></td>' +
            '<td valign="top" style="width:230px;"></td>' +
            '</tr>' +
            '</tbody>' +
            '</table>';
        var editor_config = {
            path_absolute : "{{ URL::to('/') }}/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist lists image charmap print preview hr tabfocus",
                "searchreplace wordcount code fullscreen",
                "insertdatetime nonbreaking directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "restoredraft undo redo | insertdatetime insertfile | styleselect fontsizeselect forecolor backcolor |" +
            " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
            "outdent indent ltr rtl | link image media emoticons",

            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            templates: [
                {title: 'Doctors Consultation', description: 'Doctors Consultation Form', content: table}
            ],
            tabfocus_elements: "button",
            insertdatetime_formats: ["%b %d, %Y %H:%M %p", "%b %d, %Y", "%I:%M:%S %p", "%D"],
            table_toolbar: false,
            relative_urls: false,
            branding:false,
            removed_menuitems: 'newdocument',
//            init_instance_callback: "insert_contents",

            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);


        function insert_contents(inst){
            inst.setContent(table);
        }

    </script>

@stop


@endcomponent
