var queue_vue = new Vue({

            el: '#vue-queue',
            data: {
                pid: '',
                p_name: '',
                patient_selected: false,
                assignations: false,
                re_assign: false,
                nawc: false,
                spinner_action_btn:false,

                /* for patient notifications*/
                ls_main_div: false, // notifications last consultation div,
                lc_date: '', // patient notification
                lc_doctor: '', // patient notification
                ff_main_div: false, // patient notification follow-up main div
                ff_doctor: '', // patient notification
                rr_main_div: false, // patient notification referral main div
                refferal_notifications: [],
                ls_notification_show: false, // show or hide green circle along notifications
                ff_notification_show: false, // show or hide blue circle along notifications
                rr_notification_show: false, // show or hide yellow circle along notifications


                /* medical records */

                // consultations records
                medical_records_thead: [],
                consultation_clinic_name: '', // when a consultation is clicked the update clinic name
                consultation_consulted_by: '', // when a consultation is clicked the update doctor name
                consultation_date: '', // when a consultation is clicked the update consultation date
                edit_consultation: false, //  check if user is allowed to edit toggle edit consultation btn on consultation show modal
                create_nurse_notes: false, // toggle nurse notes btn on consultation show modal
                create_nurse_notes_link: '', // show btn to create nurse notes on consultation modal
                edit_consultation_link: '', // show btn to edit the consultation


            },
            methods: {



                /* assign the pid of selected patient */
                patient_check: function (event, pid)
                {
                    if (this.pid != pid){ // check if patient was clicked twice
                        this.pid = pid;
                        this.patient_selected = true; // show all dashboard buttons
                        this.spinner_action_btn = true; //show spinner near action btn
                        this.patient_name(); // get patient name
                        this.queued_action_buttons; // ajax for dashboard buttons
                        this.selected_row(event);
                        this.check_icon(event);
                        this.unselected_row(event);
                        this.patient_has_notifications(); // check if patient has notifications
                    }
                    return;
                },



                /* get patient name for displaying on modal header*/
                patient_name: function()
                {
                    var root_element = this; // root vue this
                    request = $.ajax({
                        url: baseUrl+'/patient_name/'+root_element.pid,
                        type: "get",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        root_element.replace_null(response); // replace null values with ""
                        var full_patient_name = response.last_name+', '+response.first_name+' '+response.suffix+' '+response.middle_name; // full name
                        root_element.p_name = full_patient_name; // assign p_name to full name
                    });
                    return;
                },



                /* modify the selected row */
                selected_row: function (event)
                {
                    //create a background color for the row selected
                    $(event.target).closest('tr').addClass('selected_row');
                    return;
                },



                /* modify unselected <tr> */
                unselected_row: function (event)
                {
                    //select all siblings tr which is not clicked
                    $(event.target).closest('tr').siblings().each(function (index) {
                        $(this).removeClass('selected_row'); // remove the background color of the <tr>
                        var circle_icon = $(this).find('td.selected_icon').find('i.fa') // find the circle icon
                        $(circle_icon).removeClass('fa-check text-green'); // remove check circle icon
                        $(circle_icon).addClass('fa-circle-o text-muted'); // replace with circle text-muted
                        return;
                    });
                },




                /* create check icon */
                check_icon: function (event)
                {
                    var checked_icon = $(event.target).closest('tr').find('td.selected_icon').find('i.fa');
                    $(checked_icon).removeClass('fa-circle-o text-muted');
                    $(checked_icon).addClass('fa-check text-green');
                    return;
                },




                // patient information and vital signs
                patient_information: function()
                {
                    $('#patient_information_modal').modal();
                    $('#patient_information_modal .loaderRefresh').fadeIn(0); // show loader
                    var root_element = this; // root vue this
                    request = $.ajax({
                        url: baseUrl+'/patient_info_vs',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {

                        root_element.replace_null(response); // replace null values with ''

                        var patient_name = response.last_name+', '+response.first_name+' '+response.suffix+' '+response.middle_name; // full name

                        // check if patient is mss classified
                        if(response.mss_id == ''){
                            var mss = 'Unclassified';
                        }else{
                            var mss = response.label+' '+response.description+'%';
                        }

                        /*--------- patient information on table -----*/
                        root_element.$refs.patient_full_name.innerText = patient_name; // assign full name to the table
                        root_element.$refs.hospital_no.innerText = response.hospital_no; // assign hospital_no to the table
                        root_element.$refs.patient_qrcode.innerText = response.barcode; // assign barcode to the table
                        root_element.$refs.patient_birthday.innerText = dateCalculate(response.birthday); // assign patient_birthday to the table
                        root_element.$refs.patient_address.innerText = response.address; // assign patient_address to the table
                        root_element.$refs.patient_sex.innerText = response.sex; // assign patient_sex to the table
                        root_element.$refs.patient_civil_status.innerText = response.civil_status; // assign patient_civil_status to the table
                        root_element.$refs.patient_mss.innerText = mss; // assign patient_mss to the table
                        root_element.$refs.patient_date_reg.innerText = dateCalculate(response.date_reg); // assign patient_date_reg to the table

                        /*--------- vital signs details ---------*/
                        root_element.$refs.bp.innerText = response.blood_pressure; //blood pressure
                        root_element.$refs.pr.innerText = response.pulse_rate; // pulse_rate
                        root_element.$refs.rr.innerText = response.respiration_rate; // respiration_rate
                        root_element.$refs.bt.innerText = response.body_temperature; // body_temperature
                        root_element.$refs.weight.innerText = response.weight; // weight
                        root_element.$refs.height.innerText = response.height; // height

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_information_modal .loaderRefresh').fadeOut('fast')
                    });
                    return;
                },


                /* replace null values with '' */
                replace_null: function(response)
                {
                    Object.keys(response).forEach(function(key){
                        if(response[key] === null){
                            response[key] = '';
                        }
                    });
                },






                /* show active doctors */
                patient_assignation: function()
                {
                    $('#patient_assignation_modal .loaderRefresh').fadeIn(0);
                    $('#patient_assignation_modal').modal(); // show assigantions modal
                    $('#assignations_tbody').empty(); // empty assignation tbody

                    var root_element = this; // the parent element

                    request = $.ajax({
                        url: baseUrl+'/assign_to_doctor',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if(response.length > 0){  // if active doctors has been found
                            $.each(response, function(index, value){
                                root_element.replace_null(response[index]); // replace null values

                                var serving = (response[index].serving)? 'bg-green' : ''; // for serving bg-color
                                var pending = (response[index].pending)? 'bg-orange' : ''; // for pending bg-color
                                var nawc = (response[index].nawc)? 'bg-red' : ''; // for nawc bg-color
                                var finished = (response[index].finished)? 'bg-blue' : ''; // for finished bg-color
                                var paused = (response[index].paused)? 'bg-brown' : ''; // for paused bg-color

                                /*-- generate tbody for assignation --*/
                                var tr = $('<tr onclick="assign_to_doctor_now('+response[index].id+')">');
                                var td1 = $('<td>').text(index + 1);
                                var online_icon = $('<i class="fa fa-circle text-green">');
                                var td2 = $('<td>').text(' Online').prepend(online_icon);
                                var td3 = $('<td class="text-uppercase text-primary">').text('DR. '+response[index].last_name+', '
                                                    +response[index].first_name+' '+response[index].middle_name); // doctors name
                                var td4 = $('<td class="'+serving+'">').text(response[index].serving); // number of serving
                                var td5 = $('<td class="'+pending+'">').text(response[index].pending); // number of pending
                                var td6 = $('<td class="'+nawc+'">').text(response[index].nawc); // number of nawc
                                var td7 = $('<td class="'+paused+'">').text(response[index].paused); // number of paused
                                var td8 = $('<td class="'+finished+'">').text(response[index].finished); // number of finished

                                $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8); // append all td to tr

                                $('#assignations_tbody').append(tr); // append tr to tbody
                            })
                        }else{
                            // if no active doctors found
                            var td = $('<td colspan="8" class="bg-red text-center">').text('Sorry, no active doctors found.');
                            var tr = $('<tr>').append(td);
                            $('#assignations_tbody').append(tr); // append tr to tbody
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_assignation_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },





                // queue assigning to doctor
                assign_now: function(doctors_id)
                {
                    var ans = confirm('Do you really want to assign this patient to this doctor.');
                    if(ans){
                        $('.full_window_loader').fadeIn(0);
                        request = $.ajax({
                            url: baseUrl+'/assign_now',
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'pid':this.pid,'doctors_id':doctors_id},
                        });
                        request.done(function (response, textStatus, jqXHR) {
                            toast('info', 'Patient successfully assigned');
                            location.reload();
                        });
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                        });
                        request.always(function(){
                            $('#patient_assignation_modal .loaderRefresh').fadeOut('fast');
                        });
                    }
                    return;
                },




                // queue re assigning to doctor
                re_assign_now: function(doctors_id)
                {
                    var ans = confirm('Do you really want to re-assign this patient to another doctor.');
                    if(ans){
                        request = $.ajax({
                            url: baseUrl+'/re_assign_now', // send ajax to re-assign
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'pid':this.pid,'doctors_id':doctors_id},
                        });
                        request.done(function (response, textStatus, jqXHR) {
                            toast('info', 'Patient successfully re-assigned');
                            location.reload();
                        });
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                        });
                        request.always(function(){
                            $('#patient_assignation_modal .loaderRefresh').fadeOut('fast');
                        });
                    }
                    return;
                },



                /* remove queued patient when NAWC is clicked*/
                remove_queued_patient: function () {
                    var ans = confirm('Do you really want to remove this patient from the queue.');
                    if(ans){
                        request = $.ajax({
                            url: baseUrl+'/remove_queued_patient',
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {'pid':this.pid},
                        });
                        request.done(function (response, textStatus, jqXHR) {
                            toast('error', 'Patient has been removed');
                            location.reload();
                        });
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                        });
                    }
                    return;
                },


                /* patient re-assignation when re=-assign is clicked */
                patient_re_assignation: function () {

                    $('#patient_re_assignation_modal .loaderRefresh').fadeIn(0);
                    $('#patient_re_assignation_modal').modal(); // show assigantions modal
                    $('#re_assignations_tbody').empty(); // empty assignation tbody

                    var root_element = this; // the parent element

                    request = $.ajax({
                        url: baseUrl+'/re_assign_patient',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        if(response.length > 0){  // if active doctors has been found
                            $.each(response, function(index, value){
                                root_element.replace_null(response[index]); // replace null values

                                var serving = (response[index].serving)? 'bg-green' : ''; // for serving bg-color
                                var pending = (response[index].pending)? 'bg-orange' : ''; // for pending bg-color
                                var nawc = (response[index].nawc)? 'bg-red' : ''; // for nawc bg-color
                                var finished = (response[index].finished)? 'bg-blue' : ''; // for finished bg-color
                                var paused = (response[index].paused)? 'bg-brown' : ''; // for paused bg-color

                                /*-- generate tbody for assignation --*/
                                var tr = $('<tr onclick="re_assign_to_doctor_now('+response[index].id+')">');
                                var td1 = $('<td>').text(index + 1);
                                var online_icon = $('<i class="fa fa-circle text-green">');
                                var td2 = $('<td>').text(' Online').prepend(online_icon);
                                var td3 = $('<td class="text-uppercase text-primary">').text('DR. '+response[index].last_name+', '
                                    +response[index].first_name+' '+response[index].middle_name); // doctors name
                                var td4 = $('<td class="'+serving+'">').text(response[index].serving); // number of serving
                                var td5 = $('<td class="'+pending+'">').text(response[index].pending); // number of pending
                                var td6 = $('<td class="'+nawc+'">').text(response[index].nawc); // number of nawc
                                var td7 = $('<td class="'+paused+'">').text(response[index].paused); // number of paused
                                var td8 = $('<td class="'+finished+'">').text(response[index].finished); // number of finished

                                $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8); // append all td to tr

                                $('#re_assignations_tbody').append(tr); // append tr to tbody
                            })
                        }else{
                            // if no active doctors found
                            var td = $('<td colspan="8" class="bg-red text-center">').text('Sorry, no active doctors found.');
                            var tr = $('<tr>').append(td);
                            $('#re_assignations_tbody').append(tr); // append tr to tbody
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#patient_re_assignation_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },


                // upon clicking patient check if it has some notifications
                patient_has_notifications: function()
                {
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/patient_notifications',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        // set circle notification hidden
                        root_element.ls_notification_show = false;
                        root_element.ff_notification_show = false;
                        if (response['notifications'].length > 0) { // check if last consultation and follow-up is empty
                            if (response['notifications'][0].lc_date){
                                root_element.ls_notification_show = true; // if a last consultation has been found
                            }
                            if (response['notifications'][0].ff_last_name){
                                root_element.ff_notification_show = true; // if today`s follow up is set
                            }
                        }
                        if (response['referrals'].length > 0){ // check if referrals is empty
                            root_element.rr_notification_show = true; // if referrals from other clinic found
                        }else{
                            root_element.rr_notification_show = false;
                        }
                    });
                    return;
                },



                patient_notification:function () {
                    $('#notifications_modal').modal();
                    $('#notifications_modal .loaderRefresh').fadeIn(0);
                    var root_element = this; // the parent element
                    request = $.ajax({
                        url: baseUrl+'/patient_notifications',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        console.log(response);

                        /* set all elements as empty */
                        root_element.ls_main_div = false;
                        root_element.lc_date = ''; // last consultation date
                        root_element.lc_doctor = ''; // doctor name
                        root_element.ff_main_div = false;
                        root_element.ff_doctor = ''; // doctor name

                        if (response['notifications'].length > 0) { // check if last consultation and follow-up is empty
                            if (response['notifications'][0].lc_date){
                                root_element.ls_main_div = true;
                                root_element.lc_date =
                                    dateCalculate(response['notifications'][0].lc_date); // last consultation date
                                root_element.lc_doctor =
                                    'DR. '+response['notifications'][0].lc_last_name+', '
                                    +response['notifications'][0].lc_first_name // doctor name
                            }
                            if (response['notifications'][0].ff_last_name){
                                root_element.ff_main_div = true;
                                root_element.ff_doctor = 'DR. '+response['notifications'][0].ff_last_name+', '
                                    +response['notifications'][0].ff_first_name // doctor name

                            }
                        }

                        if (response['referrals'].length > 0){ // check if referrals is empty
                            root_element.rr_main_div = true;
                            root_element.refferal_notifications = response['referrals'];
                        }else{
                            root_element.rr_main_div = false;
                            root_element.refferal_notifications =[];
                        }


                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#notifications_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },
                
                
                
                
                /* start medical records */
                
                //get all consultation records of this patient 
                consultation_records: function () {
                    var root_element = this; // the parent element
                    $('#medical_records_modal').modal(); // show modal
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic / Department', 'Consulted / Assisted By', 'Date', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/get_all_consultation_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {


                        $.each(response, function (index) { // loop through consultation records
                            root_element.replace_null(response[index]); //replace null values
                            // check if a doctor or other role who saved this consultation
                           var ext = (response[index].role == 7)? 'DR. ' : '';
                            //create view consultation btn
                           var show_consultation_btn = $('<a class="btn btn-flat btn-sm bg-green" ' +
                               'onclick="show_consultation_now('+response[index].cid+')">').text('View Consultation');
                           var tr = $('<tr>');
                           var td1 = $('<td class="text-uppercase">').text(response[index].name); // clinic name
                            // doctors name or the person who saved the consultation will appear here
                           var td2 = $('<td class="text-uppercase text-blue text-bold">').text(
                               ext+' '+response[index].last_name+', '+response[index].first_name+' '+
                               response[index].middle_name);
                           // date when the consultation was saved
                           var td3 = $('<td>').text(dateCalculate(response[index].created_at));
                           var td4 = $('<td>').append(show_consultation_btn);  // append consultation btn
                            $(tr).append(td1,td2,td3,td4);
                           $('#medical_records_tbody').append(tr);
                        });

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },


                //get all referral records of this patient
                referral_records: function () {
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['From Clinic', 'Referred By', 'To Clinic', 'Referred To', 'Reason',
                        'Status', 'Date', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/get_all_referral_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        $.each(response, function (index) { // loop through referral records
                            root_element.replace_null(response[index]); //replace null values
                            //create edit referral btn
                            var edit_btn = $('<a class="btn btn-flat btn-sm bg-blue">').text('Edit');
                            // referred to doctor
                            var to_doctor = (response[index].rt_last_name)? response[index].rt_last_name+', '+
                                            response[index].rt_first_name+' '+response[index].rt_middle_name : '';
                            // check referral status
                            if(response[index].status == 'F'){
                                var text_status = 'Finished';
                                var label_color = 'label-info';
                            }else{
                                var text_status = 'Pending';
                                var label_color = 'label-warning';
                            }
                            // referral status
                            var label_status = $('<span class="label '+label_color+'">').text(text_status);
                            var tr = $('<tr>');
                            var td1 = $('<td class="text-uppercase">').text(response[index].name); // clinic name
                            // doctors name or the person who saved the consultation will appear here
                            var td2 = $('<td class="text-uppercase text-blue text-bold">').text(
                                            response[index].last_name+', '+response[index].first_name+' '+
                                            response[index].middle_name);
                            var td3 = $('<td>').text(response[index].rt_clinic); //referred to clinic
                            // referred to doctor
                            var td4 = $('<td class="text-uppercase text-blue text-bold">').text(to_doctor);
                            var td5 = $('<td>').text(response[index].reason); // reason of referral
                            var td6 = $('<td>').append(label_status); // reason of referral
                            // date when the referral was saved
                            var td7 = $('<td>').text(dateCalculate(response[index].created_at));
                            var td8 = $('<td>').append(edit_btn);  // append consultation btn
                            $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8);
                            $('#medical_records_tbody').append(tr);
                        });

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },




                //get all followup records of this patient
                followup_records: function () {
                    var root_element = this; // the parent element
                    $('#medical_records_modal .loaderRefresh').fadeIn(0);
                    $('#medical_records_tbody').empty(); // empty tbody contents
                    // show consultation thead
                    this.medical_records_thead = ['Clinic', 'Consulted By', 'Follow-up To', 'Reason', 'Status',
                                                'FF Date', 'Action'];
                    request = $.ajax({
                        url: baseUrl+'/get_all_followup_records',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':root_element.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        console.log(response);
                        $.each(response, function (index) { // loop through referral records
                            root_element.replace_null(response[index]); //replace null values
                            //create edit referral btn
                            var edit_btn = $('<a class="btn btn-flat btn-sm bg-blue">').text('Edit');
                            // referred to doctor
                            var to_doctor = (response[index].ft_last_name)? response[index].ft_last_name+', '+
                                response[index].ft_first_name+' '+response[index].ft_middle_name : '';
                            // check referral status
                            if(response[index].status == 'F'){
                                var text_status = 'Finished';
                                var label_color = 'label-info';
                            }else{
                                var text_status = 'Pending';
                                var label_color = 'label-warning';
                            }
                            // referral status
                            var label_status = $('<span class="label '+label_color+'">').text(text_status);
                            var tr = $('<tr>');
                            var td1 = $('<td class="text-uppercase">').text(response[index].name); // clinic name
                            // doctors name or the person who saved the consultation will appear here
                            var td2 = $('<td class="text-uppercase text-blue text-bold">').text(
                                response[index].last_name+', '+response[index].first_name+' '+
                                response[index].middle_name);
                            // referred to doctor
                            var td3 = $('<td class="text-uppercase text-blue text-bold">').text(to_doctor);
                            var td4 = $('<td>').text(response[index].reason); // reason of referral
                            var td5 = $('<td>').append(label_status); // reason of referral
                            // date when the referral was saved
                            var td6 = $('<td>').text(dateCalculate(response[index].followupdate));
                            var td7 = $('<td>').append(edit_btn);  // append consultation btn
                            $(tr).append(td1,td2,td3,td4,td5,td6,td7);
                            $('#medical_records_tbody').append(tr);
                        });

                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#medical_records_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },



                //show the consultation of this patient
                show_consultation: function ($id) {

                    var root_element = this; // the parent element
                    $('#consultation_show_modal').modal();
                    $('#consultation_show_modal .loaderRefresh').fadeIn(0);

                    request = $.ajax({
                        url: baseUrl+'/show_consultation',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'id':$id},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        console.log(response)
                        $('#consultation_show_wrapper').html(response.consultation);

                        if(authenticate == response.users_id){ // check if user is allowed to edit (receptionist or doctor)
                            root_element.edit_consultation = true; // show edit consultation btn
                            //  create link for edit consultation
                            root_element.edit_consultation_link = baseUrl+'/edit_consultation/'+response.cid;
                        }else{
                            root_element.edit_consultation = false;  // hide edit consultation btn
                            root_element.edit_consultation_link = '#'; //  create link for edit consultation #
                        }
                        if(auth_role == 5 || auth_role == 6){ // check if user role is receptionist or nurse then show nurse notes btn
                            root_element.create_nurse_notes = true; // show nurse notes btn
                            //  create link for nurse notes
                            root_element.create_nurse_notes_link = baseUrl+'/create_nurse_notes/'+response.cid;
                        }else{
                            root_element.create_nurse_notes = false; // hide nurse notes btn
                            root_element.create_nurse_notes_link = '#'; // create link for nurse notes #
                        }
                        // add (DR) if the user who created the consultation is doctor or receptionist
                        var ext = (response.role == 7)? 'DR. ' : '';
                        // when a consultation is clicked the update clinic name
                        root_element.consultation_clinic_name = response.name;
                        // when a consultation is clicked the update doctor name
                        root_element.consultation_consulted_by =
                            ext+' '+response.last_name+', '+response.first_name+' '+response.middle_name;
                        // when a consultation is clicked the update doctor name
                        root_element.consultation_date = dateCalculate(response.created_at)
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        $('#consultation_show_modal .loaderRefresh').fadeOut('fast');
                    });
                    return;
                },
                
                
                /* end medical records */


                write_nurse_notes: function () {

                }
                
                



            }, // end of methods




            computed:{

                queued_action_buttons: function()
                {
                    var root_element = this;
                    request = $.ajax({
                        url: baseUrl+'/queued_action_buttons',
                        type: "post",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'pid':this.pid},
                        dataType: "json"
                    });
                    request.done(function (response, textStatus, jqXHR) {
                        console.log(response.queue)
                        if(response.queue.status == 'F'){ //Finished consultation
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'S'){ // Serving patient
                            root_element.assignations = false;
                            root_element.re_assign = false;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'C'){ // NAWC patient
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'H'){ // Paused patient
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else if(response.queue.status == 'P'){ // Pending patient
                            root_element.assignations = false;
                            root_element.re_assign = true;
                            root_element.nawc = false;
                        }else{                                  // Unassigned patient
                            root_element.assignations = true;
                            root_element.re_assign = false;
                            root_element.nawc = true;
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                    });
                    request.always(function(){
                        root_element.spinner_action_btn = false;
                    });
                    return;
                }
            }, // end of computed properties


            filters: {
                capitalize: function (value) {
                    if (!value) return '';
                    return value.toString().toUpperCase();
                }
            }





})





/*-- when <tr> is clicked for assignation */
function assign_to_doctor_now(doctors_id)
{
    queue_vue.assign_now(doctors_id); // locate vue method
}


/*-- when <tr> is clicked for re_assignation */
function re_assign_to_doctor_now(doctors_id)
{
    queue_vue.re_assign_now(doctors_id); // locate vue method
}

// $id is consultation id
function show_consultation_now($id) {
    queue_vue.show_consultation($id);
}









