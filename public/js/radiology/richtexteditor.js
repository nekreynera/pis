var ed = tinyMCE.activeEditor;
tinymce.init({
    path_absolute : baseUrl+"/",
    selector: "textarea.my-editor",
    plugins: [
        "autosave save insertdatetime advlist lists charmap preview hr tabfocus table",
        "searchreplace wordcount fullscreen",
        "insertdatetime nonbreaking directionality",
        "emoticons template paste textcolor colorpicker textpattern noneditable preventdelete"
    ],
    toolbar: "save | insertdatetime | insertfile | styleselect fontsizeselect forecolor backcolor |" +
    " bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | " +
    "outdent indent | link media emoticons",

    fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
    /*templates: [
        {title: 'Breast Ultrasound', description: 'ULTRASOUND OF THE BREASTS INCLUDE AXILLARY REGION', content: breast},
        {title: 'Cardiac Ultrasound', description: 'Cardiac Ultrasound', content: cardiac}
    ],*/
    tabfocus_elements: "button",
    insertdatetime_formats: ["%b %d, %Y %H:%M %p", "%b %d, %Y", "%I:%M:%S %p", "%D"],
    relative_urls: false,
    branding:false,
    removed_menuitems: 'newdocument',
    //init_instance_callback: "insert_contents",
});



function setContent($scope){
    var category = {
        'ul5':ul5,
        'ul6':ul6,
        'ul7':ul7,
        'x122':x122,
        'apicolordic':apicolordic,
        'ul8':ul8,
        'ul9':ul9,
        'ul11':ul11,
        'ul15':ul15,
        'ul16':ul16,
        'ul14':ul14,
        'ul108':ul108,
        'ul112':ul112,
        'ul116':ul116,
        'ul13':ul13,
        'ul12':ul12,
        'ul118':ul118,
        'x119':x119,
        'x230':x230,
        'x120':x120,
        'x123':x123,
        'x206':x206,
        'x135':x135,
        'x229':x229,
        'normalChestAge':normalChestAge,
        'normalChestPleural':normalChestPleural,
        'x133':x133,
        'normalChestTrauma':normalChestTrauma,
        'normalChest':normalChest,
        'x136':x136,
        'x138':x138,
        'x121':x121,
        'x223':x223,
        'x134':x134
    };
    tinymce.activeEditor.setContent(category[$scope]);
}


















