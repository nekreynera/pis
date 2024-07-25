//bptest();

let btn_scope = '';
let runningModal = 0;
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
    '<td valign="top" style="width:90px;" id="doctors" class="mceEditable">' +
    ''+today+''+
    '</td>' +
    '<td valign="top" style="width:330px;height: 668px" id="doctors" class="mceEditable"><span id="uniqueId">&nbsp;</span></td>' +
    '<td valign="top" style="width:130px;" class="mceEditable"></td>' +
    '</tr>' +
    '</tbody>' +
    '</table>';

let tiny_baseurl = document.getElementById('baseurl-tinymce').value;

var ed = tinyMCE.activeEditor;
tinymce.init({
    path_absolute : tiny_baseurl+"/",
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
    // templates: [
    //     {title: 'Doctors Consultation', description: 'Doctors Consultation Form', content: table}
    // ],
    tabfocus_elements: "button",
    insertdatetime_formats: ["%b %d, %Y %H:%M %p", "%b %d, %Y", "%I:%M:%S %p", "%D"],
    table_toolbar: false,
    relative_urls: false,
    branding:false,
    removed_menuitems: 'newdocument',
    height : "740",
    save_onsavecallback : "ajaxSave",
    init_instance_callback: "insert_contents",
    setup : function(ed) {
      ed.on('BeforeAddUndo', function(e) {
        return false;
      });
    }
});


