<style>
    <?php include public_path('css/StyleViewAppointment.css'); ?>
</style>
<style>
    <?php include public_path('css/StyleHome.css'); ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Appointments | Doctor</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">

        <a class="navbar-brand" href="#">OMT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#" onClick="goToIndex()">Home <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onClick="quickConsultation()">Quick Consultation</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-log-in" onClick="logout()"></span> logout</a>
                </li>
            </ul>
        </div>

    </nav>

    <h3>Appointments</h3>
    <table class="table table-bordered">
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Patient name</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</body>

</html>
{{-- Firebase Tasks --}}
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script>
    var drid;
    // Get Doctors
    if (window.location.search.split('?').length > 0) {
        var params = window.location.search.split('?')[1];
        drid = params.split('=')[1];
    }
    // Initialize Firebase
    var config = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        databaseURL: "{{ config('services.firebase.database_url') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    };
    firebase.initializeApp(config);
    var database = firebase.database();
    var lastIndex = 0;

    // Getting Patient Name
    var patients = {};
    firebase.database().ref('users/').on('value', function(snapshot) {
        var value = snapshot.val();
        $.each(value, function(index, value) {
            patients[index] = value.fname + " " + value.lname;
        });
    });

    console.log("running..");
    // Get Data
    firebase.database().ref('appointments/').on('value', function(snapshot) {
        var value = snapshot.val();
        var htmls = [];
        console.log("running ", drid);
        $.each(value, function(index, value) {
            if (value && value.doc_id == drid) {
                console.log(value.pat_id);
                htmls.push('<tr>\
                    <td>' + value.date + '</td>\
                    <td>' + value.time + '</td>\
                    <td>' + patients[value.pat_id] +
                    '</td>\
                    <td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="' + index + '">Generate Prescription</button>\
                    </td>\
                </tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitPatient").removeClass('desabled');
    });
    $('body').on('click', '.updateData', function() {
        var app_id = $(this).attr('data-id');
        window.location = '/prescription?appointmentid=' + app_id;
    });

    function logout() {
        firebase.auth().signOut().then(() => {
            // Sign-out successful.
            window.location = '/';
        }).catch((error) => {
            // An error happened.
        });
    }


    function quickConsultation() {
        window.location = 'quickconsultation';
    }

    function goToIndex() {
        window.location = 'doctorsview';
    }
</script>
