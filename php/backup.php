<?php
include('database.php');

// Usar las variables de conexión directamente del archivo incluido
$servername = $host;
$username = $username;
$password = $password;
$dbname = $dbname;

// Nombre del archivo de backup
$backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

// Ruta completa al ejecutable de mysqldump
$mysqldumpPath = 'C:\\xampp2\\mysql\\bin\\mysqldump.exe'; 

// Comando para generar el backup de la base de datos
$command = "{$mysqldumpPath} --user={$username} --password={$password} --host={$servername} {$dbname} > {$backupFile} 2>&1";

// Ejecutar el comando
$output = null;
$retval = null;
exec($command, $output, $retval);

// Verificar si el archivo se creó correctamente
if ($retval === 0) {
    echo "Backup generado con éxito: <a href='{$backupFile}' download>Descargar</a>";
} else {
    echo "Error al generar el backup. Código de salida: $retval <br>";
    echo "Detalles del error: " . implode("<br>", $output);
}
?>
