<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
    <?php
    $host='localhost'; // имя хоста в рамках тестовго задания записал подключение сюда
    $database='kursvalue'; // имя базы данных
    $user='root'; // пользователь
    $pswd=''; //  пароль

    $dbh = mysqli_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
    mysqli_select_db($dbh,$database) or die("Не могу подключиться к базе.");

    class CBRAgent
    {
        protected $list = array();

        public function load()
        {
            $xml = new DOMDocument();
            $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');

            if (@$xml->load($url))
            {
                $this->list = array();

                $root = $xml->documentElement;
                $items = $root->getElementsByTagName('Valute');

                foreach ($items as $item)
                {
                    $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                    $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                    $this->list[$code] = floatval(str_replace(',', '.', $curs));
                }

                return true;
            }
            else
                return false;
        }

        public function get($cur)
        {
            return isset($this->list[$cur]) ? $this->list[$cur] : 0;
        }
    }
    $cbr = new CBRAgent();
    if ($cbr->load()){
        $usd_curs = $cbr->get('USD');
        $euro_curs = $cbr->get('EUR');
    }

    $sql1 = "INSERT INTO kursvalue (id,day,kurs,value) VALUES (NULL,NOW(),$usd_curs,'USD')";

    $res1 = mysqli_query($dbh,$sql1);

    $sql2 = "INSERT INTO kursvalue (id,day,kurs,value ) VALUES (NULL,NOW(),$euro_curs,'EUR')";

    $res2 = mysqli_query($dbh,$sql2);

    $sql3 = 'SELECT * from kursvalue where day = NOW()';
//    print_r($sql3);

    $res = mysqli_query($dbh,$sql3);


    while($row = mysqli_fetch_array($res))
    {

        echo "Дата: ".$row['day']."<br>\n";
        echo "Номинал: ".$row['value']."<br>\n";
        echo "Рублей : ".$row['kurs']."<br><hr>\n";
    }

    ?>
</div>

</body>
</html>