<?php

/** @var yii\web\View $this */
/** @var $messagesOfChat */
/** @var $currentChats */
/** @var $chat */
/** @var $group */
/** @var \frontend\models\MessageForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Firebase';
$this->params['breadcrumbs'][] = $this->title;
?>
!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-app.js"></script>

<!-- include firebase database -->
<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-database.js"></script>
<script>
    // Your web app's Firebase configuration

    var firebaseConfig = {
        apiKey: "AIzaSyAwO96S0a2zhzFlQQuwz_y086bJrVTV8HY",
        authDomain: "chat-cbaef.firebaseapp.com",
        databaseURL: "https://chat-cbaef-default-rtdb.europe-west1.firebasedatabase.app/",
        projectId: "chat-cbaef",
        storageBucket: "chat-cbaef.appspot.com",
        messagingSenderId: "786319160122",
        appId: "1:786319160122:web:adc5dd2cb44c6d0e4d9603"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    var myName = prompt("Enter your name");
</script>
<style>
    /* Chat containers */
    .container_message {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
    }

    .container_message::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Style time text */
    .time-right {
        float: right;
        color: #aaa;
    }
</style>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        if($currentChats > 0 ){
            foreach ($currentChats as $chatNumber){
                $i = 0;
                foreach ($chatNumber as $group){
                    foreach ($group as $groupNumber){
                        $strUrl = "/site/firebase?chat=".$chat."&group=".$i;
    ?>
                        <a href=<?php echo $strUrl?>>
                            <div class="container_chats">
                                <p>Chat: <?php echo $groupNumber[0]['Username'];?></p>
                                <p><?php echo $groupNumber[0]['Text'];?></p>
                            </div>
                        </a>
                        <br>
                        <br>
    <?php

                        $i++;
                    }
                }
            }
        }
    ?>
    <div id="messages">
        <?php
        if($messagesOfChat > 0 ){
            foreach ($messagesOfChat as $key => $row){
    ?>
            <div class="container_message">
                <p>Username: <?php echo $row['Username'];?></p>
                <br>
                <p><?php echo $row['Text'];?></p>
                <br>
                <span class="time-right"><?php echo $row['Time'];?></span>
            </div>
    <?php
            }
        }
    ?>
    </div>
    <p>New message:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'message-form']); ?>

            <?= $form->field($model, 'text')->textInput(['autofocus' => true]) ?>


            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <form onsubmit="return sendMessage();">
        <input id="messageValue" placeholder="Enter message" autocomplete="off">

        <input type="submit">
    </form>

</div>
<script>
    // listen for incoming messages
    firebase.database().ref("Chat/",<?php echo json_encode($chat)?>,"/Group/",<?php echo json_encode($group)?>,"/Messages/").on("child_added", function (snapshot) {
        var html = "<div class="container_message">";
        // give each message a unique ID
        html += "<p>Username:" + snapshot.val().username + "</p><br><p>";
        html += snapshot.val().text + "</p><br><span class='time-right'>" + snapshot.val().time+"</span></div>";

        document.getElementById("messages").innerHTML += html;
    });
</script>