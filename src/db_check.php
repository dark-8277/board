<?php
require_once 'connect.php';
require_once 'DBConn.php';

try {
    $db = new DBConn($G_DB);
    $sql = "DESCRIBE board";
    $result = $db->query($sql);
    
    if ($result) {
        echo "Success: 'board' table exists.\n";
        $columns = [];
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row['Field'];
        }
        echo "Columns: " . implode(', ', $columns);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
