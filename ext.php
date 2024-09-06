<?php
// Função para extrair o arquivo zip
function extract_zip_file($zip_file, $extract_to) {
    $zip = new ZipArchive;
    if ($zip->open($zip_file) === true) {
        // Cria o diretório de destino se não existir
        if (!file_exists($extract_to)) {
            mkdir($extract_to, 0777, true);
        }
        if (!$zip->extractTo($extract_to)) {
            return "Falha ao extrair o arquivo zip. A extração para {$extract_to} falhou.";
        }
        $zip->close();
        return "Arquivo zip extraído com sucesso para {$extract_to}.";
    } else {
        return "Falha ao abrir o arquivo zip. Pode estar corrompido ou não ser um arquivo zip.";
    }
}

// Caminho do diretório atual
$current_dir = dirname(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Descompactar Arquivo Zip</title>
    <meta name="robots" content="noindex">
    <style type="text/css">
        body { font-family: Arial, sans-serif; font-size: 14px; padding: 0; margin: 0; text-align: left; padding-bottom: 50px; }
        .container { width: 600px; margin: 100px auto 0 auto; max-width: 100%; }
        h3 { text-align: center; }
        label { font-weight: bold; margin: 10px 0; }
        input[type="text"], input[type="file"] { border: 1px solid #eee; padding: 10px; display: block; margin: 10px auto; width: 100%; }
        input[type="submit"] { padding: 10px 20px; display: block; margin: 20px auto; border: 2px solid green; background: #fff; width: 100%; font-weight: bold; }
        .copyright { position: fixed; bottom: 0; background: #333; color: #fff; width: 100%; padding: 10px 20px; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h3>Descompactar Arquivo Zip</h3>

    <?php
    if (isset($_POST['extract_zip'])) {
        $zip_file = $_FILES['zip_file']['tmp_name'];
        $extract_to = $_POST['extract_to'];
        
        // Define o caminho de extração para o diretório atual se não fornecido
        if (empty($extract_to)) {
            $extract_to = $current_dir;
        }
        
        if (!empty($zip_file) && !empty($extract_to)) {
            $result = extract_zip_file($zip_file, $extract_to);
            echo "<p style='text-align: center;'>$result</p>";
        } else {
            echo '<p style="text-align: center;">Por favor, forneça um arquivo zip e um caminho de extração.</p>';
        }
    }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="zip-file">Selecione o Arquivo Zip para Descompactar</label>
        <input type="file" id="zip-file" name="zip_file" accept=".zip" />
        <label for="extract-to">Caminho de Extração (deixe em branco para o diretório atual)</label>
        <input type="text" id="extract-to" name="extract_to" placeholder="Caminho para extrair os arquivos" value="<?php echo htmlspecialchars($current_dir); ?>" />
        <input type="submit" name="extract_zip" value="Descompactar Arquivo Zip" />
    </form>

    <br />
</div>

<div class="copyright">Copyright &copy; <?php echo date("Y"); ?>. Todos os direitos reservados.</div>
</body>
</html>
