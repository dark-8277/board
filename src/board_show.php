<?php
session_start();
require_once("common/connect.php");
require_once("common/DBConn.php");

$idx = $_GET['idx'] ?? '';

if (!$idx) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='board_list.php';</script>";
    exit;
}

try {
    $db = new DBConn($G_DB);
    $selectSql = "SELECT * FROM sys.board_write WHERE idx = ?";
    // fetchAll 사용 시 첫 번째 행([0])을 가져옵니다.
    $result = $db->fetchAll($selectSql, [$idx]);
    $view = $result[0] ?? null;

    if (!$view) {
        echo "<script>alert('글을 찾을 수 없습니다.'); location.href='board_list.php';</script>";
        exit;
    }
} catch (Exception $e) {
    die("에러 발생: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($view['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/static/pretendard.min.css" />
    
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Pretendard', sans-serif;
        }
        .container { max-width: 900px; }
        
        /* 카드 디자인 개선 */
        .view-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-top: 50px;
        }

        /* 헤더: 제목 정렬 */
        .view-header {
            padding: 30px 40px;
            border-bottom: 1px solid #f1f3f5;
        }
        .view-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #212529;
            text-align: left; /* 왼쪽 정렬 강제 */
        }
        .view-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: #868e96;
        }

        /* 본문: 센터 정렬 문제 해결 핵심 */
        .view-content {
            padding: 40px;
            min-height: 300px;
            text-align: left; /* 왼쪽 정렬 강제 */
            line-height: 1.8;
            font-size: 1.05rem;
            color: #495057;
            white-space: pre-wrap; /* 줄바꿈 유지 */
            word-break: break-all;
        }

        /* 버튼 영역 */
        .view-footer {
            padding: 20px 40px;
            background-color: #fafbfc;
            border-top: 1px solid #f1f3f5;
            border-radius: 0 0 12px 12px;
        }
        .btn-custom {
            padding: 8px 20px;
            font-weight: 500;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="view-card">
        <div class="view-header">
            <div class="view-title"><?php echo htmlspecialchars($view['title']); ?></div>
            <div class="view-meta">
                <span>작성자: <strong><?php echo htmlspecialchars($view['user_id']); ?></strong></span>
                <span>작성일: <?php echo date('Y-m-d H:i', strtotime($view['reg_date'])); ?></span>
            </div>
        </div>

        <div class="view-content">
            <?php echo nl2br(htmlspecialchars($view['content'])); ?>
        </div>

        <div class="view-footer d-flex justify-content-end gap-2">
            <a href="board_list.php" class="btn btn-outline-secondary btn-custom">목록</a>
            
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $view['user_id']): ?>
                <a href="board_write.php?idx=<?php echo $idx; ?>" class="btn btn-warning btn-custom">수정</a>
                <button type="button" class="btn btn-danger btn-custom" onclick="deletePost();">삭제</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function deletePost() {
        if (confirm("정말로 이 게시물을 삭제하시겠습니까?")) {
            // 이전에 만든 board_write.php의 삭제 로직을 호출합니다.
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'board_write.php';

            const fields = {
                'ajax_request': 1,
                'mode': 'delete',
                'idx': '<?php echo $idx; ?>'
            };

            for (const key in fields) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = fields[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            
            // 삭제 시에는 Ajax 대신 직접 POST를 날리거나, 
            // 더 깔끔하게 처리하려면 아래와 같이 Ajax를 사용하세요.
            fetch('board_write.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(fields)
            })
            .then(res => res.json())
            .then(data => {
                if(data.code == "0") {
                    alert("삭제되었습니다.");
                    location.href = "board_list.php";
                } else {
                    alert(data.msg);
                }
            });
        }
    }
</script>

</body>
</html>