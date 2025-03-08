<?php 

require_once('DBConfig.php');
require_once('DBQueries.php');


//Общие функции работы с БД
function db_get_connection() {
    mysqli_report(MYSQLI_REPORT_OFF);
    $connection = mysqli_connect(DB_CONFIG['hostname'],DB_CONFIG['login'],DB_CONFIG['password'],DB_CONFIG['database']);
    if($connection){
        return $connection;
    }
    
    echo "Ошибка подключения к БД: " .mysqli_connect_error();
    return false;
}

function db_close_connection(mysqli $connection){
    if ($connection)
        mysqli_close($connection);
}

function db_query_execute(mysqli $connection, $query) {

    if(!$connection){
        return [];
    };

    //Подготовить запрос 
    $stmt = mysqli_prepare($connection,$query);
    if(!$stmt){
        echo "Ошибка выполнения запроса к БД: ". mysqli_error($connection);
        return [];
    } 
    //подставить параметры
    //по не актуально

    //Выполнить запрос
    $executeResult = mysqli_stmt_execute($stmt);
    if(!$executeResult){
        echo "Ошибка выполнения запроса к БД: ". mysqli_stmt_error($stmt);
        return [];
    }  
    //Вернуть результат 
    $result = mysqli_stmt_get_result($stmt);
    if(!$result){
        echo "Ошибка выполнения запроса к БД: ". mysqli_stmt_error($stmt);
        return [];
    } 
    //извлечь результат в массив
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    return $rows;

}


//Прикладные функции получения данных
function db_get_category_list(mysqli $connection): array{
    
    $query = DB_QUERIES['getCategoryList'];
    
    return db_query_execute($connection,$query);

}

function db_get_item_list(mysqli $connection): array{
    
    $query = DB_QUERIES['getItemList'];
    
    return db_query_execute($connection,$query);

}

?>