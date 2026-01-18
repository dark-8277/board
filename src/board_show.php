<?php
session_start();
require_once("common/connect.php");
require_once("common/DBConn.php");

// 1. 넘어온 idx 값 확인 (화면에 출력해보기)
$idx = $_GET['idx'] ?? '';
// echo "넘어온 번호: " . $idx; // 주석 풀어서 확인해보세요.

if (!$idx) {
    echo "<script>alert('번호가 넘어오지 않았습니다.'); location.href='board_list.php';</script>";
    exit;
}

try {
    $db = new DBConn($G_DB);
    
    // 2. 테이블 이름 확인 (이미지에는 board_write인데 쿼리에도 정확한지)
    // 3. sys 데이터베이스 명시해보기
    $selectSql = "SELECT * FROM sys.board_write WHERE idx = ?";
    $view = $db->fetch($selectSql, [$idx]);

    if (!$view) {
        // DB 응답이 없을 때
        die("DB에서 글을 찾지 못했습니다. (입력받은 번호: $idx)");
    }
} catch (Exception $e) {
    echo "에러 발생: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 보기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 1. 카드의 모든 텍스트 기본값을 왼쪽 정렬로 강제 고정 */
        .card, .card-body, .blockquote {
            text-align: left !important;
        }

        /* 2. 블록쿼트의 기본 왼쪽 여백(심미적 효과)과 정렬 */
        .blockquote {
            margin-left: 0 !important;
            padding-left: 15px;
            border-left: 5px solid #dee2e6; /* 왼쪽 정렬임을 보여주는 세로줄 */
        }

        /* 3. 본문 텍스트가 상자 밖으로 나가지 않게 조절 */
        .card-body p {
            text-align: left !important;
            display: block;
            width: 100%;
        }
    </style>
    
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">게시글 보기</h1>
        
        <div class="card-footer text-muted d-flex justify-content-between mb-2">
                <span>작성자: <?php echo htmlspecialchars($view['user_id']); ?></span>
                <span>작성일: <?php echo $view['reg_date']; ?></span>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="text-start"><?php echo htmlspecialchars("제목: " . $view['title']); ?></h3>
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0 text-start">
                    <p style="white-space: pre-wrap;" class="text-start">
                        <?php echo nl2br(htmlspecialchars("내용: ". $view['content'])); ?>
                    </p>
                </blockquote>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="board_list.php" class="btn btn-secondary me-2">목록</a>
            
            <?php if($_SESSION['user_id'] == $view['user_id']): ?>
                <a href="board_edit.php?idx=<?php echo $idx; ?>" class="btn btn-warning me-2">수정</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function deletePost(idx) {
            if (confirm('정말로 이 게시글을 삭제하시겠습니까?')) {
                // 삭제를 처리할 PHP 파일로 이동
                window.location.href = 'board_delete.php?idx=' + idx;
            }
        }
    </script>
</body>
</html>