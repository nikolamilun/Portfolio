<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Site icon -->
        <link rel="icon" href="images/SmallLogo.jpg">
         <!-- Meta tags -->
        <meta name="description" content="I'm Nikola Milun, a junior full-stack dev and here's my portfolio!">
        <meta name="keywords" content="programming, web developer, database design, desktop apps, developer, full-stack">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Source+Code+Pro&display=swap" rel="stylesheet">
        <!-- CSS -->
        <link rel="stylesheet" href="style.css">
        <title>Nikola Milun - admin</title>
        <!-- Script -->
        <script src="admin.js" defer></script>
    </head>
    
        <?php 
            // Errors list and error types with descriptions
            $errors = [];
            const NAME_ERROR = 'Please, type your name in correctly';
            const PASSWORD_ERROR = 'Please, type your password in correctly';
            const NON_EXISTING_USERNAME = 'The username you entered doesn\'t exist';
            const INCORRECT_PASSWORD = 'The password you typed in is incorrect';
            const OTHER_ERROR = 'There has been an error processing your request. Please contact the site admin.';
            // This is a self-processing form, so if the method is GET, show the form: 
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
        ?>
            <body class="adminBody" onLoad="pageLoad();">
                <h1 class="adminTitle">Please log in as an administrator!</h1>
                <section id="logIn">
                    <!-- Log in as an admin form -->
                    <div class="container logInForm">
                        <!-- The form submits itself -->
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" id="loginForm" method = "POST">
                                <p>*Every field is required</p>
                                <div>
                                    <label for="adminName">Your username: </label>
                                    <input type="text" name="adminName" maxlength = "20" id="adminNameInput" required>
                                </div>
                                <div>
                                    <label for="password">Your password:</label>
                                    <input type="password" name="password" maxlength = "20" required>
                                </div>
                                <!-- When the input is clicked, a cookie is created (see admin.js) -->
                                <input type="submit" class="submit" onClick="getUsernameCookie();">
                        </form>
                    </div>
                </section>
            </body>
        <?php }
            else{
                // Incicate whether has the login been successful
                $loggedIn = false;

                // Connection properties
                $servername = 'localhost';
                $username = 'root';
                $sqlPassword = '';
                $database = "portfoliocontact";

                // Validate all of the fields
                $name = filter_input(INPUT_POST, 'adminName', FILTER_SANITIZE_STRING);
                if($name)
                {
                    $name = trim($name);
                    if ($name === '') {
                        $errors['name'] = NAME_ERROR;
                    }
                } else{
                    $errors['name'] = NAME_ERROR;
                }
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                if($password)
                {
                    $password = trim($password);
                    if ($password === '') {
                        $errors['password'] = PASSWORD_ERROR;
                    }
                }

                // If no errors were found, proceed
                if(!count($errors))
                {
                    // Establish MySQL connection
                    $conn = new mysqli($servername, $username, $sqlPassword, $database);
                    // See if there are any errors
                    if($conn->connect_error)
                        $errors['other'] = OTHER_ERROR;
                    else
                    {
                        $queryText = 'SELECT adminUsername, adminPassword FROM admin';

                        // SQL query for the login data
                        $result = mysqli_query($conn, $queryText);

                        // See if the data entered is correct
                        while($row = mysqli_fetch_row($result))
                        {
                            if($row[0] == $name)
                            {
                                if($row[1] == $password)
                                    $loggedIn = true;
                                else
                                    $errors['password'] = INCORRECT_PASSWORD;
                                break;
                            }
                        }
                        // In case the username entered doesn't exist
                        if(array_key_exists('password', $errors) == null && $loggedIn == false)
                            $errors['username'] = NON_EXISTING_USERNAME;
                        // If no errors were found, proceed
                        if(!count($errors))
                        {
                            // If login is successful, retrieve data
                            $queryText = 'SELECT name, email, message FROM message WHERE date > DATE_ADD(CURDATE(), INTERVAL "-3" DAY) ORDER BY date DESC';

                            $result = mysqli_query($conn, $queryText);

                            $data = array();

                            // Fetch the data into an array
                            while($row = mysqli_fetch_array($result, MYSQLI_NUM))
                            {
                                array_push($data, array($row[0], $row[1], $row[2]));
                            }

                            mysqli_close($conn);

                            ?>
                            <body class="adminBody">
                                <h1 class="adminTitle">Hey, <?php echo($name)?>, you're in charge now!</h1>
                                <section id="requests">
                                    <div class="container">
                                        <h2 class="requestsHeader">These requests were made in the last three days: </h2>
                                        <table>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                            </tr>
                                            <?php
                                                /* show query results in a table */
                                                foreach($data as $row){
                                                echo("<tr>");
                                                foreach($row as $value)
                                                    echo("<td>{$value}</td>");
                                                echo("</tr>");
                                                }
                                            ?>
                                        </table>
                                    </div>
                                    <form method="POST" action="download.php" class="download">
                                        <!-- A form to download all the messages sent -->
                                        <input type="submit" value="Download all">
                                    </form>
                                </section>
                            </body>
                        <?php }
                    }
                }
                // Error messages
                if(count($errors)){
        ?>
            <section id="formSubmitted">
                <h1>There has been an error processing your request.</h1>
                <p>Check if you had written everything down correctly! The errors: </p>
                <?php foreach($errors as $error){
                    // Write all the messages in the errors array
                    echo("<p>$error</p>");
                }?>
            </section>
        <?php }} ?>
    </body>
</html>