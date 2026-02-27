<html>
    <head>
       <link href="output.css" rel="stylesheet"> 
    </head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-6">

  <div class="max-w-sm w-full bg-white rounded-2xl overflow-hidden shadow-2xl transition-transform hover:scale-105 duration-300">
    
    <div class="h-32 bg-nix-blue flex items-center justify-center">
      <span class="text-white text-4xl font-bold">❄️</span>
    </div>

    <div class="p-6">
      <h2 class="text-2xl font-bold text-slate-800 font-display">NixOS + Tailwind</h2>
      <p class="mt-2 text-slate-600 leading-relaxed">
        Building with <span class="font-mono text-sm bg-slate-100 px-1 rounded">devenv</span> is the peak developer experience. Your environment is now reproducible and fast.
      </p>

      <div class="mt-6 flex gap-3">
        <button class="flex-1 bg-nix-blue text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
          Deploy
        </button>
        <button class="flex-1 border-2 border-slate-200 text-slate-500 py-2 px-4 rounded-lg font-semibold hover:border-slate-400 hover:text-slate-700 transition-all">
          Docs
        </button>
      </div>
    </div>
  </div>

</body>
<?php
$host = '127.0.0.1';
$db   = 'my_app';
$user = 'root';
$pass = ''; // Default devenv mysql has no password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "Connected to MariaDB successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
</html>
