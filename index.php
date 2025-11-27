<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Web</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .calculator-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }

        .operations {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .operation-btn {
            padding: 12px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
        }

        .operation-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .operation-btn.selected {
            background: #667eea;
            color: white;
        }

        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }

        .result h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .result-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin-top: 10px;
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #c33;
        }
    </style>
</head>
<body>
    <div class="calculator-container">
        <h1>🧮 Kalkulator Web</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="angka1">Angka Pertama:</label>
                <input type="number" 
                       id="angka1" 
                       name="angka1" 
                       step="any" 
                       value="<?php echo isset($_POST['angka1']) ? htmlspecialchars($_POST['angka1']) : ''; ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="operasi">Pilih Operasi:</label>
                <select id="operasi" name="operasi" required>
                    <option value="">-- Pilih Operasi --</option>
                    <option value="tambah" <?php echo (isset($_POST['operasi']) && $_POST['operasi'] == 'tambah') ? 'selected' : ''; ?>>+ (Tambah)</option>
                    <option value="kurang" <?php echo (isset($_POST['operasi']) && $_POST['operasi'] == 'kurang') ? 'selected' : ''; ?>>- (Kurang)</option>
                    <option value="kali" <?php echo (isset($_POST['operasi']) && $_POST['operasi'] == 'kali') ? 'selected' : ''; ?>>× (Kali)</option>
                    <option value="bagi" <?php echo (isset($_POST['operasi']) && $_POST['operasi'] == 'bagi') ? 'selected' : ''; ?>>÷ (Bagi)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="angka2">Angka Kedua:</label>
                <input type="number" 
                       id="angka2" 
                       name="angka2" 
                       step="any" 
                       value="<?php echo isset($_POST['angka2']) ? htmlspecialchars($_POST['angka2']) : ''; ?>" 
                       required>
            </div>

            <button type="submit" name="hitung">Hitung</button>
        </form>

        <?php
        if (isset($_POST['hitung'])) {
            $angka1 = isset($_POST['angka1']) ? floatval($_POST['angka1']) : 0;
            $angka2 = isset($_POST['angka2']) ? floatval($_POST['angka2']) : 0;
            $operasi = isset($_POST['operasi']) ? $_POST['operasi'] : '';
            $hasil = null;
            $error = null;

            if ($operasi == '') {
                $error = "Silakan pilih operasi terlebih dahulu!";
            } else {
                switch ($operasi) {
                    case 'tambah':
                        $hasil = $angka1 + $angka2;
                        $simbol = '+';
                        break;
                    case 'kurang':
                        $hasil = $angka1 - $angka2;
                        $simbol = '-';
                        break;
                    case 'kali':
                        $hasil = $angka1 * $angka2;
                        $simbol = '×';
                        break;
                    case 'bagi':
                        if ($angka2 == 0) {
                            $error = "Tidak dapat membagi dengan nol!";
                        } else {
                            $hasil = $angka1 / $angka2;
                            $simbol = '÷';
                        }
                        break;
                    default:
                        $error = "Operasi tidak valid!";
                }
            }

            if ($error) {
                echo '<div class="error">' . htmlspecialchars($error) . '</div>';
            } elseif ($hasil !== null) {
                echo '<div class="result">';
                echo '<h2>Hasil:</h2>';
                echo '<div class="result-value">';
                echo htmlspecialchars($angka1) . ' ' . $simbol . ' ' . htmlspecialchars($angka2) . ' = ' . number_format($hasil, 2);
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>

