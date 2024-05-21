<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <header>Thank You!</header>
    <div class="container" style="text-align: center;">
        <p style="font-size: 1.5rem;">Thank you for your feedback. We appreciate your input.</p>
    </div>


    <div style="max-width: 700px;margin: auto;">
        <div style="display: flex; justify-content: space-between; ;align-items: center">
            <h2>Recent feedback</h2>

            <div>
                <form action="feedbacks.php" method="get">
                    <select onchange="submit()" name="sort">
                        <?php foreach ($sort_terms as $sort_item) { ?>
                            <option <?php if ($sort_item['value'] == $sort) {
                                echo "selected";
                            } ?>
                                value="<?= $sort_item["value"] ?>">
                                <?= $sort_item["name"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div>

        <div>
            <ul>
                <?php
                foreach ($feedbacks as $feedback) {
                    $feedback->render();
                }
                ?>
            </ul>
        </div>

    </div>

    <script>
    </script>
</body>

</html>