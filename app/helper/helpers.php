<?php

function formatTime($time) {
    $formattedTime = '';

    if ($time) {
        $timeComponents = explode(':', $time);
        $hours = intval($timeComponents[0]);
        $minutes = intval($timeComponents[1]);
        $seconds = intval($timeComponents[2]);

        // Menghitung total waktu dalam hitungan menit
        $totalMinutes = ($hours * 60) + $minutes + ($seconds / 60);

        // Cek jika total menit tidak sama dengan 0, baru format dan tampilkan
        if ($totalMinutes !== 0) {
            $formattedTime = "{$totalMinutes} Minutes";
        }
    }

    return $formattedTime;
}
