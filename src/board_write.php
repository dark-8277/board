<?php
session_start();
require_once("common/connect.php");
require_once("common/DBConn.php");

// --- [1] Ajax 요청 처리부 (수정/등록/삭제 통합 처리) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_request'])) {
    header('Content-Type: application/json');
    
    $mode = $_POST['mode'] ?? '';
    $idx = $_POST['idx'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author = $_SESSION['user_id'] ?? '';

    // 로그인 체크
    if (!$author) {
        echo json_encode(["code" => "1", "msg" => "로그인이 필요합니다."]);
        exit;
    }

    try {
        $db = new DBConn($G_DB);

        // --- 삭제 로직 ---
        if ($mode === 'delete') {
            $sql = "DELETE FROM board_write WHERE idx = ? AND user_id = ?";
            $db->execute($sql, [$idx, $author]);
            echo json_encode(["code" => "0", "msg" => "삭제되었습니다."]);
            exit;
        }

        // --- 등록 및 수정 전 공통 체크 ---
        if (empty($title) || empty($content)) {
            echo json_encode(["code" => "2", "msg" => "제목과 내용을 입력해주세요."]);
            exit;
        }

        if ($mode === 'edit') {
            // 수정 로직
            $sql = "UPDATE board_write SET title = ?, content = ? WHERE idx = ? AND user_id = ?";
            $db->execute($sql, [$title, $content, $idx, $author]);
            echo json_encode(["code" => "0", "msg" => "수정되었습니다.", "idx" => $idx]);
        } else {
            // 등록 로직
            $insertData = [
                'title'    => $title,
                'content'  => $content,
                'user_id'  => $author,
                'reg_date' => date('Y-m-d H:i:s'),
                'view_cnt' => 0
            ];
            $db->insertDynamic('board_write', $insertData);
            echo json_encode(["code" => "0", "msg" => "등록되었습니다.", "idx" => $db->getLastId()]);
        }
    } catch (Exception $e) {
        echo json_encode(["code" => "3", "msg" => "DB 에러: " . $e->getMessage()]);
    }
    exit;
}

// --- [2] 데이터 로딩부 (화면 표시용) ---
$idx = $_GET['idx'] ?? '';
$mode = (!empty($idx)) ? 'edit' : 'write';

$title = "";
$content = "";
$buttonText = ($mode === 'edit') ? "수정" : "등록";
$headerText = ($mode === 'edit') ? "글 수정하기" : "새 글 작성하기";

if ($mode === 'edit' && !empty($idx)) {
    try {
        $db = new DBConn($G_DB);
        $sql = "SELECT title, content FROM board_write WHERE idx = ? AND user_id = ?";
        $result = $db->fetchAll($sql, [$idx, $_SESSION['user_id']]); 
        
        if ($result && count($result) > 0) {
            $row = $result[0]; 
            $title = $row['title'];
            $content = $row['content'];
        } else {
            echo "<script>alert('권한이 없거나 존재하지 않는 글입니다.'); history.back();</script>";
            exit;
        }
    } catch (Exception $e) {
        die("데이터 로딩 실패: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$headerText?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Pretendard', -apple-system, BlinkMacSystemFont, system-ui, Roboto, sans-serif;
            color: #333;
        }
        .container { max-width: 850px; }
        
        .write-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            margin-top: 50px;
            border: 1px solid #e9ecef;
        }

        .header-section {
            margin-bottom: 35px;
            border-bottom: 2px solid #f1f3f5;
            padding-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        /* 입력란 스타일링 */
        .form-control {
            border-radius: 10px;
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            transition: all 0.2s ease-in-out;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            border-color: #0d6efd;
        }
        #write_Title {
            font-size: 1.2rem;
            font-weight: 500;
        }
        #write_Content {
            line-height: 1.6;
        }

        /* 버튼 스타일링 */
        .btn-custom {
            padding: 12px 28px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .btn-primary-custom {
            background-color: #0d6efd;
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
        }
        .btn-danger-custom {
            background-color: #dc3545;
            border: none;
            color: white;
        }
        .btn-danger-custom:hover {
            background-color: #bb2d3b;
            transform: translateY(-1px);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // 삭제 함수
        function deletePost() {
            if (!confirm("정말 이 글을 삭제하시겠습니까?\n삭제된 데이터는 복구할 수 없습니다.")) return;

            const data = {
                ajax_request: 1,
                mode: "delete",
                idx: "<?=$idx?>"
            };

            $.ajax({
                url: "board_write.php",
                type: "POST",
                dataType: "json",
                data: data,
                success: function(res) {
                    if (res.code == "0") {
                        alert(res.msg);
                        location.href = "board_list.php";
                    } else {
                        alert(res.msg);
                    }
                }
            });
        }

        // 등록/수정 함수
        function submitForm() {
            const title = $("#write_Title").val().trim(); 
            const content = $("#write_Content").val().trim();

            if (!title) { alert('제목을 입력해주세요.'); $("#write_Title").focus(); return; }
            if (!content) { alert('내용을 입력해주세요.'); $("#write_Content").focus(); return; }

            const data = {
                ajax_request: 1,
                mode: "<?=$mode?>",
                idx: "<?=$idx?>",
                title: title,
                content: content
            };

            $.ajax({
                url: "board_write.php",
                type: "POST",
                dataType: "json",
                data: data,
                success: function(res) {
                    if (res.code == "0") {
                        alert(res.msg);
                        location.href = "board_show.php?idx=" + res.idx;
                    } else {
                        alert(res.msg);
                    }
                }
            });
        }
    </script>
</head>
<body>
    <div class="container pb-5">
        <div class="write-card">
            <div class="header-section text-center">
                <h2 class="fw-bold"><i class="fa-solid <?=($mode === 'edit') ? 'fa-pen-to-square' : 'fa-pen-nib'?> me-2 text-primary"></i> <?=$headerText?></h2>
            </div>

            <form onsubmit="return false;">
                <div class="mb-4">
                    <label for="write_Title" class="form-label"></i> 제목</label>
                    <input id="write_Title" type="text" class="form-control" 
                           placeholder="제목을 입력해주세요" value="<?=htmlspecialchars($title)?>">
                </div>

                <div class="mb-4">
                    <label for="write_Content" class="form-label"></i> 내용</label>
                    <textarea id="write_Content" class="form-control" rows="12" 
                              placeholder="내용을 입력해주세요" style="resize: none;"><?=htmlspecialchars($content)?></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-2">
                    <a href="board_list.php" class="btn btn-outline-secondary btn-custom">
                        <i class="fa-solid fa-chevron-left me-1"></i> 취소
                    </a>
                    
                    <div class="d-flex gap-2">
                        <?php if ($mode === 'edit'): ?>
                            <button type="button" class="btn btn-danger-custom btn-custom" onclick="deletePost();">
                                <i class="fa-solid fa-trash-can me-1"></i> 삭제
                            </button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-primary-custom btn-custom" onclick="submitForm();">
                            <i class="fa-solid fa-check me-1"></i> <?=$buttonText?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>