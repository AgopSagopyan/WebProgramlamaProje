{ pkgs, lib, config, inputs, ... }:

{
  # https://devenv.sh/basics/
  env.GREET = "devenv";

  # https://devenv.sh/packages/
  packages = [ 
    pkgs.git 
    pkgs.tailwindcss
  ];

  # https://devenv.sh/languages/
  # languages.rust.enable = true;

  # https://devenv.sh/processes/
  # processes.dev.exec = "${lib.getExe pkgs.watchexec} -n -- ls -la";

  # https://devenv.sh/services/
  # services.postgres.enable = true;

  # https://devenv.sh/scripts/
  scripts.hello.exec = ''
    echo hello from $GREET
  '';

  # https://devenv.sh/basics/
  enterShell = ''
    hello         # Run scripts directly
    git --version # Use packages

    # 1. Ensure our custom db folder exists
    mkdir -p "$DEVENV_ROOT/db/mysql"

    # 2. If the default devenv mysql dir doesn't exist yet, link it to our /db
    # This redirects the service to your project folder
    if [ ! -L "$DEVENV_STATE/mysql" ]; then
      ln -s "$DEVENV_ROOT/db/mysql" "$DEVENV_STATE/mysql"
      echo "🔗 Linked MySQL data to ./db/mysql"
    fi

  '';

  # https://devenv.sh/tasks/
  # tasks = {
  #   "myproj:setup".exec = "mytool build";
  #   "devenv:enterShell".after = [ "myproj:setup" ];
  # };

  # https://devenv.sh/tests/
  enterTest = ''
    echo "Running tests"
    git --version | grep --color=auto "${pkgs.git.version}"
  '';

  # https://devenv.sh/git-hooks/
  # git-hooks.hooks.shellcheck.enable = true;

  # See full reference at https://devenv.sh/reference/options/

  languages.php = {
    enable = true;
  };

  languages.javascript = {
    enable = true;
    npm.enable = true;
  };


  processes.php-server.exec = "php -S localhost:8000";

  processes.tailwind.exec = "npx @tailwindcss/cli -i ./src/input.css -o ./src/output.css --watch";

  services.mysql = {
    enable = true;
        

    package = pkgs.mariadb;
    initialDatabases = [{ name = "denemeDB"; }];

    ensureUsers = [
      {
        name = "keremcem";
        password = "kerem4567";
        ensurePermissions = {
          "denemeDB.*" = "ALL PRIVILEGES";
        };
      }
      {
        name = "backup";
        ensurePermissions = {
          "*.*" = "SELECT, LOCK TABLES";
        };
      }
    ]
    ;
  };
}
