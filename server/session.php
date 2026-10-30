<?php

// Stores PHP sessions in the database so login and cart survive on Vercel,
// where every request may run on a different instance with no shared disk.

if(session_status() === PHP_SESSION_NONE){

    if(getenv('VERCEL')){
        require_once __DIR__ . '/connection.php';

        $conn->query("CREATE TABLE IF NOT EXISTS `sessions` (
            `session_id` varchar(128) NOT NULL,
            `session_data` mediumtext NOT NULL,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`session_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        class DbSessionHandler implements SessionHandlerInterface {
            private $db;

            public function __construct($db){ $this->db = $db; }

            public function open($path, $name): bool { return true; }

            public function close(): bool { return true; }

            public function read($id): string|false {
                $stmt = $this->db->prepare("SELECT session_data FROM sessions WHERE session_id=?");
                $stmt->bind_param('s', $id);
                $stmt->execute();
                $stmt->bind_result($data);
                return $stmt->fetch() ? $data : '';
            }

            public function write($id, $data): bool {
                $stmt = $this->db->prepare("REPLACE INTO sessions(session_id, session_data) VALUES (?,?)");
                $stmt->bind_param('ss', $id, $data);
                return $stmt->execute();
            }

            public function destroy($id): bool {
                $stmt = $this->db->prepare("DELETE FROM sessions WHERE session_id=?");
                $stmt->bind_param('s', $id);
                return $stmt->execute();
            }

            public function gc($max_lifetime): int|false {
                $stmt = $this->db->prepare("DELETE FROM sessions WHERE updated_at < (NOW() - INTERVAL ? SECOND)");
                $stmt->bind_param('i', $max_lifetime);
                $stmt->execute();
                return $stmt->affected_rows;
            }
        }

        session_set_save_handler(new DbSessionHandler($conn), true);
    }

    // Never let a late call crash the page with a warning.
    if(!headers_sent()){
        session_start();
    }
}

?>
