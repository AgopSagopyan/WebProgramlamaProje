
<?php

$dsn = "mysql:host=127.0.0.1;dbname=my_new_db;port=3306";
$username = "root";
$password = "";

$pdo = new PDO($dsn, $username, $password);

$name = "Kerme";
$email = "kerem@gmail.com";

$sql = "CREATE TABLE IF NOT EXISTS users (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(100),
          email VARCHAR(100)
	)";

$pdo->exec($sql);

echo "Table created";

$sql = "INSERT INTO users (name, email) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);

if($stmt->execute([$name, $email])) {
  echo "Successful";
} else {
  echo "Something went bad";
}

// 1. Run the SELECT query
    $stmt = $pdo->query("SELECT id, name, email FROM users");
    
    // 2. Start the HTML table
    echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
    echo "<thead>
            <tr style='background-color: #f2f2f2;'>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Joined At</th>
            </tr>
          </thead>";
    echo "<tbody>";

    // 3. Loop through each row in the database
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";

?>
