<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 15.09.2018
 * Time: 22:33
 */
echo " KURS VALUT";
$host='localhost'; // имя хоста в рамках тестовго задания записал подключение сюда
$database='kursvalue'; // имя базы данных
$user='root'; // пользователь
$pswd=''; //  пароль

$dbh = mysqli_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
mysqli_select_db($dbh,$database) or die("Не могу подключиться к базе.");
$dbh = mysqli_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
mysqli_select_db($dbh,$database) or die("Не могу подключиться к базе.");
$sql3 = 'SELECT * from kursvalue';
//    print_r($sql3);

$res = mysqli_query($dbh,$sql3);


while($row = mysqli_fetch_array($res))
{

    echo "Дата: ".$row['day']."<br>\n";
    echo "Номинал: ".$row['value']."<br>\n";
    echo "Рублей : ".$row['kurs']."<br><hr>\n";
}