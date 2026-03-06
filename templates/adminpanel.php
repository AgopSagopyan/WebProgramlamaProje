<!DOCTYPE html>
<html>
    <head>
        <link href="./output.css" rel="stylesheet">
    </head>
    <body>
            <form action="adminpanel.php" method="POST" enctype="multipart/form-data">

            <div class="grid grid-cols-1 gap-y-3 p-10">
                <label  for="user_text">Enter something:</label>
                <input class="bg-white border border-gray-300 rounded px-3 py-2 bg-white border-white mb-5" type="text" name="movieName" id="movieName" required>
                <input class="bg-white border border-gray-300 rounded px-3 py-2 bg-white border-white" type="text" name="movieGenre" id="movieGenre" required>
                <button class="bg-white border border-gray-300 rounded px-3 py-2 bg-white border-white" type="submit">Push to Database</button>
                <br>
                <br>
                <input type="file" name="movie_cover" accept="image/*" id="movie_cover">
        </div>
            </form>

<?php


    require "database.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['movieName'];
        $genre = $_POST['movieGenre'];
        $sql = "INSERT INTO Film (movieName, movieGenre) VALUES (:m_name, :m_genre);";

        $stmt = $pdo->prepare($sql);
        #$stmt->execute([
        #    ':m_name' => $name,
        #    ':m_genre' => $genre
        #]);
        #
        $uploadDir = "../uploads/";
        $fileName = basename($_FILES['movie_cover']['name']);
        $targetPath = $uploadDir . $fileName;

        if(move_uploaded_file($_FILES['movie_cover']['tmp_name'], $targetPath)) {
            $sql = "INSERT INTO movies (movie_name, movie_cover) VALUES (:movie_name , :path)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['path' => $targetPath, 'movie_name' => $name ]);
        }

    }


    try {
    
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['my_data'])) {
            $userInput = $_POST['my_data'];

            $sql = "INSERT INTO Film (content) VALUES (:content)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute(['content' => $userInput]);


            echo "Success";
        }

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>

    </body>
</html>