function ajaxSave() {
    let content = runningModal == 1 ? tinyMCE.get('diagnosis').getContent() : tinyMCE.get('diagnosis2').getContent();
    let pid = $('.hidden-id').val();
    console.log('id: ', pid);
    openLoader();
    console.log(btn_scope);
    console.log('content: ',content);
    $.ajax({
        url: baseUrl+"/saveChiefComplaintAjax",
        type: "POST",
        data: {
            pid:pid,
            consultation:content,
            runningModal:runningModal
        },
        cache: false,
        dataType: "JSON",
        success: function(data) {
            console.log('success response get id: ', data);
            // "btn_scope" get from patientinfo.js
            runningModal == 1 ? $(btn_scope).attr('id', data.id).removeClass('btn-chiefcomplaint-modal').addClass('btn-rcptnconsultationDetails-modal') : '';
            runningModal == 1 ? $("#chiefcomplaint-modal").modal('toggle') : '';
            data == 0 ? toastr.success('Nurse notes successfully saved.') : toastr.success('Consultation successfully saved.');
            closeLoader();
            consultationAjax(pid,btn_scope);
        },
        error: function(data) {
            console.log('error response: ', data);
            closeLoader();
        }
    });
}

    function consultationAjax(id,btn_scope)
    {
        $.ajax({
            url: baseUrl+"/rcptn_consultationDetailsAjax",
            type: "POST",
            data: {
                id:id
            },
            cache: false,
            dataType: "JSON",
            success: function(data) {
                console.log('success response: ', data);

                let icd_codes = '';
                $('.btn-print-notes').attr('href', baseUrl+'/printNurseNotes/'+data[0].id);
                // $('.btn-nurse-notes').attr('href', baseUrl+'/nurseNotes/'+data[0].id);
                $('.hidden-id').val(data[0].id);
                $('.rcptn-consultation-show').show().html(data[0].consultation);
                $('.rcptn-lastname').text(data[2].last_name);
                $('.rcptn-firstname').text(data[2].first_name);
                $('.rcptn-civilstatus').text(data[2].civil_status ? data[2].civil_status : '');
                $('.rcptn-address').text(data[2].address);
                $('.rcptn-middlename').text(data[2].middle_name);
                date = new Date(data[2].birthday);
                day = date.getDate() > 9 ? date.getDate() : '0'+date.getDate();
                $('.rcptn-birthday').text(date.getMonth() + ' ' + day + ', ' +  date.getFullYear());
                $('.rcptn-age').text(data[2].age);
                $('.rcptn-contact').text(data[2].contact_no ? data[2].contact_no : '');

                if(data[4].length > 0)
                {
                    $('.diagnosisWrapper').show();
                    data[4].forEach((icd_code) => {
                        icd_codes += '<div class="form-group input-group">\
                                            <input type="text" class="form-control" value="'+icd_code.description+'" readonly="" />\
                                            <span class="input-group-addon">\
                                                <i class="fa fa-trash-o"></i>\
                                            </span>\
                                        </div>';
                    });

                    $('.icd_codes').append(icd_codes);
                    console.log('icd codes: ', icd_codes);
                }

                let wrapper = '';
                let wrapperContent = '';
                let uploadedFileConsultation = '';
                let imagePreviewModal = '';
                $('.upload_files').empty();
                if(typeof data[1].files != 'undefined')
                {
                    uploadedFileConsultation = '<div class="">\
                                                <br>\
                                                <br>\
                                                <h2 class="">Uploaded Files for this Consultation</h2>\
                                                <br>\
                                                <div class="bg-danger filesWrapper">';
                    imagePreviewModal = '<div class="modal fade" id="imagePreview" tabindex="-1" role="dialog" aria-labelledby="imagePreview" aria-hidden="true">\
                                                <div class="modal-dialog modal-xxl colorless" role="document">\
                                                    <div class="modal-content colorless">\
                                                        <div class="modal-header">\
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1">\
                                                                <span class="text-danger">&times;</span>\
                                                            </button>\
                                                        </div>\
                                                        <div class="modal-body colorless">\
                                                            <div class="row colorless">\
                                                                <div class="col-md-8">\
                                                                    <img src="" id="showImage" alt="Failed to load image." class="img-responsive center-block" />\
                                                                </div>\
                                                                <div class="col-md-4 imageDescWrapper">\
                                                                    <div class="form-group">\
                                                                        <label for="">Title</label>\
                                                                        <input type="text" class="form-control" readonly id="showTitle" />\
                                                                    </div>\
                                                                    <div class="form-group">\
                                                                        <label for="">Description</label>\
                                                                        <textarea id="showDescription" cols="30" rows="10" class="form-control" readonly style="background-color: transparent"></textarea>\
                                                                    </div>\
                                                                    <br>\
                                                                </div>\
                                                            </div>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                            </div>';

                    data[1].files.forEach((file) => {

                        let fileType = ['doc','docx','txt','xlsx','xls','pdf','ppt','pptx'];
                        let filename = file.filename.split('.');
                        wrapper += '<div class="imgWrapperPreview">';
                        if(filetype.includes(filename[1]))
                        {
                            wrapperContent = '<img src="'+data[3].directory+file.filename+'" alt="" class="img-responsive" width="100%" />\
                                            <a href="" class="btn btn-primary btn-circle viewImage" data-placement="top" data-toggle="tooltip" title="View this file?">\
                                                <i class="fa fa-image"></i>\
                                            </a>';
                        }
                        else
                        {
                            if(filename[1] == 'doc' || filename[1] == 'docx')
                            {
                                wrapperContent = '<img src="'+baseUrl+'/public/images/mswordlogo.svg" alt="" class="img-responsive" />';
                            }
                            else if(filename[1] == 'xlsx' || filename[1] == 'xls')
                            {
                                wrapperContent = '<img src="'+baseUrl+'/public/images/excellogo.svg" alt="" class="img-responsive" />';
                            }
                            else if(filename[1] == 'ppt' || filename[1] == 'pptx')
                            {
                                wrapperContent = '<img src="'+baseUrl+'/public/images/powerpointlogo.svg" alt="" class="img-responsive" />';
                            }
                            else if(filename[1] == 'pdf')
                            {
                                wrapperContent = '<img src="'+baseUrl+'/public/images/pdflogo.svg" alt="" class="img-responsive" />';
                            }
                            else
                            {
                                wrapperContent = '<img src="'+baseUrl+'/public/images/textlogo.svg" alt="" class="img-responsive" />';
                            }
                            wrapperContent += '<a href="{{ $directory.$file->filename }}" target="_blank" class="btn btn-info btn-circle" data-placement="top" data-toggle="tooltip" title="Open this file?">\
                                                    <i class="fa fa-file-text-o"></i>\
                                                </a>';
                        }
                        wrapperContent += '<input type="hidden" value="'+file.title+'" class="title" />\
                                            <textarea hidden class="description">'+file.description+'</textarea>';
                        wrapper += wrapperContent+'</div>';

                    });
                    uploadedFileConsultation += wrapper+'div'+imagePreviewModal+'div';
                    $('.upload_files').append(uploadedFileConsultation);
                }
                closeLoader();
            },

            error: function(data) {
                closeLoader();
                console.log('error response: ', data);
            }
        });
    }

function insert_contents(inst){
    inst.setContent(table);
}