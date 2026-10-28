<?php

function dump($var)
{
    echo '<pre>' . print_r($var, 1) . '</pre>';
}

function contardisponibles(PDO $pdo): int
{
 return 1;
}
function obtenerLibro(PDO $pdo, int $id): array|false
{

}
function getPersistentData($dataSource, $origin)
{

    switch ($origin) {
        case 'db':
            return _getDBData($dataSource);
            break;
        case 'file':
            return _getCSVData($dataSource);
        default:
            return null;
    }
}
function _getDBData($dbConnectionParameters)
{
    $data = [];
    $dbh =  new PDO(
        $dbConnectionParameters['dsn'],
        $dbConnectionParameters['username'],
        $dbConnectionParameters['password'],
    );

    $sth = $dbh->prepare('SELECT * FROM reserva');
    $sth->execute();
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $row['material'] = $row['material'] ?? '';
        $data[] = $row;
    }
    return $data;
}
function _getCSVData($path)
{
    $data = [];
    if (($filehandler = fopen($path, "r")) !== false) {
        $cabeceras = fgetcsv($filehandler);

        while (($fields = fgetcsv($filehandler)) !== false) {
            $data[] = array_combine($cabeceras, $fields);
        }

        fclose($filehandler);
        return $data;
    }
    return null;
}
?>