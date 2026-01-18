<?php
session_start();
require_once __DIR__ . '/connect.php';
require_once __DIR__ . '/DBConn.php';

// 로그인 체크
if (!isset($_SESSION['username'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.html';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_SESSION['username']; 

    if (empty($title) || empty($content)) {
        echo "<script>alert('제목과 내용을 모두 입력해주세요.'); history.back();</script>";
        exit;
    }

    try {
        $db = new DBConn($G_DB);

        // 사용자가 입력한 글(title, content)과 세션 정보(author)를 대입
        $insertData = [
            'title'        => $title,
            'content'      => $content,
            'author'       => $author,
            'created_date' => date('Y-m-d H:i:s'), // 시/분/초까지 넣으려면 형식을 바꿉니다.
            'views'        => 0
        ];

        // 클래스의 insertDynamic 기능을 사용하여 'list' 테이블에 데이터 삽입
        $result = $db->insertDynamic('list', $insertData);

        if ($result) {
            echo "<script>alert('글이 등록되었습니다.'); location.href='board_list.html';</script>";
        } else {
            echo "<script>alert('등록 실패'); history.back();</script>";
        }
    } catch (Exception $e) {
        // Connection refused 에러 등을 여기서 잡아냅니다.
        echo "에러 발생: " . $e->getMessage();
    }
}
?>