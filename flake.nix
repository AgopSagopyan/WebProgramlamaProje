{
  description = "PHP and MySQL Development Environment";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";
  };

  outputs = { self, nixpkgs }:
    let
      system = "x86_64-linux"; # or "aarch64-linux" for ARM
      pkgs = nixpkgs.legacyPackages.${system};
    in
    {
      devShells.${system}.default = pkgs.mkShell {
        buildInputs = with pkgs; [
          # PHP with common extensions
          (php83.buildEnv {
            extensions = { all, enabled }: with all; enabled ++ [ mysqli pdo_mysql opcache ];
            extraConfig = "memory_limit = 512M";
          })
          php83Packages.composer
          mariadb
        ];

        shellHook = ''
          php -S localhost:8000 &

	  git remote set-url origin git@github.com:AgopSagopyan/WebProgramlamaProje.git

          # Set up local MySQL data directory so we don't need sudo
          export MYSQL_BASE_DIR=$PWD/.nix-mysql
          export MYSQL_DATADIR=$MYSQL_BASE_DIR/data
          export MYSQL_UNIX_PORT=$MYSQL_BASE_DIR/mysql.sock
          
          if [ ! -d "$MYSQL_DATADIR" ]; then
            mysql_install_db --datadir=$MYSQL_DATADIR --auth-root-authentication-method=normal
          fi

          echo "🐘 PHP $(php -v | head -n 1) and MariaDB environment loaded."
          echo "Run 'mysqld --datadir=$MYSQL_DATADIR --socket=$MYSQL_UNIX_PORT' to start the DB."
        '';
      };
    };
}
