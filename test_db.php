<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=laravel_clinic', 'root', '');
    echo "Database connection successful!\n";
    
    // Check patients table column
    $stmt = $pdo->query("DESCRIBE patients");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (in_array('remember_token', $columns)) {
        echo "remember_token column exists in patients table.\n";
    } else {
        echo "remember_token column MISSING in patients table.\n";
    }

    // Check users table
    $stmt = $pdo->query("SELECT count(*) FROM users WHERE role_id=5");
    echo "Doctor count: " . $stmt->fetchColumn() . "\n";

} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}
