<?php

class PDOMock {
    private $dataDir;
    private $lastId;

    public function __construct() {
        $this->dataDir = __DIR__ . '/data';
    }

    private function getData($table) {
        $file = $this->dataDir . '/' . $table . '.json';
        if (!file_exists($file)) return [];
        return json_decode(file_get_contents($file), true) ?: [];
    }

    private function saveData($table, $data) {
        $file = $this->dataDir . '/' . $table . '.json';
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function prepare($sql) {
        return new PDOStatementMock($sql, $this);
    }

    public function query($sql) {
        $stmt = new PDOStatementMock($sql, $this);
        $stmt->execute();
        return $stmt;
    }

    public function lastInsertId() {
        return $this->lastId;
    }

    public function setLastInsertId($id) {
        $this->lastId = $id;
    }

    // Helper for PDOStatementMock
    public function executeSql($sql, $params) {
        $sql = trim($sql);
        
        if (stripos($sql, 'SELECT') === 0) {
            preg_match('/FROM\s+(\w+)/i', $sql, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            if (stripos($sql, 'WHERE') !== false) {
                foreach ($params as $key => $value) {
                    $cleanKey = ltrim($key, ':');
                    $data = array_filter($data, function($item) use ($cleanKey, $value) {
                        return ($item[$cleanKey] ?? null) == $value;
                    });
                }
            }

            if (stripos($sql, 'ORDER BY created_at DESC') !== false) {
                usort($data, function($a, $b) {
                    return strtotime($b['created_at'] ?? '') - strtotime($a['created_at'] ?? '');
                });
            }

            if (preg_match('/LIMIT\s+(\d+)/i', $sql, $matches)) {
                $data = array_slice($data, 0, (int)$matches[1]);
            }

            return array_values($data);
        }

        if (stripos($sql, 'INSERT INTO') === 0) {
            preg_match('/INSERT INTO\s+(\w+)/i', $sql, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            $newItem = [];
            foreach ($params as $key => $value) {
                $newItem[ltrim($key, ':')] = $value;
            }

            $maxId = 0;
            foreach ($data as $item) {
                if (($item['id'] ?? 0) > $maxId) $maxId = $item['id'];
            }
            $newItem['id'] = $maxId + 1;
            $newItem['created_at'] = date('Y-m-d H:i:s');
            
            $data[] = $newItem;
            $this->saveData($table, $data);
            $this->lastId = $newItem['id'];
            return true;
        }

        if (stripos($sql, 'UPDATE') === 0) {
            preg_match('/UPDATE\s+(\w+)/i', $sql, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            $id = $params[':id'] ?? $params['id'] ?? null;
            if ($id) {
                foreach ($data as &$item) {
                    if ($item['id'] == $id) {
                        foreach ($params as $key => $value) {
                            $cleanKey = ltrim($key, ':');
                            if ($cleanKey !== 'id') $item[$cleanKey] = $value;
                        }
                    }
                }
                $this->saveData($table, $data);
            }
            return true;
        }

        if (stripos($sql, 'DELETE') === 0) {
            preg_match('/FROM\s+(\w+)/i', $sql, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            $id = $params[':id'] ?? $params['id'] ?? null;
            if ($id) {
                $data = array_filter($data, function($item) use ($id) {
                    return $item['id'] != $id;
                });
                $this->saveData($table, array_values($data));
            }
            return true;
        }

        return [];
    }
}

class PDOStatementMock {
    private $sql;
    private $pdo;
    private $results = [];
    private $params = [];
    private $success = false;

    public function __construct($sql, $pdo) {
        $this->sql = $sql;
        $this->pdo = $pdo;
    }

    public function execute($params = []) {
        $this->params = array_merge($this->params, $params);
        $res = $this->pdo->executeSql($this->sql, $this->params);
        if (is_array($res)) {
            $this->results = $res;
            $this->success = true;
        } else {
            $this->success = $res;
        }
        return $this->success;
    }

    public function bindValue($param, $value, $type = null) {
        $this->params[$param] = $value;
    }

    public function fetch() {
        $res = array_shift($this->results);
        return $res ? $res : false;
    }

    public function fetchAll() {
        return $this->results;
    }

    public function rowCount() {
        return is_array($this->results) ? count($this->results) : ($this->success ? 1 : 0);
    }
}

$pdo = new PDOMock();
