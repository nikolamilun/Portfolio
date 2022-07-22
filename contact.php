<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            const NAME_ERROR = 'Please, type your name in correctly';
            const EMAIL_ERROR = 'Please, type your email correctly';
            const MESSAGE_ERROR = 'Please, type your message correctly';
            const OTHER_ERROR = 'An error has occured while processing your request';
            if($_SERVER['REQUEST_METHOD'] === 'GET'):
        ?>
        <section id="socialMediaSection">
            <div class="container">
                <h2 class="contactHeader">You can contact me on:</h2>
                <div class="socialMedia">
                    <a href="https://github.com/nikolamilun" target = "_blank"><img src="images/gitHubIcon.png" alt="GitHub"></a>
                    <a href="mailto: nikolamilun2508@gmail.com" target = "_blank"><img src="images/gmailIcon.png" alt="Gmail"></a>
                    <a href="https://www.facebook.com/zeljko.milun.3/" target = "_blank"><img src="images/facebookLogo.png" alt="Instagram"></a>
                    <a href="https://www.instagram.com/samolimun/" target = "_blank"><img src="images/instagramIcon.png" alt="Facebook"></a>
                    <a href="https://www.fiverr.com/nikolamilun" target = "_blank">A site whose logo I won't put here</a>
                </div>
            </div>
        </section>
        <section id="phpForm">
            <h2>Send me a message!</h2>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method = "POST" id="mainForm">
                <p>*Every field is required</p>
                <div>
                    <label for="name">Your name, or name of your organization: </label>
                    <input type="text" name="name" required>
                </div>
                <div>
                    <label for="email">Your email:</label>
                    <input type="email" name="email" maxlength = "20" required>
                </div>
                <div>
                    <label for="message">Your message to me: </label>
                    <textarea name="message" id="message" cols="40" rows="20" placeholder = "Feel free to say anything!" style="resize: none;" required></textarea>
                </div>
                <input type="submit" class="submit">
            </form>
        </section>
        <?php 
            else:
                // MySQL connection properties    
                $servername = 'localhost';
                $username = 'root';
                $password = '';

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
                if ($email) {
                    // validate email
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                    if ($email === false) {
                        $errors['email'] = EMAIL_ERROR;
                    }
                } else {
                    $errors['email'] = EMAIL_ERROR;
                }
                // validate message
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
                if($name)
                {
                    $name = trim($name);
                    if ($name === '') {
                        $errors['name'] = MESSAGE_ERROR;
                    }
                } else{
                    $errors['name'] = MESSAGE_ERROR;
                }
                if(!count($error)):
                {
                    $conn = new mysqli($servername, $username, $password);

                    if($conn-> connect_error):
                        $error['other'] = OTHER_ERROR;
                    else:
                    {
                        $cmdText = "INSERT INTO Message VALUES('$name', '$email', '$message');";   
                        if(mysqli_query($conn, $cmdText)):
                        ?>
                            <section id="formSubmitted">
                                <h1>Thank you, <?php echo($_POST['name']);?> for contacting me.</h1>
                                <p>I will review your message and answer it with an email as soon as possible!</p>
                                <p>In the meantime, feel free to explore around the website!</p>
                        </section>
                    <?php
                        else:
                            $error['other'] = OTHER_ERROR;
                    }
                }
                if(count($error)):
                {?>
                    <section id="formSubmitted">
                        <h1>There has been an error processing your request.</h1>
                        <p>Check if you had written everything down correctly!</p>
                </section>
                <?php}?>                  
    </body>
</html>
<!-- <a target="_blank" href="https://icons8.com/icon/P7UIlhbpWzZm/gmail">Gmail</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a> -->