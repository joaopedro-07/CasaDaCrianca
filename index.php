<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    
    $sql = "SELECT * FROM administradores WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $cpf = preg_replace('/\D/', '', $_POST['cpf']);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_nome'] = $user['nome'];
            header("Location: php/inicio.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/login.css">
    <title>Login - Casa da Criança</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
</head>
<main class="card">

    <body class="body-login">
        <svg class="bg-deco" viewBox="0 0 1440 900" xmlns="http://www.w3.org/2000/svg" fill="none">
            <!-- Sun top-left -->
            <circle cx="110" cy="110" r="36" stroke="#d4a017" stroke-width="2.2" opacity="0.35" />
            <line x1="110" y1="58" x2="110" y2="44" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="110" y1="162" x2="110" y2="176" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="58" y1="110" x2="44" y2="110" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="162" y1="110" x2="176" y2="110" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="73" y1="73" x2="63" y2="63" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="147" y1="147" x2="157" y2="157" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="147" y1="73" x2="157" y2="63" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <line x1="73" y1="147" x2="63" y2="157" stroke="#d4a017" stroke-width="2" stroke-linecap="round" opacity="0.35" />
            <!-- Sun face -->
            <circle cx="102" cy="105" r="4" stroke="#d4a017" stroke-width="1.5" opacity="0.35" />
            <circle cx="118" cy="105" r="4" stroke="#d4a017" stroke-width="1.5" opacity="0.35" />
            <path d="M101 118 q9 7 18 0" stroke="#d4a017" stroke-width="1.8" stroke-linecap="round" opacity="0.35" />

            <!-- Cloud top-left area -->
            <path d="M230 180 q6-20 22-18 q4-18 22-14 q18-4 20 14 q12 0 12 12 q0 10-12 10 H238 q-14 0-14-12 q0-10 6-12z" stroke="#d4a017" stroke-width="1.8" opacity="0.28" />
            <!-- Cloud top-right -->
            <path d="M1160 120 q6-20 22-18 q4-18 22-14 q18-4 20 14 q12 0 12 12 q0 10-12 10 H1168 q-14 0-14-12 q0-10 6-12z" stroke="#d4a017" stroke-width="1.8" opacity="0.28" />

            <!-- Stars left -->
            <path d="M60 340 l5 14 14 0 -11 9 4 14 -12-8 -12 8 4-14 -11-9 14 0z" stroke="#d4a017" stroke-width="1.6" opacity="0.28" />
            <path d="M340 260 l4 10 10 0 -8 7 3 10 -9-6 -9 6 3-10 -8-7 10 0z" stroke="#d4a017" stroke-width="1.5" opacity="0.22" />

            <!-- Stars right -->
            <path d="M1380 310 l5 14 14 0 -11 9 4 14 -12-8 -12 8 4-14 -11-9 14 0z" stroke="#9b7fcc" stroke-width="1.6" opacity="0.3" />
            <path d="M1100 480 l4 10 10 0 -8 7 3 10 -9-6 -9 6 3-10 -8-7 10 0z" stroke="#9b7fcc" stroke-width="1.5" opacity="0.25" />

            <!-- House bottom-left -->
            <polygon points="60,720 190,720 190,620 125,565 60,620" stroke="#d4a017" stroke-width="2" opacity="0.28" />
            <line x1="125" y1="565" x2="125" y2="540" stroke="#d4a017" stroke-width="2" opacity="0.28" /><!-- chimney top -->
            <rect x="108" y="540" width="18" height="26" stroke="#d4a017" stroke-width="1.8" opacity="0.28" />
            <!-- Door -->
            <rect x="106" y="665" width="38" height="55" rx="19" stroke="#d4a017" stroke-width="1.8" opacity="0.28" />
            <!-- Windows -->
            <rect x="72" y="648" width="24" height="24" rx="4" stroke="#d4a017" stroke-width="1.6" opacity="0.24" />
            <rect x="154" y="648" width="24" height="24" rx="4" stroke="#d4a017" stroke-width="1.6" opacity="0.24" />
            <!-- Ground grass blades -->
            <path d="M40 720 q4-12 8 0" stroke="#d4a017" stroke-width="1.5" opacity="0.22" />
            <path d="M210 720 q4-12 8 0" stroke="#d4a017" stroke-width="1.5" opacity="0.22" />
            <path d="M225 718 q3-9 6 0" stroke="#d4a017" stroke-width="1.5" opacity="0.22" />
            <!-- Small cloud near house -->
            <path d="M200 740 q4-14 15-12 q2-12 15-10 q12-2 13 10 q8 0 8 8 q0 7-8 7 H207 q-10 0-10-8 q0-7 3-9z" stroke="#d4a017" stroke-width="1.6" opacity="0.22" />

            <!-- Paper plane top-right -->
            <path d="M1240 230 L1340 180 L1260 270 Z" stroke="#d4a017" stroke-width="1.8" opacity="0.30" />
            <path d="M1260 270 L1280 240" stroke="#d4a017" stroke-width="1.8" opacity="0.30" />
            <!-- Dashed trail -->
            <path d="M1340 180 Q1370 160 1400 175" stroke="#d4a017" stroke-width="1.5" stroke-dasharray="5 5" opacity="0.22" />

            <!-- Rainbow bottom-right -->
            <path d="M1240 820 q90-200 200 0" stroke="#f8a0a0" stroke-width="3" fill="none" opacity="0.30" />
            <path d="M1257 820 q82-180 186 0" stroke="#f8c060" stroke-width="3" fill="none" opacity="0.30" />
            <path d="M1274 820 q74-160 172 0" stroke="#a0d0f0" stroke-width="3" fill="none" opacity="0.30" />

            <!-- Heart bottom-right -->
            <path d="M1380 740 q0-10 8-10 q8 0 8 10 q0 10-8 18 q-8-8-8-18z M1388 730 q0-10 8-10 q8 0 8 10" stroke="#9b7fcc" stroke-width="1.8" fill="none" opacity="0.30" />
            <path d="M1378 738 q-2-12 10-14 q12-2 12 10 q0 14-12 22 q-12-8-10-18z" stroke="#9b7fcc" stroke-width="1.8" fill="none" opacity="0.30" />
        </svg>
        <div class="login-container">
            <form method="POST">
            <header class="card-header">
                <img src="img/logoCasaDaCrianca.png" alt="Logo Casa da Criança" width="200" height="180">
            </header>
            <h1 class="card-title">Entrar na sua conta</h1>
            <p class="card-subtitle">Acesse sua conta para continuar</p>

            <div class="field-group">
                <div class="field">
                    <label for="cpf">CPF</label>
                    <div class="input-wrapper">
                        <!-- Person icon -->
                        <svg class="icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                        <input type="text" id="cpf" name="cpf" placeholder="Insira seu CPF" inputmode="numeric" maxlength="14" autocomplete="off" />
                    </div>
                </div>

                <div class="field">
                    <label for="senha">Senha</label>
                    <div class="input-wrapper">
                        <!-- Lock icon -->
                        <svg class="icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                        <input type="password" id="senha" name="senha" placeholder="Insira sua senha" autocomplete="current-password" />
                        <button class="btn-toggle-pw" type="button" aria-label="Mostrar senha" onclick="toggleSenha(this)">
                            <!-- Eye icon -->
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <a class="forgot-link" href="php/recuperar_email.php" tabindex="0">Esqueceu a senha?</a>

            <button class="btn-submit" type="submit">Entrar</button>

            <p class="security-note">
                <!-- Shield icon -->
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2 L20 6 V12 C20 17 12 22 12 22 C12 22 4 17 4 12 V6 Z" />
                    <polyline points="9 12 11 14 15 10" />
                </svg>
                Seus dados estão protegidos
            </p>
            </form>
        </div>
</main>
<script src="js/login.js" defer></script>
</body>

</html>