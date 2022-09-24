<!-- This is the script which downloads a txt file with all of the messages written in it. -->

<?php
    // MySQL connection properties
    $servername = 'localhost';
    $username = 'root';
    $sqlPassword = '';
    $database = "portfoliocontact";

    // Establish connection
    $conn = new mysqli($servername, $username, $sqlPassword, $database);
    // Check for connection errors
    if($conn->connect_error)
        $errors['other'] = OTHER_ERROR;
    else
    {
        // Select all the messages
        $queryText = 'SELECT name, email, message FROM message ORDER BY date DESC';

        $result = mysqli_query($conn, $queryText);

        $data = array();

        // Fetch the messages in an array
        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            array_push($data, array($row[0], $row[1], $row[2]));
        }

        mysqli_close($conn);
    }
    
    $file_name = "report.txt";

    // Create a file where the data will be written
    $f = fopen($file_name, 'w+');

    // Write the data in the file
    foreach($data as $row)
        {
            fputs($f, "Name: $row[0] \n");
            fputs($f, "Email: $row[1] \n");
            fputs($f, "Message: $row[2] \n");
        }

    // Close the file
    fclose($f);

    // Download it (i don't know how this works either)
    if (file_exists($file_name)) {
        header('Content-Type: application/octet-stream');  
        header("Content-Transfer-Encoding: utf-8");   
        header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");   
        readfile($file_name);
        exit;
    }
    // If an error has occured
    echo("An error has occured during the download");
?>