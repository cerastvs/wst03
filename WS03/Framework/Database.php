<?php

namespace Framework;

class Database
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get data from JSON file
     */
    protected function getData($table)
    {
        $file = $this->config[$table];
        if (!file_exists($file)) {
            return [];
        }
        $json = file_get_contents($file);
        return json_decode($json, true) ?: [];
    }

    /**
     * Save data to JSON file
     */
    protected function saveData($table, $data)
    {
        $file = $this->config[$table];
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function query($query, $params = [])
    {
        $query = trim($query);
        $results = [];

        if (stripos($query, 'SELECT') === 0) {
            preg_match('/FROM\s+(\w+)/i', $query, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            // Simple WHERE clause handling
            if (stripos($query, 'WHERE') !== false) {
                if (strpos($query, 'LIKE') !== false && (strpos($query, 'OR') !== false || strpos($query, 'AND') !== false)) {
                    // Specialized handling for the search query
                    $keywords = isset($params['keywords']) ? trim($params['keywords'], '%') : '';
                    $location = isset($params['location']) ? trim($params['location'], '%') : '';

                    $data = array_filter($data, function ($item) use ($keywords, $location) {
                        $matchKeywords = empty($keywords) ||
                            stripos($item['title'] ?? '', $keywords) !== false ||
                            stripos($item['description'] ?? '', $keywords) !== false ||
                            stripos($item['tags'] ?? '', $keywords) !== false ||
                            stripos($item['company'] ?? '', $keywords) !== false;

                        $matchLocation = empty($location) ||
                            stripos($item['city'] ?? '', $location) !== false ||
                            stripos($item['state'] ?? '', $location) !== false;

                        return $matchKeywords && $matchLocation;
                    });
                } else {
                    // Simple filtering for id = :id, email = :email, etc.
                    foreach ($params as $key => $value) {
                        $key = ltrim($key, ':');
                        $data = array_filter($data, function ($item) use ($key, $value) {
                            return ($item[$key] ?? null) == $value;
                        });
                    }
                }
            }

            // ORDER BY created_at DESC
            if (stripos($query, 'ORDER BY created_at DESC') !== false) {
                usort($data, function ($a, $b) {
                    return strtotime($b['created_at'] ?? '') - strtotime($a['created_at'] ?? '');
                });
            }

            // LIMIT
            if (preg_match('/LIMIT\s+(\d+)/i', $query, $matches)) {
                $data = array_slice($data, 0, (int)$matches[1]);
            }

            $results = array_values($data);
        } elseif (stripos($query, 'INSERT INTO') === 0) {
            preg_match('/INSERT INTO\s+(\w+)/i', $query, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            $newItem = [];
            foreach ($params as $key => $value) {
                $newItem[ltrim($key, ':')] = $value;
            }
            
            // Auto-increment ID
            $maxId = 0;
            foreach ($data as $item) {
                if (($item['id'] ?? 0) > $maxId) {
                    $maxId = $item['id'];
                }
            }
            $newItem['id'] = $maxId + 1;
            $newItem['created_at'] = date('Y-m-d H:i:s');
            
            $data[] = $newItem;
            $this->saveData($table, $data);
            
            // Store last insert id in a property to simulate PDO
            $this->lastInsertId = $newItem['id'];
        } elseif (stripos($query, 'UPDATE') === 0) {
            preg_match('/UPDATE\s+(\w+)/i', $query, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            $id = $params['id'] ?? null;
            if ($id) {
                foreach ($data as &$item) {
                    if ($item['id'] == $id) {
                        foreach ($params as $key => $value) {
                            $key = ltrim($key, ':');
                            if ($key !== 'id') {
                                $item[$key] = $value;
                            }
                        }
                    }
                }
                $this->saveData($table, $data);
            }
        } elseif (stripos($query, 'DELETE FROM') === 0) {
            preg_match('/FROM\s+(\w+)/i', $query, $matches);
            $table = $matches[1] ?? '';
            $data = $this->getData($table);

            $id = $params['id'] ?? null;
            if ($id) {
                $data = array_filter($data, function ($item) use ($id) {
                    return $item['id'] != $id;
                });
                $this->saveData($table, array_values($data));
            }
        }

        return new class($results) {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function fetchAll() {
                return array_map(function($item) { return (object)$item; }, $this->data);
            }
            public function fetch() {
                return !empty($this->data) ? (object)$this->data[0] : null;
            }
        };
    }
    
    public $lastInsertId;
    
    // To mimic $this->db->conn->lastInsertId()
    public function __get($name) {
        if ($name === 'conn') {
            return $this;
        }
        return null;
    }
    
    public function lastInsertId() {
        return $this->lastInsertId;
    }
}
