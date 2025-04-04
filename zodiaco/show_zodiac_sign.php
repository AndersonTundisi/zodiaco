<?php include('layouts/header.php'); ?>

<div class="container mt-5" style="background: linear-gradient(to bottom, #e0f7fa, #0288d1);">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4">
                <?php
                if (isset($_POST['data_nascimento'])) {
                    $data_nascimento = $_POST['data_nascimento'];
                    $data_nascimento_obj = DateTime::createFromFormat('Y-m-d', $data_nascimento);
                } elseif (isset($_GET['data_nascimento'])) {
                    $data_nascimento = $_GET['data_nascimento'];
                    $data_nascimento_obj = DateTime::createFromFormat('d/m/Y', $data_nascimento);
                } else {
                    echo "<p class='text-center'>Data de nascimento não fornecida.</p>";
                    exit;
                }

                if ($data_nascimento_obj === false) {
                    echo "Data de nascimento inválida.";
                    exit;
                }

                $data_nascimento_formatada = $data_nascimento_obj->format('d/m/Y');
                $data_nascimento_obj_formatado = DateTime::createFromFormat('d/m/Y', $data_nascimento_formatada);

                $signos = simplexml_load_file("signos.xml");

                if ($signos === false) {
                    echo "Erro ao carregar o arquivo XML.";
                    exit;
                }

                $signo_encontrado = false;

                foreach ($signos->signo as $signo) {
                    $dataInicio = DateTime::createFromFormat('d/m', (string) $signo->dataInicio);
                    $dataFim = DateTime::createFromFormat('d/m', (string) $signo->dataFim);

                    if ($dataInicio === false || $dataFim === false) {
                        echo "Erro ao processar datas do signo: " . $signo->signoNome . "<br>";
                        continue;
                    }

                    $ano_nascimento = $data_nascimento_obj_formatado->format('Y');

                    // Define as datas no ano de nascimento
                    $dataInicio->setDate($ano_nascimento, $dataInicio->format('m'), $dataInicio->format('d'));
                    $dataFim->setDate($ano_nascimento, $dataFim->format('m'), $dataFim->format('d'));

                    // Ajuste para signos que atravessam o ano
                    if ($dataInicio->format('m') == 12 && $dataFim->format('m') == 1) {
                        $dataFim->modify('+1 year');
                    }

                    // Verificação corrigida
                    if ($data_nascimento_obj_formatado >= $dataInicio && $data_nascimento_obj_formatado <= $dataFim) {
                        $signo_encontrado = true;
                        $signo_encontrado_data = $signo;
                        break;
                    }
                }

                if ($signo_encontrado) {
                    ?>
                    <div class="text-center">
                        <h3>Seu signo é: <?php echo htmlspecialchars($signo_encontrado_data->signoNome); ?></h3>
                        <img src="<?php echo htmlspecialchars($signo_encontrado_data->imagem); ?>" 
                             alt="<?php echo htmlspecialchars($signo_encontrado_data->signoNome); ?>" 
                             class="img-fluid rounded mb-3" style="max-height: 200px;">
                        <p><?php echo htmlspecialchars($signo_encontrado_data->descricao); ?></p>
                    </div>
                    <?php
                } else {
                    ?>
                    <p class="text-center">Signo não encontrado para a data de nascimento fornecida.</p>
                    <?php
                }
                ?>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('layouts/footer.php'); ?>
