<?php
// src/firebase_database.php
declare(strict_types=1);

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Database;

function database(): Database
{
    static $db = null;
    
    if ($db === null) {
        $key = $_ENV['FIREBASE_CREDENTIALS'] ?? '';
        $kpath = dirname(__DIR__) . '/' . $key;
        
        if ($key === '' || !is_file($kpath)) {
            throw new RuntimeException('Невірний .env або немає service-account.json');
        }

        $factory = (new Factory)
            ->withServiceAccount($kpath)
            ->withDatabaseUri('https://test-form-lab-5-98e44-default-rtdb.firebaseio.com/'); // 

        $db = $factory->createDatabase();
    }
    
    return $db;
}
```[cite: 9]

### Як перевірити, чи все працює:
* Файл `.env` має містити правильний шлях до ключа (`FIREBASE_CREDENTIALS=secrets/service-account.json`)[cite: 8].
* Сам файл `service-account.json` повинен лежати у папці `secrets/` в корені вашого проєкту[cite: 7, 8].<?php
// src/firebase_database.php
declare(strict_types=1);

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Database;

function database(): Database
{
    static $db = null;
    
    if ($db === null) {
        $key = $_ENV['FIREBASE_CREDENTIALS'] ?? '';
        $kpath = dirname(__DIR__) . '/' . $key;
        
        if ($key === '' || !is_file($kpath)) {
            throw new RuntimeException('Невірний .env або немає service-account.json');
        }

        $factory = (new Factory)
            ->withServiceAccount($kpath)
            ->withDatabaseUri('https://test-form-lab-5-98e44-default-rtdb.firebaseio.com/'); // <-- Замініть на посилання з вашої консолі Firebase

        $db = $factory->createDatabase();
    }
    
    return $db;
}

