<?php
session_start();

require_once("common/connect.php");
require_once("common/DBConn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $user_pw = $_POST['user_pw'] ?? '';

    if (empty($user_id) || empty($user_pw)) {
        echo "Please fill in all fields.";
        exit;
    }

    try {
        $db = new DBConn($G_DB);

        // Fetch user by username
        $sql = "SELECT user_id, user_pw FROM users WHERE user_id = ?";
        $user = $db->fetch($sql, [$user_id]);
   
        if ($user && isset($user['user_pw'])) {

            if (password_verify($user_pw, $user['user_pw'])) {
                // 로그인 성공 로직
                $_SESSION['user_id'] = $user['user_id'];
     
                // 응답 보내기
                post_json("0", "로그인 성공");
                exit;
            } else {
                 post_json("-1", "비밀번호가 맞지 않습니다.");
            }
        } else {
            post_json("-2", "아이디가 맞지 않습니다.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function post_json($code, $msg) {
    echo json_encode(["code" => $code, "msg" => $msg]);
    exit;
}
?>