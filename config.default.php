<?php
/**
 * Copy the file to config.php, don't modify current file!
 */

return (object)array(
    'cachedir' => __DIR__ . '/cache/',
    //'cachedir' => '/usr/share/nginx/html/',
    //'cachedir' => '/usr/local/apache2/htdocs/',
    'packagistUrl' => 'https://packagist.org',
    'lockfile' => __DIR__ . '/cache/.lock',
    'expiredDb' => __DIR__ . '/cache/.expired.db',
    'maxConnections' => 2,
    'generateGz' => true,
    'expireMinutes' => 24 * 60,
    'url' => 'http://localhost',
    'cfemail' => null,
    'cfkey' => null,
    'zoneid' => null,
);
