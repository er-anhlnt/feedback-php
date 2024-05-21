<?php
require "feedback.php";
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sort_terms = [["value" => "newest", "name" => "Newest"], ["value" => "oldest", "name" => "Oldest"], ["value" => "name", "name" => "Name"]];

    try {
        $sort = $_GET['sort'] ?? "";
        $feedbacks = get_feedbacks($sort);

        require "feedbacks.view.php";

    } catch (\Throwable $e) {
        echo $e->getMessage();
    }
}

function get_feedbacks(string $sort)
{
    if (!file_exists("feedback.csv") || !is_readable("feedback.csv")) {
        throw new Exception('Cannot open file');
    }

    if (isset($_SESSION[$_SERVER['REQUEST_URI']])) {
        return $_SESSION[$_SERVER['REQUEST_URI']];
    }

    $f = fopen("feedback.csv", 'r');
    $feedbacks = [];

    while (($line = fgetcsv($f)) != false) {
        $feedbacks[] = new Feedback($line[0], $line[1], $line[2], $line[3], new Datetime($line[4]));
    }

    fclose($f);

    $feedbacks = sort_feedbacks($feedbacks, $sort);
    $_SESSION[$_SERVER['REQUEST_URI']] = $feedbacks;

    return $feedbacks;
}

function sort_feedbacks(array $feedbacks, string $sort_term)
{
    $sort_func = null;
    switch ($sort_term) {
        case 'newest': {
            $sort_func = function ($a, $b) {
                return $b->timestamp->getTimeStamp() - $a->timestamp->getTimeStamp();
            };
            break;
        }
        case 'oldest': {
            $sort_func = function ($a, $b) {
                return $a->timestamp->getTimeStamp() - $b->timestamp->getTimeStamp();
            };
            break;
        }
        case 'name': {
            $sort_func = function ($a, $b) {
                return strcmp($a->name, $b->name);
            };
            break;
        }
        # default is sort by date desc
        default: {
            $sort_func = function ($a, $b) {
                return $b->timestamp->getTimeStamp() - $a->timestamp->getTimeStamp();
            };

            break;
        }
    }

    usort($feedbacks, $sort_func);

    return $feedbacks;
}
