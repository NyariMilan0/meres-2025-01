<?php

$api_url = 'https://infojegyzet.hu/apiminta/nevnapok/';

if (isset($_GET['nap']) || isset($_GET['nev'])) {

    $query_string = '';

    if (isset($_GET['nap'])) {
        $query_string = '?nap=' . urlencode($_GET['nap']);
    }
    elseif (isset($_GET['nev'])) {
        $query_string = '?nev=' . urlencode($_GET['nev']);
    }

    $url = $api_url . $query_string;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  


    $response = curl_exec($ch);


    if (curl_errno($ch)) {
        $error_message = "cURL hiba: " . curl_error($ch); 
        curl_close($ch);
    } else {
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status !== 200) {
            $error_message = "Hiba történt! HTTP Status Code: $http_status"; 
        } else {
            $data = json_decode($response, true);

        
            if (isset($data['hiba'])) {
                $error_message = "API válasz hiba: " . $data['hiba'];
            } else {
                $results = $data;  
            }
        }
        curl_close($ch);
    }

} else {
    $error_message = "Kérjük, adjon meg egy 'nap' vagy 'nev' paramétert!";
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Névnap Kereső</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .results {
            margin-top: 20px;
            background-color: #e8f8e8;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Névnapkereső</h1>
        <div>
            <button onclick="showSearchType('nap')">Dátum keresése</button>
            <br><br>
            <button onclick="showSearchType('nev')">Név keresése</button>
            <br><br>
        </div>

        <form method="get">
            <div id="nap_input" style="display:none;">
                <input type="text" name="nap" placeholder="Keresés egy dátumra (pl.: 03-25)"
                    value="<?= isset($_GET['nap']) ? $_GET['nap'] : '' ?>">
            </div>
            <div id="nev_input" style="display:none;">
                <input type="text" name="nev" placeholder="Keresés egy névre (pl.: Katalin)"
                    value="<?= isset($_GET['nev']) ? $_GET['nev'] : '' ?>">
            </div>
            <button type="submit">Keresés</button>
        </form>

        <?php if (isset($results) && !empty($results)): ?>
        <div class="results">
            <h3>Találatok:</h3>
            <?php 
                if (isset($results['nevnap'])):
                    $nevnap = $results['nevnap'];
                    if (isset($nevnap[0])) {
                        foreach ($nevnap as $item):
                            ?>
            <p><strong><?= htmlspecialchars($item['datum']) ?></strong>: <?= htmlspecialchars($item['nevnap1']) ?>,
                <?= htmlspecialchars($item['nevnap2']) ?></p>
            <?php
                        endforeach;
                    } else {
                        ?>
            <p><strong><?= htmlspecialchars($nevnap['datum']) ?></strong>: <?= htmlspecialchars($nevnap['nevnap1']) ?>,
                <?= htmlspecialchars($nevnap['nevnap2']) ?></p>
            <?php
                    }
                endif;
            ?>
        </div>
        <?php elseif (isset($error_message)): ?>
        <div class="error"><?= $error_message; ?></div>
        <?php endif; ?>
    </div>

    <script>
        function showSearchType(type) {
            if (type === 'nap') {
                document.getElementById('nap_input').style.display = 'block';
                document.getElementById('nev_input').style.display = 'none';
            } else if (type === 'nev') {
                document.getElementById('nev_input').style.display = 'block';
                document.getElementById('nap_input').style.display = 'none';
            }
        }
    </script>

</body>

</html>