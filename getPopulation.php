<?php

function getPopulation(){ 
    $conn = mysqli_connect(SERVER, USER, PASSWORD, DB);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM country";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Ошибка запроса: " . mysqli_error($conn);
    }
    $res = [];

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $res[$row['country']] = $row['population'];
        }
    } 

    mysqli_close($conn);
    return $res;
}