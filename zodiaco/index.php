<?php include('layouts/header.php'); ?>

<div class="container-fluid bg-zodiac" style="min-height: 50vh; margin-botton: 30px; display: flex; align-items: center; justify-content: center;">
    <div class="row justify-content-center">
        <div class="col-md-8 offset-md-2">
            <div class="card p-4">
                <h1 class="text-center mb-4 magic-title">Descubra seu Signo</h1>
                <form id="signo-form" method="POST" action="show_zodiac_sign.php">
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Descobrir Signo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('layouts/footer.php'); ?>