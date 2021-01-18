var showed_green_thing = false;

var listening = false;

var q;

var interositer = 0;

var counter = 0;

var checking = false;

var authwindow = false;

var host = window.location.hostname;

var INTERVAL;

var COUNTDOWN = 0;

// define these in main body (base)

//var ALLSCRIPTS = ''; // token
var EPIC = ''; // token

var PatientId;

var PATIENT;

var DEVICE;

var MEDICATION;

var DIV;

var ADVERSE_OPEN = false;

if (host === 'trackmyapp.us') {

    COUNTDOWN = 180;

}

var countdown = COUNTDOWN;

$(function() {

    if (!listening) {

        ActivateListeners();

    }


});

setTimeout(function() {
    ActivateListeners();
}, 4000);
function setHeader(xhr) {
    console.log("Setting Header");
    xhr.setRequestHeader('Accept', 'application/json+fihr;charset=UTF-8');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', 'Bearer ' + EPIC);
}
function viewerbox(item) {

    $('.top-left-crumb').hide();

    $('#modal-iframe').attr('src', '/view/' + item);

    $('#modal-box').show();

    $('.close-modal-box-button').show();

}
function viewerbox_ex(item, udi) {

    $('.top-left-crumb').hide();

    $('#modal-iframe').attr('src', '/view/' + item + '?udi=' + udi);

    $('#modal-box').show();

    $('.close-modal-box-button').show();

}
function ActivateListeners() {

    if (listening) {
        return;
    }

    if (! showed_green_thing) {
        showed_green_thing = true;
        searchHere();
    }

    if (countdown > 0) {

        INTERVAL = setInterval(function () {

            countdown = countdown - 4;

            console.log(countdown);

            if (countdown < 4 && countdown > -4) {
                window.location.href = "/logout";
            }

        }, 4096);

    }

    console.log('Activating Listeners!');
    listening = true;
    $('#fos_user_registration_form_plainPassword_first').on('change', function() {

        isOkiDoki();

    });
    $('#fos_user_registration_form_plainPassword_second').on('change', function() {

        isOkiDoki();

    });
    $('#title').on('change', function() {

        isOkiDoki();


    });

    $(document).ready(function () {
        $(".navbar-nav li").click(function(event) {
            $(".navbar-collapse").collapse('hide');
        });
    });


    $('#search_q').on('keypress', function(e) {

        if (e.which == 13) {

            e.preventDefault();

            $('.btn-search').click();
        }

    });


    $('body').on('keypress ', function() {

        countdown=COUNTDOWN;

    });
    $(document).on("click", function(e) {

        countdown=COUNTDOWN;


    });

    $('#show_search_q').on('keypress', function(e) {

        $('search-form').show();

        if (e.which == 13) {

            e.preventDefault();

            $('#no-results').hide();

            $('#search-form').show();

            $('.close-search-box-button').show();

            $('#search_q').val(

                $('#show_search_q').val()

            );


            //console.log("-----------");
            //console.log($('#show_search_q').val());
            //console.log("-----------");
            //console.log($('#search_q').val());
            //console.log("-----------");

            setTimeout(function() {

                $('.btn-search').click();

            },100);

        }

    });

    $('.btn-search').on('click', function(e) {

        $('.search-real').show();
        $('.search-show').hide();

        e.preventDefault()

        $('#no-results').hide();

        preloader_on();

        q = $('#search_q').val();

        var type = $(this).attr('rel');

        var limit = 50; // add to settings

        $.ajax('/api/q', {

            data: {
                'type': type,
                'limit': limit,
                'q': q,

            },
            dataType: 'text',
            type: 'post',
            context: this,
            success: function(result,status,xhr) {

                $('#search-results').html(MEprocess(result));

                $('#no-results').show();

                preloader_off();

            },
            error: function(xhr,status,error) {

                console.log('### ERROR ###');
                console.log(status);
                console.log(error);

                q = $('#search_q').val();

                $('#search-results')
                    .html("<br/>" +
                        "<h4>No Results Found <br/><small>"+q+"</small></h4>" +
                        "" +
                        ""
                    );
                $('#no-results').show();

                preloader_off();

            }

        });

    });

    $('.homepage-button').on('click', function() {

        preloader_on();

        var rel=jQuery(this).attr('rel');

        console.log(rel);

        if (rel==='my-devices-epic') {

            $('.close-my-devices-button').show();
            $('.search-show').hide();
            $('.homepage-buttons').hide();

            $('#display-area').html('Locating devices for ' + EPIC_ID);

            var baseUrl = "https://apporchard.epic.com/interconnect-aocurprd-oauth/api/FHIR/DSTU2/";
            //var baseUrl = "https://apporchard.epic.com/FHIR/api/FHIR/DSTU2/";

            var deviceSearchString = "Device?patient=" + EPIC_ID + "";

            //https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/Device?patient=Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB"

            $.ajax({
                url: '/epic-call',
                type: 'POST',
                dataType: 'json',
                data: {
                    url: baseUrl + deviceSearchString,
                    EPIC: EPIC
                },
                success: function(data,status,xhr) {
                    console.log(data);
                    //alert(data);
                    $.ajax('/store-device/test/' + user_id, {
                        type: 'post',
                        data: {
                            'json': '["10888628003507","10888628003637"]',
                        },
                        success: function () {
                            alert('Device Data Updated Successfully');
                        },
                        error: function () {
                            alert('Error storing device');
                        }
                    });
                },
                error: function() { alert('No devices found'); },
//                beforeSend: setHeader
            });

            preloader_off();

            return;

            // Simulated breastesses

            // $.ajax('/store-device/test/' + user_id, {
            //     type: 'post',
            //     data: {
            //         'json': '["10888628003507","10888628003637"]',
            //     },
            //     success: function () {
            //         alert('Device Data Updated Successfully');
            //     },
            //     error: function () {
            //         alert('Error storing device');
            //     }
            // });
            //
            // rel='my-devices';

        }

        $.ajax('/api/' + rel, {

            data: {
                'test': 'test',
            },
            dataType: 'text',
            type: 'post',
            context: this,
            success: function(result,status,xhr) {

                var rel=jQuery(this).attr('rel');

                console.log('Success - ' + rel);

                if (rel=='my-devices') {

                    $('.close-my-devices-button').show();
                    $('.search-show').hide();
                    $('.homepage-buttons').hide();

                }
                if (rel=='alerts') {

                    $('.close-my-alerts-button').show();
                    $('.search-show').hide();
                    $('.homepage-buttons').hide();

                }
                $('#display-area').html(MEprocess(result));

                preloader_off();

            },
            error: function(xhr,status,error) {

                console.log('Error - ' + rel);

                console.log(status);
                console.log(error);

                $('#display-area').html("An error has occurred");

                preloader_off();

            }

        });
    });


    $('.masthead-brand').on('click', function() {

        window.location = '/';

    });
    $('.integrations').on('click', function() {

        console.log('show integrations');

        $('#integrations').show();

        $('.close-integrations').show();

    });
    $('.show-generic-before-ehrs').on('click', function() {

        console.log('show show-generic-before-ehrs');

        $('#generic-before-ehrs').show();

        $('.close-patients').show();

    });
    $('.add-provider-patients').on('click', function() {

        $.ajax('/patient/new', {
            data: {

            },
            dataType: 'text',
            context: this,
            success: function(o) {
                $('#add-patient-form').html(o);
                $('#add-provider-patients').show();
            },
            error: function(e) {
                console.log(e);
                alert('An error has occurred');
            }
        })

    });
    $('.show-provider-patients').on('click', function() {

        console.log('show show-provider-patients');

        $('#show-provider-patients').show();

        if (typeof DODEVICES != "undefined") {

            if (DODEVICES == 1) {

                DODEVICES = 0;

                $('.devices').each(function(i) {

                    var rel=jQuery(this).attr('rel');

                    $.ajax('/api/devices', {

                        data: {
                            'json': rel,
                        },
                        dataType: 'text',
                        type: 'post',
                        context: this,
                        success: function(result,status,xhr) {

                            $(this).html(result);

                        },
                        error: function(xhr,status,error) {

                            $(this).html('Error');

                        }

                    });
                });
            }
        }
    });
    $('.show-patient-providers').on('click', function() {

        console.log('show show-patient-providers');

        $('#show-patient-providers').show();

    });

    $('.upload-file,.settings-button').on('click', function() {

        var rel = $(this).attr('rel');

        console.log('upload ' + rel + ' photo');

        $('#modal-iframe').attr('src', '/upload/' + rel);

        $('#modal-box').show();

        $('.close-modal-box-button').show();

    });

    $('.show-info').on('click', function() {

        var rel = $(this).attr('rel');

        viewerbox (rel);

    });

    $('.close-modal-box, .x-close-modal-box').on('click', function() {

        $('#modal-iframe').attr('src', '');

        $('#modal-box').hide();

        $('#integrations').hide();

        $('#add-provider-patients').hide();
        $('#show-provider-patients').hide();
        $('#show-patient-providers').hide();

        $('#no-results').hide();

        $('.close-modal-box-button').hide();

        $('.close-search-box-button').hide();

        $('#search-form').hide();

        $('.search-real').hide();
        $('.search-show').show();

    });

    $('#close-my-devices-box').on('click', function() {

        if (ADVERSE_OPEN == true) {

            // close adverse events window
            $('#modal-box').hide();

            ADVERSE_OPEN = false;



        } else {

            $('#display-area').html('');
            $('.close-my-devices-button').hide();
            $('.search-show').show();
            $('.homepage-buttons').show();

        }

    });

    $('#close-my-alerts-box').on('click', function() {

        $('#display-area').html('');
        $('.close-my-alerts-button').hide();
        $('.search-show').show();
        $('.homepage-buttons').show();

    });


    $('.comment-post').on("keyup", function(event) {
        if(event.which === 13) {

            var rel = $(this).attr('rel');

            var body = $(this).val();

            $.ajax('/post/' + rel, {

                data: {
                    'body': body,
                },
                dataType: 'json',
                type: 'post',
                success: function(result,status,xhr) {

                    window.location = "/homepage";

                },
                error: function(xhr,status,error) {

                    alert('Error in Status Post');

                }

            });
        }
    });


    $('.status-post').on('click', function() {

        var body = $('#status-post').val();

        console.log(body);

        $.ajax('/post', {

            data: {
                'body': body,
            },
            dataType: 'json',
            type: 'post',
            success: function(result,status,xhr) {

                // Reload homepage

                window.location = "/homepage";

            },
            error: function(xhr,status,error) {

                alert('Error in Status Post');

            }

        });

    });

    $('#no-results').on('click', function() {

        $.jAlert({
            'type': 'confirm',
            'confirmQuestion': 'Do you want to store "'+q+'" as a Saved Device in your profile?',
            'onConfirm': function(e, btn)
            {
                e.preventDefault();
                btn.parents('.jAlert').closeAlert();
                $.ajax('/api/store', {
                    data: {
                        'q': q,
                    },
                    dataType: 'text',
                    type: 'post',
                    success: function(txt) {

                        successAlert(txt);

                        $('#no-results').hide();
                        //window.location = "/homepage";

                    },
                    error: function() { //xhr,status,error

                        errorAlert("An Error Occurred");

                    }
                });
                return false;

            },
            'onDeny': function(e, btn){
                e.preventDefault();
                btn.parents('.jAlert').closeAlert();
                return false;
            }
        });


    });


    $('.mobile-top-logo').on('click', function() {
        window.location = '/';
    })

    $('.pooo').on('click',function() {

        if (interositer) {clearInterval(interositer);interositer = 0;}

        if (authwindow) {

            setTimeout(function() {

                authwindow.close();

                authwindow = false

            },1000);
        }

        $('#authloader-allscripts').hide();
        $('#authloader-epic').hide();

    });

    $('.close-allscripts').on('click', function() {

        $('#allscripts').hide();
        $('#integrations').show();

    });
    $('.close-epic').on('click', function() {

        $('#epic').hide();
        $('#integrations').show();

    });
    $('.close-generic').on('click', function() {

        $('#integrations').hide();
        $('#generic-before-ehrs').hide();
        $('.close-integrations').hide();
    });
    $('.close-integrations').on('click', function() {

        $('#integrations').hide();

    });
    $('#authorized-allscripts').on('click', function() {

        $('#integrations').hide();
        $('#allscripts').show();

        getPatientAllscripts(19);

    });
    $('#authorize-allscripts').on('click', function() {

        $('#integrations').hide();

        $('#authloader-allscripts').show();
        setTimeout(function() {
            authwindow = window.open(
                "https://dev.trackmyapp.us/allscripts/patient.html",
                "allscripts",
                "toolbar=no,scrollbars=yes,resizable=yes,top=50,left=300,width=400,height=400"
            );
        }, 500);

        $.ajax('/store-token/allscripts/1', {

            'type': 'post',
            'dataType': 'json',
            'data': {
                'token': '(the website is waiting for a token)',
                'status': '0'
            },
            success: function(d, s, x) {

                // --- we have successfully cleared the existing (old) token (have we?)

                console.log('you should make sure that d=true');

                console.log(d);

                // ----------------- inside success return from zero out status

                counter = 0;

                if (interositer) {clearInterval(interositer);interositer = 0;}

                interositer = setInterval(function() {

                    counter = counter + 1;

                    $('#thinker-allscripts').text("Elapsed time: " + counter);

                    if (!checking) {

                        checking = true; // we're checking!

                        $.ajax('/get-token/allscripts/1', {
                            'type': 'get',
                            'dataType': 'json',
                            'success': function(d, s, x) {

                                checking = false;

                                console.log('d should be the oauth row for this user');

                                console.log(d);

                                if (d.status === 1) {

                                    ALLSCRIPTS = d.token;

                                    $('#authorize-allscripts').hide();
                                    $('#authorized-allscripts').show();

                                    if (interositer) {clearInterval(interositer);interositer = 0;}

                                    if (authwindow) {
                                        setTimeout(function () {
                                            authwindow.close();
                                            authwindow = false
                                        }, 1000);
                                    }
                                    $('#authloader-allscripts').hide();


                                    // At this point we can engage the borg

                                    setTimeout(function () {

                                        $('#integrations').hide();
                                        $('#allscripts').show();

                                        getPatientAllscripts(19);

                                    }, 1000);
                                } else {


                                    // we're still thinking.....


                                }
                            },
                            error: function(x, t, e) {

                                if (interositer) {clearInterval(interositer);interositer = 0;}

                                // this should never happen :(
                                if (authwindow) {
                                    setTimeout(function() {
                                        authwindow.close();
                                        authwindow = false
                                    },1000);
                                }
                                $('#authloader-allscripts').hide();
                                alert("This website encountered an error trying to wait for a token");
                            }
                        });
                    }
                },1000);
                //--------------------------------------------------------
            },
            error: function(x, t, e) {
                // this should never happen :(

                if (interositer) {clearInterval(interositer);interositer = 0;}

                if (authwindow) {
                    setTimeout(function() {
                        authwindow.close();
                        authwindow = false
                    },1000);
                }
                $('#authloader-allscripts').hide();
                alert("This website encountered an error trying to start a timer");

            }
        });

    });
    $('#authorized-epic').on('click', function() {
        $('#integrations').hide();
        $('#epic').show();
        getPatientEpic();
    });
    $('#authorize-epic').on('click', function() {

        $('#integrations').hide();

        $('#authloader-epic').show();

        setTimeout(function() {
            authwindow = window.open(
                "https://trackmyapp.us/epic/patient.php",
                "epic",
                "toolbar=no,scrollbars=yes,resizable=yes,top=50,left=300,width=400,height=400"
            );
        }, 500);

        $.ajax('/store-token/epic/1', {

            'type': 'post',
            'dataType': 'json',
            'data': {
                'token': '(the website is waiting for a token)',
                'status': '0'
            },
            success: function(d, s, x) {

                // --- we have successfully cleared the existing (old) token (have we?)

                console.log('you should make sure that d=true');

                console.log(d);

                // ----------------- inside success return from zero out status

                counter = 0;

                if (interositer) {clearInterval(interositer);interositer = 0;}

                interositer = setInterval(function() {

                    counter = counter + 1;

                    $('#thinker-epic').text("Elapsed time: " + counter);

                    if (!checking) {

                        checking = true; // we're checking!

                        $.ajax('/get-token/epic/1', {
                            'type': 'get',
                            'dataType': 'json',
                            'success': function(d, s, x) {

                                checking = false;

                                console.log('d should be the oauth row for this user');

                                console.log(d);

                                if (d.status === 1) {

                                    EPIC = d.token;

                                    $('#authorize-epic').hide();
                                    $('#authorized-epic').show();

                                    if (interositer) {clearInterval(interositer);interositer = 0;}

                                    if (authwindow) {
                                        setTimeout(function () {
                                            authwindow.close();
                                            authwindow = false
                                        }, 1000);
                                    }
                                    $('#authloader-epic').hide();


                                    // At this point we can engage the borg

                                    setTimeout(function () {

                                        $('#integrations').hide();
                                        $('#epic').show();

                                        getPatientEpic();

                                    }, 1000);
                                } else {


                                    // we're still thinking.....


                                }
                            },
                            error: function(x, t, e) {

                                if (interositer) {clearInterval(interositer);interositer = 0;}

                                // this should never happen :(
                                if (authwindow) {
                                    setTimeout(function() {
                                        authwindow.close();
                                        authwindow = false
                                    },1000);
                                }
                                $('#authloader-epic').hide();
                                alert("This website encountered an error trying to wait for a token");
                            }
                        });
                    }
                },1000);
                //--------------------------------------------------------
            },
            error: function(x, t, e) {
                // this should never happen :(

                if (interositer) {clearInterval(interositer);interositer = 0;}

                if (authwindow) {
                    setTimeout(function() {
                        authwindow.close();
                        authwindow = false
                    },1000);
                }
                $('#authloader-epic').hide();
                alert("This website encountered an error trying to start a timer");

            }
        });

    });

    // If we have already valid tokens

    // if (ALLSCRIPTS !== "") {
    //
    //     $('#authorize-allscripts').hide();
    //     $('#authorized-allscripts').show();
    // }


    // if (EPIC !== "") {
    //
    //     $('#authorize-epic').hide();
    //     $('#authorized-epic').show();
    // }

    preloader_off();

    /////////////////////////// END OF JQUERY LOADED

    /* ActiveateListeners */
}

