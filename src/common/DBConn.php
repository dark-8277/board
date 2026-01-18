<?php
class DBConn {
    private $mysqli;
    private $stmt;
    private $result;

    public function __construct($g_db) {
        // $this->mysqli = new mysqli($g_db['SERVER'], $g_db['SERVER_USERNAME'], $g_db['SERVER_PASSWORD'], $g_db['DATEBASE'], $g_db['PORT']);
        // $this->mysqli = new mysqli($g_db['SERVER'], $g_db['SERVER_USERNAME'], $g_db['SERVER_PASSWORD'], $g_db['DATEBASE'],(int)$g_db['PORT']); // 포트 번호를 정수형(int)으로 변환)'
        $this->mysqli = new mysqli($g_db['SERVER'], $g_db['SERVER_USERNAME'], $g_db['SERVER_PASSWORD'], $g_db['DATEBASE'], (int)$g_db['PORT']);
        if ($this->mysqli->connect_errno) {
            echo 'DB 연결 실패: ' . $this->mysqli->connect_error;
            die();
        }
        $this->mysqli->set_charset($g_db['CHARACTERSET']);
    }

	public function query($sql, $params = [], $types = '') {
		// params에 MySQL 함수(now(), etc)를 직접 전달하려면,
		// 특별한 토큰(예: :now:)을 사용하여 SQL을 작성하고, 이를 치환합니다.
		if ($params) {
			foreach ($params as $key => $value) {
				if (is_string($value) && preg_match('/^__FUNC__:(.+)$/', $value, $matches)) {
					// value가 "__FUNC__:now()" 형태면 SQL에 직접 치환
					$func = $matches[1];
					// :key 또는 ? 위치에 치환 (여기서는 ?만 지원)
					$pos = strpos($sql, '?');
					if ($pos !== false) {
						$sql = substr_replace($sql, $func, $pos, 1);
						unset($params[$key]);
					}
				}
			}
			// 치환 후 남은 params만 바인딩
			$params = array_values($params);
		}

		$this->stmt = $this->mysqli->prepare($sql);
		if (!$this->stmt) {
			die('쿼리 준비 실패: ' . $this->mysqli->error);
		}
		if ($params) {
			if (!$types) $types = str_repeat('s', count($params));
			$this->stmt->bind_param($types, ...$params);
		}
		$this->stmt->execute();
        if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|EXPLAIN)/i', $sql)) {
		    $this->result = $this->stmt->get_result();
		    return $this->result;
        }

        // INSERT, UPDATE, DELETE는 영향 받은 행 수 반환
        return $this->stmt->affected_rows;
	}

    public function fetch($sql, $params = [], $types = '') {
        $result = $this->query($sql, $params, $types);
        return $result ? $result->fetch_assoc() : null;
    }

    public function fetchAll($sql, $params = [], $types = '') {
        $result = $this->query($sql, $params, $types);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function execute($sql, $params = [], $types = '') {
		// params에 MySQL 함수(now(), etc)를 직접 전달하려면,
		// 특별한 토큰(예: :now:)을 사용하여 SQL을 작성하고, 이를 치환합니다.
		if ($params) {
			foreach ($params as $key => $value) {
				if (is_string($value) && preg_match('/^__FUNC__:(.+)$/', $value, $matches)) {
					// value가 "__FUNC__:now()" 형태면 SQL에 직접 치환
					$func = $matches[1];
					// :key 또는 ? 위치에 치환 (여기서는 ?만 지원)
					$pos = strpos($sql, '?');
					if ($pos !== false) {
						$sql = substr_replace($sql, $func, $pos, 1);
						unset($params[$key]);
					}
				}
			}
			// 치환 후 남은 params만 바인딩
			$params = array_values($params);
		}

		$this->stmt = $this->mysqli->prepare($sql);
        if (!$this->stmt) {
            die('쿼리 준비 실패: ' . $this->mysqli->error);
        }
        if ($params) {
            if (!$types) $types = str_repeat('s', count($params));
            $this->stmt->bind_param($types, ...$params);
        }
        return $this->stmt->execute();
    }

    public function lastInsertId() {
        return $this->mysqli->insert_id;
    }

    public function close() {
        if ($this->stmt instanceof mysqli_stmt) {
            if ($this->stmt->error === null) { // check if not already closed
                $this->stmt->close();
            }
            $this->stmt = null;
        }
        if ($this->mysqli instanceof mysqli) {
            $this->mysqli->close();
            $this->mysqli = null;
        }
    }
    public function __destruct() {
        $this->close(); // 객체가 소멸될 때 자동으로 연결 해제
    }

    public function fetchColumn(string $sql, array $params = [], string $types = '')
    {
        $result = $this->query($sql, $params, $types);
        if ($result) {
            $row = $result->fetch_row();
            return $row ? $row[0] : null;
        }
        return null;
    }


    //공통 INSERT문
    public function insertDynamic(string $tableName, array $data): bool
    {
        $columns = array_keys($data);
        $colString = implode(", ", $columns);
        $placeholders = implode(", ", array_fill(0, count($columns), "?"));
        $sql = "INSERT INTO {$tableName} ({$colString}) VALUES ({$placeholders})";
        $values = array_values($data);
        return $this->execute($sql, $values);
    }

    //공통 UPDATE문
    public function updateDynamic(string $tableName, array $data, array $where): bool
    {
        $setParts = [];
        foreach ($data as $col => $val) {
            $setParts[] = "$col = ?";
        }
        $setString = implode(", ", $setParts);

        // WHERE 절
        $whereParts = [];
        foreach ($where as $col => $val) {
            $whereParts[] = "$col = ?";
        }
        $whereString = implode(" AND ", $whereParts);

        $sql = "UPDATE {$tableName} SET {$setString} WHERE {$whereString}";
        $params = array_merge(array_values($data), array_values($where));

        return $this->execute($sql, $params);
    }

    //공통 UPSERT문
    public function upsertByWhereDynamic(string $tableName,
                                         array  $where,
                                         array  $insertData,
                                         array  $updateData): bool
    {
        // 1. SELECT COUNT(*)로 존재 여부 확인
        $whereParts = [];
        foreach ($where as $col => $val) {
            $whereParts[] = "$col = ?";
        }
        $whereClause = implode(' AND ', $whereParts);
        $whereParams = array_values($where);

        $checkSql = "SELECT COUNT(*) FROM {$tableName} WHERE {$whereClause}";
        $exists = $this->fetchColumn($checkSql, $whereParams) > 0;

        if ($exists) {
            // 2. UPDATE
            if (empty($updateData)) {
                $updateData = $insertData;
            }

            return $this->updateDynamic($tableName, $updateData, $where);
        } else {
            // 3. INSERT
            return $this->insertDynamic($tableName, $insertData);
        }
    }

    /**
     * DELETE
     *
     * @param string $tableName 테이블 이름
     * @param array $where 조건 (보통 m_id, m_no)
     * @param DBConn $db DB 객체
     * @return string "inserted" | "deleted" | "failed"
     */
    public function deleteDynamic(string $tableName, array $where): string
    {
        $conditionSql = implode(" AND ", array_map(fn($col) => "$col = ?", array_keys($where)));
        $conditionValues = array_values($where);

        // DELETE
        $sql = "DELETE FROM {$tableName} WHERE {$conditionSql}";
        $deleted = $this->execute($sql, $conditionValues);
        return $deleted ? "deleted" : "failed";
    }

    /**
     * 이미 있으면 DELETE, 없으면 insertDynamic() 호출
     *
     * @param string $tableName 테이블 이름
     * @param array $where 조건 (보통 m_id, m_no)
     * @param array $insertData insert 시 추가 데이터 (regDate 등)
     * @param DBConn $db DB 객체
     * @return string "inserted" | "deleted" | "failed"
     */
    public function insertOrDeleteDynamic(string $tableName, array $where, array $insertData): string
    {
        $conditionSql = implode(" AND ", array_map(fn($col) => "$col = ?", array_keys($where)));
        $conditionValues = array_values($where);

        // 이미 존재하는지 확인
        $exists = $this->fetch("SELECT 1 FROM {$tableName} WHERE {$conditionSql} LIMIT 1", $conditionValues);

        if ($exists) {
            // DELETE
            $sql = "DELETE FROM {$tableName} WHERE {$conditionSql}";
            $deleted = $this->execute($sql, $conditionValues);
            return $deleted ? "deleted" : "failed";
        } else {
            // INSERT using insertDynamic
            $insertAll = array_merge($where, $insertData);
            $inserted = $this->insertDynamic($tableName, $insertAll);
            return $inserted ? "inserted" : "failed";
        }
    }

    public function getLastId() {
    // $this->conn은 mysqli 연결 객체입니다.
        return $this->mysqli->insert_id;
    }
}
?>