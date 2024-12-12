<?php

if (!function_exists('fn_log')) {
    function fn_log($content, $title = '') {
        // $content가 문자열인지 확인
        if (is_string($content)) {
            // 문자열일 경우 JSON 유효성 확인
            if (json_decode($content) === null) {
                // JSON이 아니라면 JSON으로 변환
                $content = json_encode(["original_content" => $content], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        } else {
            // 문자열이 아니면 JSON으로 변환
            $content = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // 로그 출력
        if ($title !== '') {
            log_message('error', "<=====================" . $title . "====================>");
        }
        log_message('error', $content);
    }
}
