<?php
session_start();
require_once("common/connect.php");
require_once("common/DBConn.php");

try {
    $db = new DBConn($G_DB);
    
    // 1. 전체 게시글을 최신순으로 가져오는 SQL
    // board_list.php 수정
    $sql = "SELECT idx, title, user_id, reg_date FROM sys.board_write ORDER BY idx DESC";
    
    // 2. 여러 줄의 데이터를 배열로 가져옵니다.
    $list = $db->fetchAll($sql); 
} catch (Exception $e) {
    die("데이터 로딩 에러: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Pretendard', -apple-system, BlinkMacSystemFont, system-ui, Roboto, sans-serif;
        }
        .container { max-width: 900px; }
        .board-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .table thead th {
            background-color: #f1f3f5;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            text-align: center;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            text-align: center;
            color: #343a40;
        }
        .title-td {
            text-align: left !important;
            font-weight: 500;
        }
        .title-td a {
            text-decoration: none;
            color: #212529;
            transition: color 0.2s;
        }
        .title-td a:hover { color: #0d6efd; }
        .btn-write {
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="board-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="fa-solid fa-list-ul me-2"></i>자유 게시판</h2>
            <a href="board_write.html" class="btn btn-primary btn-write">
                <i class="fa-solid fa-pen me-1"></i> 글쓰기
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 10%">번호</th>
                        <th style="width: 50%">제목</th>
                        <th style="width: 20%">작성자</th>
                        <th style="width: 20%">작성일</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list)): ?>
                        <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['idx']; ?></td>
                            <td class="title-td">
                                <a href="show.php?idx=<?php echo $row['idx']; ?>">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td class="text-muted small"><?php echo date('Y-m-d', strtotime($row['reg_date'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-5 text-center text-muted">
                                등록된 게시글이 없습니다. 첫 글을 작성해 보세요!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
            </ul>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>