function preloader_on() {

    $('#preloader').show();

}
function preloader_off() {

    $('#preloader').hide();

}
function isOkiDoki() {

    var p = $('#fos_user_registration_form_plainPassword_first').val();

    var p2 = $('#fos_user_registration_form_plainPassword_second').val();

    if (p === '') {
        $('.nokidoki').hide();
        $("#_submit").prop("disabled", true);
        return;
    }

    if (p != p2) {

        if (p2.length > 7) {

            $('.nokidoki').show().html('passwords do not match');

        }
        $("#_submit").prop("disabled", true);
        return;
    }

    if (p.length < 8) {
        console.log('p is small');
        $('.nokidoki').show().html('password must be at least 8 characters');
        $("#_submit").prop("disabled", true);
        return(false);
    }

    if (p.replace(/\D/g,'') === '') {
        $('.nokidoki').show().html('password must include a number');
        $("#_submit").prop("disabled", true);
        return(false);
    }
    var strength = 0;
    var arr = [/.{8,}/, /[a-z]+/, /[0-9]+/, /[A-Z]+/];
    jQuery.map(arr, function(regexp) {
        if(p.match(regexp)) {
            strength++;
        } else { console.log('no'); }
    });

    //console.log(strength);

    if (strength < 4) {

        $('.nokidoki').show().html('password must include upper and lower case letters');
        $("#_submit").prop("disabled", true);
        return(false);
    }

    $('.nokidoki').show().html('Good Password!');

    $('.nokidoki').hide();
    $("#_submit").prop("disabled", false)
    return true;

}
function MEprocess(html) {

    // Todo: parse this like in times of yore

    // but for now...

    if ( html.indexOf('^searchform') > 0 ) {

        $('#no-results').hide();

        $('#search-form').show();

        $('.close-search-box-button').show();

    }

    return html;

}

