<?php
session_start();

require_once __DIR__ . '/common/connect.php'; 
require_once __DIR__ . '/common/DBConn.php';

// 2. DB 연결 객체 생성 (이 부분이 빠져서 에러가 났던 것입니다)
$db = new DBConn($G_DB);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. 데이터 가져오기
    $user_id = $_POST['user_id'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['user_pw'] ?? '';

    if (!$user_id) {
        post_json("-1", "아이디를 입력해 주세요.");
    }

    if (!$email) {
        post_json("-2", "이메일을 입력해 주세요.");
    }

    if (!$password) {
        post_json("-3", "비밀번호를 입력해 주세요.");
    }

    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // 비밀번호 해시로 변경
        $userData = [ 
            'user_id' => $user_id,
            'email'    => $email,
            'user_pw' => $hashedPassword
        ];

        $result = $db->insertDynamic('users', $userData); // user table insert

    } catch (Exception $e) {
        // 에러 발생 시 알림창으로 에러 내용 확인
        $errorMsg = addslashes($e->getMessage()); // 따옴표 에러 방지
  

        if (strpos($errorMsg, 'Duplicate') !== false || strpos($errorMsg, '중복') !== false) {
    // 아이디 중복 시 알림창 띄우고 이전 페이지로 이동
      echo "<script>
            alert('이미 사용 중인 아이디입니다. 다른 아이디를 입력해 주세요.');
            history.back();
          </script>";
} else {
    // 기타 에러 발생 시 에러 내용 출력
    echo "<script>
            alert('에러가 발생했습니다: " . $errorMsg . "');
            history.back();
          </script>";
}
exit; // 스크립트 실행 후 아래 PHP 코드가 실행되지 않도록 중단
    }
}

function post_json($code, $msg) {
    echo json_encode(["code" => $code, "msg" => $msg]);
    exit;
}
?>
