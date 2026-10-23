<?php
function track_visit($conn)
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $url = $_SERVER['REQUEST_URI'] ?? '';

    $ip = mysqli_real_escape_string($conn, $ip);
    $url = mysqli_real_escape_string($conn, $url);

    mysqli_query($conn, "INSERT INTO page_visits (ip_address, url) VALUES ('$ip', '$url')");
}

track_visit($conn);
