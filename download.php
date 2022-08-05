<?php
    $servername = 'localhost';
    $username = 'root';
    $sqlPassword = '';
    $database = "portfoliocontact";

    $conn = new mysqli($servername, $username, $sqlPassword, $database);
    if($conn->connect_error)
        $errors['other'] = OTHER_ERROR;
    else
    {
        $queryText = 'SELECT name, email, message FROM message WHERE date > DATE_ADD(CURDATE(), INTERVAL "-3" DAY) ORDER BY date DESC';

        $result = mysqli_query($conn, $queryText);

        $data = array();

        while($row = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            array_push($data, array($row[0], $row[1], $row[2]));
        }

        mysqli_close($conn);
    }
    
    $file_name = "report.txt";

    $f = fopen($file_name, 'w+');

    foreach($data as $row)
        {
            fputs($f, "Name: $row[0] \n");
            fputs($f, "Email: $row[1] \n");
            fputs($f, "Message: $row[2] \n");
        }

    fclose($f);

    if (file_exists($file_name)) {
        header('Content-Type: application/octet-stream');  
        header("Content-Transfer-Encoding: utf-8");   
        header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");   
        readfile($file_name);
        exit;
    }
    echo("An error has occured during the download");
?>