<?php

class Feedback
{
    public ?int $id;
    public string $name;
    public string $email;

    public string $content;
    public ?DateTime $timestamp;

    public function __construct(?int $id, string $name, string $email, string $content, ?Datetime $timestamp)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }

    public function validate()
    {
        if (!isset($this->name) || $this->name == "") {
            // $_SESSION['message'] = 'Name is missing';
            throw new Exception("Name must not be empty");
        }

        if (!isset($this->email) || $this->email == "") {
            throw new Exception("Email must not be empty");
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid format");
        }

        if (!isset($this->content) || $this->content == "") {
            throw new Exception("Feedback message must not be empty");
        }
    }

    public function render()
    {
        $this->timestamp->setTimezone(new DateTimeZone("Asia/Ho_Chi_Minh"));
        $format_content = substr($this->content, 0, 50);

        echo "<li class='feedback_item' style=\"margin-top: 1rem\">
                    <div>
                        <span class=\"txt_name\" >$this->name</span> - <span class=\"txt_date\">" . $this->timestamp->format('M j, Y - H:i') . "</span>
                    </div>

                    <div class=\"txt_content\">
                        $format_content
                    </div>
                </li>";

    }
}


