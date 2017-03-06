<?php

const BASEPATH = 'cache';
const OPTPATH = 'optimized';

$packagesjson = json_decode(file_get_contents(BASEPATH . '/packages.json'));

if (file_exists('optimize.db')) {
    unlink('optimize.db');
}

$pdo = new PDO('sqlite:optimize.db', null, null, [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS providers ('
    .'file TEXT'
    .',hash TEXT'
    .')'
);
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS packages ('
    .'provider TEXT'
    .',file TEXT'
    .',hash TEXT'
    .')'
);
$pdo->beginTransaction();

$muda = 0;
foreach ($packagesjson->{'provider-includes'} as $providerpath => $providerinfo) {
    $providerjson = json_decode(file_get_contents(BASEPATH . '/' . str_replace('%hash%', $providerinfo->sha256, $providerpath)));

    foreach ($providerjson->providers as $packagename => $packageinfo) {
        $packagejson = json_decode(file_get_contents(BASEPATH . "/p/$packagename\${$packageinfo->sha256}.json"), true);

        foreach ($packagejson['packages'] as $versionname => $info) {
            if ($versionname !== $packagename) {
                echo "unless $versionname in， $packagename Container\n";
                $muda += strlen(json_encode($info));
                unset($packagejson['packages'][$versionname]);
            }
        }

        if (empty($packagejson['packages'])) {
            echo "$packagename Not catainer package infomation of any package ,You don't need？\n";
            continue;
        }

        // make up package.json
        $packagestr = json_encode($packagejson, JSON_UNESCAPED_SLASHES);
        $packagehash = hash('sha256', $packagestr);

        // as new file 
        $path = OPTPATH . "/p/{$packagename}\${$packagehash}.json";
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($path, $packagestr);

        // update hash value from DB
        $stmt = $pdo->prepare('INSERT INTO packages (provider, file, hash) VALUES (:provider, :file, :hash)');
        $stmt->bindValue(':provider', $providerpath);
        $stmt->bindValue(':file', $packagename);
        $stmt->bindValue(':hash', $packagehash);
        $stmt->execute();
    }

    // make up provider.json
    // extract result from db
    $stmt = $pdo->prepare('SELECT file, hash FROM packages WHERE provider = :provider');
    $stmt->bindValue(':provider', $providerpath);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $newpackages = [];
    foreach ($stmt as $row) {
        $newpackages[$row['file']] = ['sha256'=>$row['hash']];
    }
    
    $providerjson = ['providers' => $newpackages];
    $providerstr = json_encode($providerjson, JSON_UNESCAPED_SLASHES);
    $providerhash = hash('sha256', $providerstr);

    // as new file 
    $path = OPTPATH . '/' . str_replace('%hash%', $providerhash, $providerpath);
    $dir = dirname($path);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($path, $providerstr);

    //update hash value from DB
    $stmt = $pdo->prepare('INSERT INTO providers (file, hash) VALUES (:file, :hash)');
    $stmt->bindValue(':file', $providerpath);
    $stmt->bindValue(':hash', $providerhash);
    $stmt->execute();
}
$pdo->commit();

// in the final make file packages.json
// extract data from database
$stmt = $pdo->query('SELECT file, hash FROM providers');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$newproviders = [];
foreach ($stmt as $row) {
    $newproviders[$row['file']] = ['sha256'=>$row['hash']];
}
$packagesjson->{'provider-includes'} = $newproviders;
$packagesstr = json_encode($packagesjson, JSON_UNESCAPED_SLASHES);

// as a new file
$path = OPTPATH . '/packages.json';
file_put_contents($path, $packagesstr);


echo "All $muda byte useless\n";