function xl() {
    // fix for chrome ?? only on dev, doesn't re-collapse menu
    // console.log('click');
    // setTimeout(function() {
    //     console.log('now');
    //     $('.navbar-toggler').click();
    // },1000);
}

function getDevicesAllscripts(id) {

    var url ="https://tw171.open.allscripts.com/FHIR/Patient/" + id + "/Device";

    $.ajax(url, {
        type: 'GET',
        // Fetch the stored token from localStorage and set in the header
        headers: {
            "Authorization": 'Bearer ' + ALLSCRIPTS
        },
        success: function (d, s, x) {

            console.log("Success");
            console.log(d);
            console.log(s);

            DEVICE = d.entry;
            DIV = '#var_dump';
            var_dump(d);

            $('#patient-allscripts').html(decodeEntities(DEVICE[0].resource.text.div));

            $.ajax('/store-device/allscripts/' + user_id, {
                type: 'post',
                data: {
                    'json': JSON.stringify(DEVICE),
                },
                success: function () {
                    alert('Device Data Updated Successfully');
                },
                error: function () {
                    alert('Error storing device');
                }
            });

        },
        error: function(x, t, e) {

            console.log("Error");
            console.log(t);
            console.log(e);

        }


    });


}

function getPatientAllscripts(id) {

    $.ajax('https://tw171.open.allscripts.com/FHIR/Patient/' + id, {
        type: 'GET',
        // Fetch the stored token from localStorage and set in the header
        headers: {
            "Authorization": 'Bearer ' + ALLSCRIPTS
        },
        success: function (d, s, x) {

            console.log("Success");
            console.log(d);
            console.log(s);

            PATIENT = d;
            DIV = '#var_dump';
            var_dump(d);

            $('#patient-allscripts').html(decodeEntities(PATIENT.text.div));


            $.ajax('/store-patient/allscripts/' + user_id, {
                type: 'post',
                data: {
                    'json': JSON.stringify(PATIENT),
                },
                success: function () {
                    alert('Patient Data Updated Successfully');
                },
                error: function () {
                    alert('Error storing patient');
                }
            });

        },
        error: function(x, t, e) {

            console.log("Error");
            console.log(t);
            console.log(e);

        }


    });


}
function getPatientEpic() {

    var baseUrl = "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/";

    var patientSearchString = "/Patient?given=Jason&family=Argonaut";

    $.getJSON(baseUrl + patientSearchString, function(data,error) {

        PATIENT = data;

        /* IMPORTANT! */
        patientId = data.entry[0].link[0].url.split("/").pop();

        $('#patient-epic').html("<h1>" + data.entry[0].resource.name[0].text + "</h1>");

        DIV = '#var_dump2';

        var_dump(data);

        $.ajax('/store-patient/epic/' + user_id, {
            type: 'post',
            data: {
                'json': JSON.stringify(PATIENT),
            },
            success: function () {
                alert('Patient Data Updated Successfully');
            },
            error: function () {
                alert('Error storing patient');
            }
        });


    });




}
function getDevicesEpic() {

    var baseUrl = "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/";

    var deviceSearchString = "Device?patient=" + patientId;

    $.getJSON(baseUrl + deviceSearchString, function(data,error) {

        console.log(data);

        DEVICE = data;

        DIV = '#var_dump2'

        var_dump(data);

        $.ajax('/store-device/epic/' + user_id, {
            type: 'post',
            data: {
                'json': JSON.stringify(DEVICE),
            },
            success: function () {
                alert('Device Data Updated Successfully');
                getMedicationsEpic();
            },
            error: function () {
                alert('Error storing device');
            }
        });
    });

}
function getMedicationsEpic() {

    var baseUrl = "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/";

    var deviceSearchString = "MedicationOrder?patient=" + patientId;

    $.getJSON(baseUrl + deviceSearchString, function(data,error) {

        console.log(data);

        MEDICATION = data;

        $.ajax('/store-medication/epic/' + user_id, {
            type: 'post',
            data: {
                'json': JSON.stringify(MEDICATION),
            },
            success: function () {
                alert('Medication Updated Successfully');
            },
            error: function () {
                alert('Error storing device');
            }
        });
    });

}

