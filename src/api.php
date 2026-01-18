<?php
// 1. 설정 파일 및 DB 클래스 포함 (더 안정적인 __DIR__ 사용)
require_once __DIR__ . '/connect.php';
require_once __DIR__ . '/DBConn.php';

// 응답 헤더를 JSON으로 설정
header('Content-Type: application/json');

// 요청 메서드에 따라 분기
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // GET 요청 처리 (기존 코드)
        try {
            $db = new DBConn($G_DB);
            $sql = "SELECT id, title, '임시작성자' as author, DATE(created_at) as created_date, 0 as views FROM board ORDER BY id DESC";
            $result = $db->fetchAll($sql);
            echo json_encode(['status' => 'success', 'data' => $result]);
        } catch (Exception $e) {
            file_put_contents('error.log', $e->getMessage() . PHP_EOL, FILE_APPEND);
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '서버 오류가 발생했습니다: ' . $e->getMessage()]);
        }
        break;

    case 'POST':
        // POST 요청 처리 (글쓰기)
        try {
            // 요청 본문에서 JSON 데이터 읽기
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            // 데이터 유효성 검사
            if (!isset($data['title']) || !isset($data['content'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => '제목과 내용을 모두 입력해주세요.']);
                exit;
            }

            $db = new DBConn($G_DB);

            // 'board' 테이블에 데이터 삽입
            $insertData = [
                'title' => $data['title'],
                'content' => $data['content']
                // 'created_at' 및 다른 필드는 DB 기본값 또는 트리거로 처리되도록 둠
            ];

            // DBConn의 insertDynamic 메소드를 사용한다고 가정
            // 클래스에 이 메소드가 없다면 직접 구현해야 함
            $success = $db->insertDynamic('board', $insertData);

            if ($success) {
                echo json_encode(['status' => 'success', 'message' => '게시글이 성공적으로 등록되었습니다.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => '게시글 등록에 실패했습니다.']);
            }
        } catch (Exception $e) {
            file_put_contents('error.log', $e->getMessage() . PHP_EOL, FILE_APPEND);
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '서버 오류가 발생했습니다: ' . $e->getMessage()]);
        }
        break;

    default:
        // 허용되지 않은 메서드
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
        break;
}
?>