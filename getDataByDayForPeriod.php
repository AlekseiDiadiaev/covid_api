<?php
function getDataByDayForPeriod($from, $to){
    $conn = mysqli_connect(SERVER, USER, PASSWORD, DB);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM base WHERE date >= '{$from}' AND date <= '{$to}'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Ошибка запроса: " . mysqli_error($conn);
    }
    $res = [];

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $res[] = $row;
        }
    } 

    mysqli_close($conn);
    return $res;
}