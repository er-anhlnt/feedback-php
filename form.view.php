<?php session_start() ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <header>FEEDBACK FORM</header>

    <form action="form.php" method="POST" id="form" class="topBefore">

        <input name="name" id="name" type="text" placeholder="NAME" value="<?= $name ?>">
        <input name="email" id="email" type="text" placeholder="E-MAIL" value="<?= $email ?>">
        <textarea name="feedback" id="feedback" type="text" placeholder="FEEDBACK"><?= $feedback_content ?></textarea>
        <input id="submit" type="submit" value="Send">


        <div style="margin-top:10px; color:red; text-align: center">
            <?php if (isset($message))
                echo $message ?>
            </div>
        </form>

    </body>

    </html>