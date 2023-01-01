<style>
    <?php include public_path('css/StyleQuickConsultation.css'); ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Consultation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&family=Permanent+Marker&display=swap"
        rel="stylesheet">
</head>

<body>
    <main>


        <!-- <div id="users-list"></div> -->

        <h1 id="site-title">Live Streams</h1>
        <div id="join-wrapper">
            <button
                onclick="window.location.href='https://childish-truthful-chimpanzee.glitch.me/www.google.com'"
                id="join-btn">Join Stream</button>
        </div>
        <div id="user-streams"></div>



    </main>




</body>

</html>


<!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.10.1/firebase-database.js"></script>
<script>
    function goToIndex() {
        window.history.back();
    }
    //Getting User id
    var uid;

    if (window.location.search.split('?').length > 0) {
        var params = window.location.search.split('?')[1];
        uid = params.split('=')[1];
    }

    // var config = {
    //     apiKey: "{{ config('services.firebase.api_key') }}",
    //     authDomain: "{{ config('services.firebase.auth_domain') }}",
    //     databaseURL: "{{ config('services.firebase.database_url') }}",
    //     storageBucket: "{{ config('services.firebase.storage_bucket') }}",
    // };

    const config = {
        apiKey: "AIzaSyCwL-AtDqq-jdMBYNi1nTo5NNAtHwMhhHc",
        authDomain: "appointment-sys-3fb2e.firebaseapp.com",
        databaseURL: "https://appointment-sys-3fb2e-default-rtdb.firebaseio.com",
        projectId: "appointment-sys-3fb2e",
        storageBucket: "appointment-sys-3fb2e.appspot.com",
        messagingSenderId: "167244005815",
        appId: "1:167244005815:web:ea60f2c06b25a4660ce832"
    };



    firebase.initializeApp(config);
    var database = firebase.database();
    var senderName;
    var adminId = "oDuFXD8ZWdhUavo1OBl8rH6e4WY2";
    var adminName = "Admin";

    firebase.database().ref('users/').on('value', function(snapshot) {
        var value = snapshot.val();
        $.each(value, function(index, value) {
            if (value && index == uid) {
                senderName = value.fname + " " + value.lname;
            }
        });
    });
    var receiverName = adminName;
    var receiverId = adminId;
    // receiverName = document.getElementById("senders").text;
    // receiverId = document.getElementById("senders").value;
    $("#senders").change(function() {
        // alert("change called");
        receiverName = $("#senders option:selected").text();
        receiverId = document.getElementById("senders").value;
        console.log('receiver', receiverName);
        console.log('receiver id', receiverId);
    });
    const messageForm = document.querySelector("#SendMessage");
    messageForm.addEventListener("submit", (e) => {
        e.preventDefault();
        //get message
        var message = document.getElementById('message').value;
        document.getElementById('message').value = "";
        //save in database
        database.ref('messages').push().set({
            "senderId": uid,
            "senderName": senderName,
            "receiverId": receiverId,
            "receiverName": receiverName,
            "message": message,
        });
    });

    if (uid == adminId) {
        $("#senders").change(function() {
            document.getElementById("messages").innerHTML = " ";

            database.ref("messages").on("child_added", function(snapshot) {
                // alert("message recalled");
                var html = "";

                // document.getElementById("messages").innerHTML = " ";
                if (snapshot.val().senderId == uid && snapshot.val().receiverId == receiverId ||
                    snapshot.val().senderId == receiverId && snapshot.val().receiverId == uid) {
                    if (snapshot.val().senderId == uid) {
                        //html += "<li id='message-" + snapshot.key + "'>" + snapshot.val().message + "</li>";
                        html +=
                            "<div class='chate-body'><div class='M-s'><div class='message-sender-message'><p>" +
                            snapshot.val().message + "</p></div></div></div>";
                    } else {
                        // html += "<li id='message-" + snapshot.key + "'>" + snapshot.val().senderName + ": " + snapshot.val().message + "</li>";
                        html +=
                            "<div class='chate-body'><div class='M-r'><div class='message-sender-message rece'><p>" +
                            snapshot.val().senderName + ": " + snapshot.val().message +
                            "</p></div></div></div>";
                    }
                }
                // html += "</li>";
                document.getElementById("messages").innerHTML += html;
            });
        });
    } else {
        database.ref("messages").on("child_added", function(snapshot) {
            var html = "";

            // document.getElementById("messages").innerHTML = " ";
            if (snapshot.val().senderId == uid && snapshot.val().receiverId == receiverId || snapshot.val()
                .senderId == receiverId && snapshot.val().receiverId == uid) {
                if (snapshot.val().senderId == uid) {
                    // html += "<li id='message-" + snapshot.key + "'>" + snapshot.val().message + "</li>";
                    html += "<div class='M-s'><div class='message-sender-message'><p>" + snapshot.val()
                        .message + "</p></div></div>";
                } else {
                    //html += "<li id='message-" + snapshot.key + "'>" + snapshot.val().senderName + ": " + snapshot.val().message + "</li>";
                    html += "<div class='M-r'><div class='message-sender-message'><p>" + snapshot.val()
                        .senderName + ": " + snapshot.val().message + "</p></div></div>";
                }
            }
            // html += "</li>";
            document.getElementById("messages").innerHTML += html;
        });
    }

    //Giving different view for admin

    if (uid == adminId) {
        database.ref("messages").on("value", function(snapshot) {
            var value = snapshot.val();
            var senders = [];
            var sendersId = [];
            $.each(value, function(index, value) {
                if (value) {
                    //             firebase.database().ref('users/').on('value', function (snapshot) {
                    // var value = snapshot.val();
                    // database.ref("users/" + value.senderId).on("value", function(snapshot){
                    //     senders.push(snapshot.val().fname + " " + snapshot.val().lname);
                    //     sendersId.push(snapshot.val().id);
                    // });
                    senders.push(value.senderName);
                    sendersId.push(value.senderId);
                }
            });
            console.log(senders);
            var unique = [...new Set(senders)];
            var uniqueId = [...new Set(sendersId)];
            console.log(unique);
            console.log(uniqueId);

            var i;
            var htmls = "";

            //<div class="chate">
            //html+="<div class='M-s'><div class='message-sender-message'><p>"+ snapshot.val().message + "</p></div></div>";
            for (i = 0; i < unique.length; i++) {

                htmls += "<option value='" + uniqueId[i] + "'>" + unique[i] + "</option></div></div>";

            }
            document.getElementById('senders').innerHTML = htmls;
        });
    }
</script> -->
