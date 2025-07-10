<?php
require_once '../include/auth_middleware.php';
include "../include/connect/db.php";
include "../include/connect/fun.php";

$connect = new Connect();
$db = $connect->dbConnect();
$fun = new Fun($connect->dbConnect());


$sr = 0;
$khasaraWardList = $fun->getRegisterMalmattaMappings();

$date = date('d-m-Y');
$html = <<<HTML
<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <title>रजिस्टर वाइस</title>
    <style>
        body {
            font-family: 'Noto Sans Devanagari', 'Devanagari', sans-serif;
            padding: 30px;
            line-height: 1.6;
            max-width: 80%;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        .no-border td {
            border: none;
            padding: 4px 10px;
        }

        .center {
            text-align: center;
            font-weight: bold;
        }

        .note {
            margin-top: 20px;
            font-size: 14px;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="center">
        नमुना 8<br>
        रजिस्टर वाइस
    </div>
        


    <table>
        <thead>
            <tr>
                        <th>अ.क्र.</th>
                        <th>रजिस्टर क्रमांक</th>
                        <th>मिळकत क्रमांक</th>
                        <th>मालकाचे नाव</th>
                    </tr>

        </thead>
        <tbody>
HTML;

if ($khasaraWardList && mysqli_num_rows($khasaraWardList) > 0) {
                        $i = 1;
                        $currentKhasara = '';
                        $rowspanMap = [];

                        // Step 1: Group ward entries by register_no
                        while ($row = mysqli_fetch_assoc($khasaraWardList)) {
                            $rowspanMap[$row['register_no']][] = $row;
                        }

                        // Step 2: Display grouped data
                        foreach ($rowspanMap as $register_no => $wards) {
                            $first = true;
                            foreach ($wards as $ward) {
                                // print_r($ward);
                                $html .=<<<HTML
                                 <tr>
                                HTML;
                                if ($first) {
                                    $html .= "<td rowspan='" . count($wards) . "'>$i</td>";
                                    $html .= "<td rowspan='" . count($wards) . "'>$register_no</td>";
                                    $first = false;
                                    $i++;
                                }
                                $html .= "<td>{$ward['malmatta_no']}</td><td>{$ward['owner']}</td></tr>";
                                // echo "<td>{$ward['malmatta_no']}</td><td>{$ward['owner']}</td></tr>";
                            }
                        }
                    } else {
                        $html .= <<<HTML
                       <tr><td colspan='4' class='text-center'>कोणतीही नोंद उपलब्ध नाही.</td></tr>
HTML;
                    }
$html .= <<<HTML
     
        </tbody>
    </table>

    <div class="footer">
        <div>दिनांक : {$date}</div>
        <div>सचिव/वसुली लिपिकाची सही.</div>
    </div>
    

</body>

</html>
HTML;

echo $html;
