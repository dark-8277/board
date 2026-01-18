<?php
session_start();

require_once("common/connect.php");
require_once("common/DBConn.php");

// 로그인 체크
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.html';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_SESSION['user_id']; 

    if (!$author) {
        post_json("0", "세션이 만료되었습니다. 다시 로그인해주세요.");
        exit;
    }

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
            'user_id'       => $author,
            'reg_date' => date('Y-m-d H:i:s'), // 시/분/초까지 넣으려면 형식을 바꿉니다.
            'view_cnt'        => 0
        ];

        // 클래스의 insertDynamic 기능을 사용하여 'list' 테이블에 데이터 삽입
        $result = $db->insertDynamic('board_write', $insertData);
        
        if ($result) {
            $newIdx = $db->getLastId();
            post_json("0", "글 등록 성공", $newIdx);
        }

    } catch (Exception $e) {
        // Connection refused 에러 등을 여기서 잡아냅니다.
        echo "에러 발생: " . $e->getMessage();
    }
}
function post_json($code, $msg, $idx) {
    echo json_encode(["code" => $code, "msg" => $msg, "idx" => $idx]);
    exit;
}
?>