var d = new Date();
var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
var month = days[d.getMonth()];
var day = d.getDate();
var year = d.getFullYear();
var hour = d.getHours();
var min = d.getMinutes();
if(hour < 10){
    hour = '0'+hour;
}
if(min < 10){
    min = '0'+min;
}
var today = month+' '+day+', '+year+' '+hour+':'+min;

var table = '<table id="teddy" class="table table-bordered" style="border-collapse:collapse; width:100%;height:1200px;" border="1">' +
    '<thead>' +
    '<tr style="background-color: #ccc;width: 400pxnote">' +
    '<th style="padding:5px;width:90px;text-align:center" class="mceNonEditable">DATE/TIME</th>' +
    '<th style="padding:5px;width:330px;text-align:center" class="mceNonEditable">DOCTOR\'S CONSULTATION</th>' +
    '<th style="padding:5px;width:130px;text-align:center" class="mceNonEditable">NURSE\'S NOTES</th>' +
    '</tr>' +
    '</thead>' +
    '<tbody>' +
    '<tr style="width: 300px;">' +
    '<td valign="top" style="width:90px;" id="doctors" class="mceEditable">'+today+'</td>' +
    '<td valign="top" style="width:330px;height: 668px" id="doctors" class="mceEditable"><span id="uniqueId">&nbsp;</span></td>' +
    '<td valign="top" style="width:130px;" class="mceEditable"></td>' +
    '</tr>' +
    '</tbody>' +
    '</table>';
var ed = tinyMCE.activeEditor;
tinymce.init({
    path_absolute : baseUrl+"/",
    selector: "textarea.my-editor",
    plugins: [
        "autosave save insertdatetime advlist lists charmap preview hr tabfocus",
        "searchreplace wordcount fullscreen",
        "insertdatetime nonbreaking directionality",
        "emoticons template paste textcolor colorpicker textpattern noneditable preventdelete"
    ],
    toolbar: "save | insertdatetime | insertfile | styleselect fontsizeselect forecolor backcolor |" +
    " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
    "outdent indent | link media emoticons",

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
    //init_instance_callback: "insert_contents",
    setup : function(ed) {
      ed.on('BeforeAddUndo', function(e) {
        return false;
      });
    }
});