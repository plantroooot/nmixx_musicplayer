<?php
const COMPANY_NAME = "NMIXX 음원총공팀";                     // 업체명
const SSL_USE = false;                              // SSL 사용여부
define("SERVER_PORT", ":".$_SERVER['SERVER_PORT']);                  // 서버포트
const COMPANY_URL = "http://mixxplayer.kr" . SERVER_PORT;      // URL
const COMPANY_URL2 = "http://mixxplayer.kr" . SERVER_PORT;      // URL2
//define("COMPANY_URL_MO", "http://");   // MOBILE URL
const COMPANY_SSL_URL = "https://mixxplayer.kr" . SERVER_PORT;   // SSL URL
//define("DB_ENCRYPTION", "password");                     // db 암호화방식
const DB_ENCRYPTION = "CONCAT('*', UPPER(SHA1(UNHEX(SHA1(";                     // db 암호화방식

const CHECK_REFERER = true;                                    // 레퍼러값 체크여부
const REFERER_URL = "mixxplayer";                                // 레퍼러 비교 도메인(www 제외)
const EDITOR_UPLOAD_PATH = "/upload/editor/";                // editor 이미지 업로드 경로
const EDITOR_MAXSIZE = 5 * 1024 * 1024;                            // editor 이미지 업로드 최대사이트 (50MB)

const START_PAGE = COMPANY_URL."/admin/schedule/";
?>