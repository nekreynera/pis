var table = '<table class="table table-bordered" style="border-collapse:collapse; width:100%;height:1200px;" border="1">' +
    '<thead>' +
    '<tr style="background-color: #ccc;width: 400px">' +
    '<th style="padding:5px;width:90px;text-align:center">DATE/TIME</th>' +
    '<th style="padding:5px;width:330px;text-align:center">DOCTOR\'S CONSULTATION</th>' +
    '<th style="padding:5px;width:130px;text-align:center">NURSE\'S NOTES</th>' +
    '</tr>' +
    '</thead>' +
    '<tbody>' +
    '<tr style="width: 300px;">' +
    '<td valign="top" style="width:90px;" id="dateAndTime"></td>' +
    '<td valign="top" style="width:330px;height: 668px"></td>' +
    '<td valign="top" style="width:130px;"></td>' +
    '</tr>' +
    '</tbody>' +
    '</table>';
var editor_config = {
    path_absolute : baseUrl+"/",
    selector: "textarea.my-editor",
    plugins: [
        "autosave save advlist lists charmap print preview hr tabfocus",
        "searchreplace wordcount fullscreen",
        "insertdatetime nonbreaking directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "undo redo | save | insertdatetime insertfile | styleselect fontsizeselect forecolor backcolor |" +
    " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
    "outdent indent ltr rtl | link media emoticons",

    fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",

    tabfocus_elements: "button",
    insertdatetime_formats: ["%b %d, %Y %H:%M %p", "%b %d, %Y", "%I:%M:%S %p", "%D"],
    table_toolbar: false,
    relative_urls: false,
    branding:false,
    removed_menuitems: 'newdocument',
    templates: [
        {title: 'Doctors Consultation', description: 'Doctors Consultation Form', content: table}
    ],

};

tinymce.init(editor_config);





