<?php
    // 파이썬 파일 실행 및 결과 받아오기
    $result = exec("python C:/www/mixxplayer/www/test.py");

    // 결과 출력
    print_r($result);
?>