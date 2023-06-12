<?php
    function getMinMaxDate() {
        $conn = mysqli_connect(SERVER, USER, PASSWORD, DB);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT MIN(date) AS minDate, MAX(date) AS maxDate FROM base";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Ошибка запроса: " . mysqli_error($conn);
        }

        $res = [];
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $res['minDate'] = $row['minDate'];
                $res['maxDate'] = $row['maxDate'];
            }
        } 
        mysqli_close($conn);
        return $res;
    }