function var_dump() {
    //  discuss at: http://phpjs.org/functions/var_dump/
    // original by: Brett Zamir (http://brett-zamir.me)
    // improved by: Zahlii
    // improved by: Brett Zamir (http://brett-zamir.me)
    //  depends on: echo
    //        note: For returning a string, use var_export() with the second argument set to true
    //        test: skip
    //   example 1: var_dump(1);
    //   returns 1: 'int(1)'

    var output = '',
        pad_char = ' ',
        pad_val = 4,
        lgth = 0,
        i = 0;

    var _getFuncName = function(fn) {
        var name = (/\W*function\s+([\w\$]+)\s*\(/)
            .exec(fn);
        if (!name) {
            return '(Anonymous)';
        }
        return name[1];
    };

    var _repeat_char = function(len, pad_char) {
        var str = '';
        for (var i = 0; i < len; i++) {
            str += pad_char;
        }
        return str;
    };
    var _getInnerVal = function(val, thick_pad) {
        var ret = '';
        if (val === null) {
            ret = 'NULL';
        } else if (typeof val === 'boolean') {
            ret = 'bool(' + val + ')';
        } else if (typeof val === 'string') {
            ret = 'string(' + val.length + ') "' + val + '"';
        } else if (typeof val === 'number') {
            if (parseFloat(val) == parseInt(val, 10)) {
                ret = 'int(' + val + ')';
            } else {
                ret = 'float(' + val + ')';
            }
        }
        // The remaining are not PHP behavior because these values only exist in this exact form in JavaScript
        else if (typeof val === 'undefined') {
            ret = 'undefined';
        } else if (typeof val === 'function') {
            var funcLines = val.toString()
                .split('\n');
            ret = '';
            for (var i = 0, fll = funcLines.length; i < fll; i++) {
                ret += (i !== 0 ? '\n' + thick_pad : '') + funcLines[i];
            }
        } else if (val instanceof Date) {
            ret = 'Date(' + val + ')';
        } else if (val instanceof RegExp) {
            ret = 'RegExp(' + val + ')';
        } else if (val.nodeName) {
            // Different than PHP's DOMElement
            switch (val.nodeType) {
                case 1:
                    if (typeof val.namespaceURI === 'undefined' || val.namespaceURI === 'http://www.w3.org/1999/xhtml') {
                        // Undefined namespace could be plain XML, but namespaceURI not widely supported
                        ret = 'HTMLElement("' + val.nodeName + '")';
                    } else {
                        ret = 'XML Element("' + val.nodeName + '")';
                    }
                    break;
                case 2:
                    ret = 'ATTRIBUTE_NODE(' + val.nodeName + ')';
                    break;
                case 3:
                    ret = 'TEXT_NODE(' + val.nodeValue + ')';
                    break;
                case 4:
                    ret = 'CDATA_SECTION_NODE(' + val.nodeValue + ')';
                    break;
                case 5:
                    ret = 'ENTITY_REFERENCE_NODE';
                    break;
                case 6:
                    ret = 'ENTITY_NODE';
                    break;
                case 7:
                    ret = 'PROCESSING_INSTRUCTION_NODE(' + val.nodeName + ':' + val.nodeValue + ')';
                    break;
                case 8:
                    ret = 'COMMENT_NODE(' + val.nodeValue + ')';
                    break;
                case 9:
                    ret = 'DOCUMENT_NODE';
                    break;
                case 10:
                    ret = 'DOCUMENT_TYPE_NODE';
                    break;
                case 11:
                    ret = 'DOCUMENT_FRAGMENT_NODE';
                    break;
                case 12:
                    ret = 'NOTATION_NODE';
                    break;
            }
        }
        return ret;
    };

    var _formatArray = function(obj, cur_depth, pad_val, pad_char) {
        var someProp = '';
        if (cur_depth > 0) {
            cur_depth++;
        }

        var base_pad = _repeat_char(pad_val * (cur_depth - 1), pad_char);
        var thick_pad = _repeat_char(pad_val * (cur_depth + 1), pad_char);
        var str = '';
        var val = '';

        if (typeof obj === 'object' && obj !== null) {
            if (obj.constructor && _getFuncName(obj.constructor) === 'PHPJS_Resource') {
                return obj.var_dump();
            }
            lgth = 0;
            for (someProp in obj) {
                lgth++;
            }
            str += 'array(' + lgth + ') {\n';
            for (var key in obj) {
                var objVal = obj[key];
                if (typeof objVal === 'object' && objVal !== null && !(objVal instanceof Date) && !(objVal instanceof RegExp) &&
                    !
                        objVal.nodeName) {
                    str += thick_pad + '[' + key + '] =>\n' + thick_pad + _formatArray(objVal, cur_depth + 1, pad_val,
                        pad_char);
                } else {
                    val = _getInnerVal(objVal, thick_pad);
                    str += thick_pad + '[' + key + '] =>\n' + thick_pad + val + '\n';
                }
            }
            str += base_pad + '}\n';
        } else {
            str = _getInnerVal(obj, thick_pad);
        }
        return str;
    };

    output = _formatArray(arguments[0], 0, pad_val, pad_char);
    for (i = 1; i < arguments.length; i++) {
        output += '\n' + _formatArray(arguments[i], 0, pad_val, pad_char);
    }

    $(DIV).html(output);
}
var decodeEntities = (function() {
    // this prevents any overhead from creating the object each time
    var element = document.createElement('div');

    function decodeHTMLEntities (str) {
        if(str && typeof str === 'string') {
            // strip script/html tags
            str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
            str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
            element.innerHTML = str;
            str = element.textContent;
            element.textContent = '';
        }

        return str;
    }

    return decodeHTMLEntities;
})();

function searchHere() {
    setTimeout( function() {
        $('.search-here').show('slow');
    }, 1000);

    setTimeout( function() {
        $('.search-here').hide('slow');
    }, 5000);
}
function savePatient() {

    $.ajax({
        url: '/patient/save',
        type: 'post',
        dataType: 'text',
        data: $('form#patient-form').serialize(),
        success: function(data) {

            if (data.length > 100) {

                $('#add-patient-form').html(data);

            }

            else
            {
                alert(data);
            }

        },
        error: function(data) {
            console.log(data);
            alert("Error! - see console");
        }
    });

}
function rowShow(n) {
    $('#row' + n).show();
}
function savePatientDevices() {

    $.ajax({
        url: '/devices/save',
        type: 'post',
        dataType: 'text',
        data: $('form#device-form').serialize(),
        success: function(data) {

            if (data.indexOf('success') > 0) {

                $('#add-patient-form').html(data);

            } else {

                alert(data);
            }


        },
        error: function(data) {
            console.log(data);
            alert("Error! - see console");
        }
    });

}


jQuery(document).ready(function() {
    // date pickers
    jQuery('.past-date-picker').datepicker({
        maxDate: "now",
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
    }).mask('00/00/0000');
    jQuery('.date-picker').datepicker().mask('00/00/0000');
    jQuery('.future-date-picker').datepicker({
        minDate: "now",
        changeMonth: true,
        changeYear: true,
        yearRange: "0:+50",
    }).mask('00/00/0000');

    // phone number masks
    jQuery('.phone').mask('(000) 000-0000')

});
