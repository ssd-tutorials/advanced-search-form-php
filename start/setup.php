<?php

require "bootstrap/autoload.php";

if (\SSD\DotEnv\DotEnv::get('APP_ENV') === 'live') {
    return;
}

$action = isset($_GET['action']) ? $_GET['action'] : null;
$message = null;
$home = null;

switch($action) {

    case 'migrate':
        \App\Migration\MigrationManager::migrate();
        $message = '<p class="label">Database tables have been created.</p>';
        $home = '<a href="/" class="secondary button">GO TO HOME PAGE</a>';
        break;

    case 'reset':
        \App\Migration\MigrationManager::reset();
        $message = '<p class="alert label">All database tables have been removed.</p>';
        break;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Search Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="./assets/css/dist/app.css" rel="stylesheet">
</head>
<body>

    <div class="row center">

        <div class="medium-6 columns medium-offset-3">

            <h1>Project setup</h1>

            <p>
                Please select action:
            </p>

            <?php echo $message; ?>

            <p class="button-group expanded">
                <a href="?action=migrate" class="button">MIGRATE</a>
                <a href="?action=reset" class="alert button">RESET</a>
            </p>

            <?php echo $home; ?>

        </div>

    </div>

</body>
</html>