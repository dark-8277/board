<?php
session_start();

require_once __DIR__ . '/connect.php'; 
require_once __DIR__ . '/DBConn.php';

// 2. DB 연결 객체 생성 (이 부분이 빠져서 에러가 났던 것입니다)
$db = new DBConn($G_DB);

var_dump($G_DB);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. 데이터 가져오기
    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 2. 빈 칸 체크 (알림창 띄우고 뒤로가기)
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>
            alert('모든 칸을 채워주세요.');
            history.back(); 
        </script>";
        exit;
    }

    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userData = [
            'username' => $username,
            'email'    => $email,
            'password' => $hashedPassword
        ];

        $result = $db->insertDynamic('users', $userData);

        if ($result) {
            // 3. 등록 성공 시 알림창 띄우고 페이지 이동
            echo "<script>
                alert('회원가입이 완료되었습니다!');
                location.href='login.html';
            </script>";
        } else {
            // 4. 실패 시 알림창
            echo "<script>
                alert('등록에 실패했습니다. 다시 시도해주세요.');
                history.back();
            </script>";
        }

    } catch (Exception $e) {
        // 에러 발생 시 알림창으로 에러 내용 확인
        $errorMsg = addslashes($e->getMessage()); // 따옴표 에러 방지
        echo "<script>
            alert('에러가 발생했습니다: $errorMsg');
            history.back();
        </script>";
    }
}
?>