<?php
require "feedback.php";

session_start();
unset($_SESSION["message"]);
const FEEDBACK_FILE = 'feedback.csv';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback_content = $_POST['feedback'];

    try {
        $feedback = new Feedback(null, $name, $email, $feedback_content, (new DateTime()));

        $feedback->validate();

        createFeedback($feedback);
        clear_feedbacks_session();

        header('Location: feedbacks.php');
    } catch (\Throwable $e) {
        $message = $e->getMessage();

        require "form.view.php";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    require ("form.view.php");
}

function createFeedback(Feedback $feedback)
{
    if (!file_exists(FEEDBACK_FILE) || !is_writeable(FEEDBACK_FILE)) {
        throw new Exception('Cannot open file');
    }

    $f = fopen(FEEDBACK_FILE, 'a');

    $feedback->id = random_int(1000000, 9999999);
    $feedbackObject = get_object_vars($feedback);
    $feedbackObject['timestamp'] = $feedbackObject['timestamp']->format('c');

    fputcsv($f, $feedbackObject);

    fclose($f);
}

function clear_feedbacks_session()
{
    $pattern = '/\/feedbacks\?.*/';
    foreach ($_SESSION as $key => $value)
        if (str_contains($key, "feedbacks.php")) {
            unset($_SESSION[$key]);
        }

}