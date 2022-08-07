<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Meta tags -->
        <meta name="description" content="I'm Nikola Milun, a junior full-stack dev and here's my portfolio!">
        <meta name="keywords" content="programming, web developer, database design, desktop apps, developer, full-stack">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Source+Code+Pro&display=swap" rel="stylesheet">
        <!-- Local css -->
        <link rel="stylesheet" href="style.css">
        <title>Contact me - Nikola Milun</title>
    </head>
    <body class="contactBody">
        <header class="transparent pacificoFont">
            <div class="logoHolder">
                <!-- Logo image -->
                <img src="images/logo.jpg" alt="Site Logo" class="logo">
            </div>
            <div class="headerLinksHolder">
                <!-- Navbar links -->
                <a href="index.html" class="headerLink hlHome">Home</a>
                <a href="about.html" class="headerLink hlAbout">About</a>
                <a href="gallery.html" class="headerLink hlGallery">Gallery</a>
                <a href="#" class="headerLink hlContact">Contact</a>
            </div>
        </header>
        <?php
            $errors = [];
            const NAME_ERROR = 'Please, type your name in correctly';
            const EMAIL_ERROR = 'Please, type your email correctly';
            const MESSAGE_ERROR = 'Please, type your message correctly';
            const OTHER_ERROR = 'An error has occured while processing your request';
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
        ?>
            <section id="socialMediaSection">
                <div class="container">
                    <h2 class="contactHeader">You can contact me on:</h2>
                    <div class="socialMedia">
                        <a href="https://github.com/nikolamilun" target = "_blank"><img src="images/gitHubIcon.png" alt="GitHub"></a>
                        <a href="mailto:nikolamilun2508@gmail.com" target = "_blank"><img src="images/gmailIcon.png" alt="Gmail"></a>
                        <a href="https://www.facebook.com/zeljko.milun.3/" target = "_blank"><img src="images/facebookLogo.png" alt="Instagram"></a>
                        <a href="https://www.instagram.com/samolimun/" target = "_blank"><img src="images/instagramIcon.png" alt="Facebook"></a>
                        <a href="https://www.fiverr.com/nikolamilun" target = "_blank">A site whose logo I won't put here</a>
                    </div>
                </div>
            </section>
            <section id="messageForm">
                <h2>Send me a message!</h2>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method = "POST" id="mainForm">
                    <p>*Every field is required</p>
                    <div>
                        <label for="name">Your name, or name of your organization: </label>
                        <input type="text" name="name" placeholder="Your name here" maxlength = "30" required>
                    </div>
                    <div>
                        <label for="email">Your email:</label>
                        <input type="email" name="email" placeholder="example@domain.com" maxlength = "40" required>
                    </div>
                    <div>
                        <label for="message">Your message to me: </label>
                        <textarea name="message" id="message" cols="40" rows="20" placeholder = "Feel free to say anything!" style="resize: none;" required></textarea>
                    </div>
                    <input type="submit" class="submit">
                </form>
            </section>
        <?php }
            else{

                
                // MySQL connection properties   
                $servername = 'localhost';
                $username = 'root';
                $password = '';
                $database = "portfoliocontact";

                // validate name
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                if($name)
                {
                    $name = trim($name);
                    if ($name === '') {
                        $errors['name'] = NAME_ERROR;
                    }
                } else{
                    $errors['name'] = NAME_ERROR;
                }
                // validate email
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                if (!$email) {
                    $errors['email'] = EMAIL_ERROR;
                }
                // validate message
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
                if($message)
                {
                    $message = trim($message);
                    if ($message === '') {
                        $errors['message'] = MESSAGE_ERROR;
                    }
                } else{
                    $errors['message'] = MESSAGE_ERROR;
                }
                if(!count($errors)){
                    $conn = new mysqli($servername, $username, $password, $database);

                    if($conn-> connect_error)
                        $errors['other'] = OTHER_ERROR;
                    else
                        {
                            $cmdText = "INSERT INTO Message (name, email, message) VALUES('" .$name. "', '" .$email. "', '" .$message. "');";  
                            
                            if(mysqli_query($conn, $cmdText)){
                            ?>
                                <section id="formSubmitted">
                                    <h1>Thank you, <?php echo($_POST['name']);?> for contacting me.</h1>
                                    <p>I will review your message and answer it with an email as soon as possible!</p>
                                    <p>In the meantime, feel free to explore around the website!</p>
                                </section>
                            <?php
                            mysqli_close($conn); }
                            else
                                $errors['other'] = OTHER_ERROR;
                        }
                }
                else{ ?>
                    <section id="formSubmitted">
                        <h1>There has been an error processing your request.</h1>
                        <p>Check if you had written everything down correctly! The errors: </p>
                        <?php foreach($errors as $error){
                            echo("<p>$error</p>");
                        }?>
                    </section>
                <?php }
                } ?>
        <section id="footer">
            <footer>
                <p>Made by Nikola Milun© 2022</p>
                <p>All rights reserved</p>
                <p class="mima">Logo by <a href="https://www.instagram.com/eshi_mima/">EshiMima</a></p>
            </footer>
        </section>              
    </body>
</html>