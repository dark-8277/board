<?php
session_start();

// 응답을 항상 JSON으로 설정합니다.
header('Content-Type: application/json');

require_once __DIR__ . '/common/connect.php'; 
require_once __DIR__ . '/common/DBConn.php';

try {
    $db = new DBConn($G_DB);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. 데이터 가져오기
        $user_id  = trim($_POST['user_id'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['user_pw'] ?? '');

        // 2. 유효성 검사 (JSON 응답 사용)
        if (!$user_id)  { post_json("0", "아이디를 입력해 주세요."); }
        if (!$email)    { post_json("0", "이메일을 입력해 주세요."); }
        if (!$password) { post_json("0", "비밀번호를 입력해 주세요."); }

        // 3. 데이터 삽입 시도
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userData = [ 
            'user_id' => $user_id,
            'email'   => $email,
            'user_pw' => $hashedPassword
        ];

        // 테이블 이름 'users'가 DB에 실제로 존재하는지 확인하세요.
        $db->insertDynamic('users', $userData);

        // 4. 성공 응답 (HTML의 res.code == "1"과 맞춤)
        post_json("1", "회원가입이 완료되었습니다!");
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    
    // 중복 아이디 에러 처리
    if (strpos($errorMsg, 'Duplicate') !== false) {
        post_json("0", "이미 사용 중인 아이디입니다.");
    } else {
        post_json("0", "에러 발생: " . $errorMsg);
    }
}

// 응답 함수
function post_json($code, $msg) {
    echo json_encode(["code" => $code, "msg" => $msg]);
    exit;
}
?>