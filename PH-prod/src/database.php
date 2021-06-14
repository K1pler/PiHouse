<?php
/*Conexion con la base de datos montada en docker. Se le pasa el nombre del contenedor. 
Utilizamos PDO en vez de mysqli para conectar con la base de datos*/
class Database{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = 'mysql'; //Nombre del conenedor mysql.
        $this->db = 'cuentas'; //Base de datos donde se encuentran las cuentas.
        $this->user = 'root';
        $this->password = 'root';
        $this->charset = 'utf8';
    }

    function connect(){ //Construccion de la conexion de la base de datos.
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $pdo = new PDO($connection, $this->user, $this->password, $options);
    
            return $pdo;
        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }

}

?>