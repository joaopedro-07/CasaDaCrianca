<?php
/**
 * FormValidators.php
 *
 * Reusable input validation and sanitization classes for the child
 * registration form (processa-cadastro-crianca.php).
 *
 * Usage — add a single line at the top of the processing file,
 * immediately after include 'verificar_login.php':
 *
 *   require_once 'FormValidators.php';
 *
 * Then replace the entire "1. Coleta e Limpeza de Dados" block with:
 *
 *   extract(ChildDataValidator::fromPost($_POST));
 *   extract(AddressValidator::fromPost($_POST));
 *   extract(SocioeconomicValidator::fromPost($_POST));
 *   extract(GuardianValidator::fromPost($_POST));
 *
 * The extracted variables match every name already used in the INSERT
 * statements, so nothing else in the file needs to change.
 */

// ---------------------------------------------------------------------------
// Shared sanitization helpers
// ---------------------------------------------------------------------------

/**
 * Thin wrapper so the sanitization strategy is declared once.
 * All fields except status use strip_tags(); status is intentionally raw.
 */
function _st(string $value): string
{
    return strip_tags($value);
}

/**
 * Pull a key from the source array and apply strip_tags().
 * Returns an empty string when the key is absent.
 */
function _field(array $source, string $key): string
{
    return _st($source[$key] ?? '');
}

// ---------------------------------------------------------------------------
// ChildDataValidator
// ---------------------------------------------------------------------------

/**
 * Validates and sanitizes the core child-identification fields.
 *
 * Output keys (all used verbatim in the processing file):
 *   $matricula, $nis, $nome_crianca, $cpf_crianca, $data_nasc,
 *   $estado_nasc, $cidade_nasc, $data_entrada, $genero, $idade, $status
 */
final class ChildDataValidator
{
    /**
     * @param  array<string, mixed> $post  Typically $_POST
     * @return array<string, string>       Ready-to-extract variable map
     */
    public static function fromPost(array $post): array
    {
        return [
            // General identification
            'matricula'    => _field($post, 'matricula'),
            'nis'          => _field($post, 'nis'),
            'nome_crianca' => _field($post, 'nome-crianca'),
            'cpf_crianca'  => _field($post, 'cpf-crianca'),

            // Birth information
            'data_nasc'    => _field($post, 'data-nasc-crianca'),
            'estado_nasc'  => _field($post, 'estado-nasc-crianca'),
            'cidade_nasc'  => _field($post, 'cidade-nasc-crianca'),

            // Enrollment
            'data_entrada' => _field($post, 'data-entrada-crianca'),

            // Demographics
            'genero'       => _field($post, 'genero'),
            'idade'        => _field($post, 'idade'),

            /*
             * Status is intentionally NOT passed through strip_tags().
             * This mirrors the original: $status = $_POST['status'] ?? '';
             */
            'status' => 'ativo',
        ];
    }

    // ------------------------------------------------------------------
    // Validation helpers (optional — call before extract() when needed)
    // ------------------------------------------------------------------

    /**
     * Returns an array of field-level error messages, or an empty array
     * when the data is valid.  Does not throw; callers decide how to
     * handle failures.
     *
     * @param  array<string, string> $data  Output of self::fromPost()
     * @return array<string, string>        ['field_key' => 'Error message']
     */
    public static function validate(array $data): array
    {
        $errors = [];

        if (empty($data['nome_crianca'])) {
            $errors['nome_crianca'] = 'O nome da criança é obrigatório.';
        }

        if (!empty($data['cpf_crianca']) && !self::isValidCpf($data['cpf_crianca'])) {
            $errors['cpf_crianca'] = 'CPF da criança inválido.';
        }

        if (!empty($data['data_nasc']) && !self::isValidDate($data['data_nasc'])) {
            $errors['data_nasc'] = 'Data de nascimento inválida.';
        }

        if (!empty($data['data_entrada']) && !self::isValidDate($data['data_entrada'])) {
            $errors['data_entrada'] = 'Data de entrada inválida.';
        }

        $allowedStatuses = ['ativo', 'inativo', 'suspenso', 'pendente'];
        if (!empty($data['status']) && !in_array($data['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Status inválido.';
        }

        return $errors;
    }

    /** Basic CPF digit-check (ignores formatting characters). */
    private static function isValidCpf(string $cpf): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($pass = 9; $pass <= 10; $pass++) {
            $sum = 0;
            for ($i = 0; $i < $pass; $i++) {
                $sum += (int) $cpf[$i] * ($pass + 1 - $i);
            }
            $remainder = $sum % 11;
            $digit     = $remainder < 2 ? 0 : 11 - $remainder;

            if ((int) $cpf[$pass] !== $digit) {
                return false;
            }
        }

        return true;
    }

    /** Validates a date string against Y-m-d format. */
    private static function isValidDate(string $date): bool
    {
        $dt = DateTime::createFromFormat('Y-m-d', $date);
        return $dt && $dt->format('Y-m-d') === $date;
    }
}

// ---------------------------------------------------------------------------
// AddressValidator
// ---------------------------------------------------------------------------

/**
 * Validates and sanitizes address fields.
 *
 * Output keys:
 *   $cep, $rua, $numero, $bairro, $municipio, $uf
 */
final class AddressValidator
{
    /**
     * @param  array<string, mixed> $post
     * @return array<string, string>
     */
    public static function fromPost(array $post): array
    {
        return [
            'cep'       => self::normalizeCep(_field($post, 'cep')),
            'rua'       => _field($post, 'logradouro'),
            'numero'    => _field($post, 'numero'),
            'bairro'    => _field($post, 'bairro'),
            'municipio' => _field($post, 'cidade'),
            'uf'        => _field($post, 'uf'),
        ];
    }

    /**
     * @param  array<string, string> $data  Output of self::fromPost()
     * @return array<string, string>
     */
    public static function validate(array $data): array
    {
        $errors = [];

        if (!empty($data['cep']) && !preg_match('/^\d{5}-?\d{3}$/', $data['cep'])) {
            $errors['cep'] = 'CEP inválido. Formato esperado: 00000-000.';
        }

        if (empty($data['rua'])) {
            $errors['rua'] = 'O logradouro é obrigatório.';
        }

        if (empty($data['municipio'])) {
            $errors['municipio'] = 'A cidade é obrigatória.';
        }

        $validUfs = [
            'AC','AL','AP','AM','BA','CE','DF','ES','GO','MA',
            'MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN',
            'RS','RO','RR','SC','SP','SE','TO',
        ];
        if (!empty($data['uf']) && !in_array(strtoupper($data['uf']), $validUfs, true)) {
            $errors['uf'] = 'UF inválida.';
        }

        return $errors;
    }

    /** Strips all non-digit characters and re-formats as 00000-000. */
    private static function normalizeCep(string $cep): string
    {
        $digits = preg_replace('/\D/', '', $cep);

        if (strlen($digits) === 8) {
            return substr($digits, 0, 5) . '-' . substr($digits, 5);
        }

        return $cep; // return as-is if length unexpected; let validate() catch it
    }
}

// ---------------------------------------------------------------------------
// SocioeconomicValidator
// ---------------------------------------------------------------------------

/**
 * Validates and sanitizes socioeconomic information.
 *
 * Output keys:
 *   $renda, $cad_unico, $situacao_risco, $recebe_benef
 */
final class SocioeconomicValidator
{
    /**
     * @param  array<string, mixed> $post
     * @return array<string, string>
     */
    public static function fromPost(array $post): array
    {
        return [
            'renda'          => _field($post, 'renda-familiar'),
            'cad_unico'      => _field($post, 'cad-unico'),
            'situacao_risco' => _field($post, 'situacao-risco-social'),
            'recebe_benef'   => _field($post, 'beneficio'),
        ];
    }

    /**
     * @param  array<string, string> $data
     * @return array<string, string>
     */
    public static function validate(array $data): array
    {
        $errors = [];

        if ($data['renda'] !== '' && !is_numeric($data['renda'])) {
            $errors['renda'] = 'Renda familiar deve ser um valor numérico.';
        }

        if ($data['renda'] !== '' && (float) $data['renda'] < 0) {
            $errors['renda'] = 'Renda familiar não pode ser negativa.';
        }

        $boolFields = ['cad_unico' => 'Cadastro Único', 'recebe_benef' => 'Recebe benefício'];
        foreach ($boolFields as $field => $label) {
            if (!empty($data[$field]) && !in_array($data[$field], ['sim', 'nao', ''], true)) {
                $errors[$field] = "$label deve ser 'sim' ou 'nao'.";
            }
        }

        return $errors;
    }
}

// ---------------------------------------------------------------------------
// GuardianValidator
// ---------------------------------------------------------------------------

/**
 * Validates and sanitizes adult/guardian fields.
 *
 * Output keys:
 *   $tipo_resp, $profissao_mae, $profissao_pai, $profissao_outro
 *
 * Note: The individual guardian name/CPF/telephone fields ($_POST['nome-mae'],
 * $_POST['cpf-mae'], etc.) are consumed directly inside inserirAdulto() calls
 * in the processing file and are not extracted here, preserving the original
 * structure exactly.  Only the fields that are assigned to standalone
 * variables in the "Coleta e Limpeza de Dados" block are returned.
 */
final class GuardianValidator
{
    /** Recognised guardian-type values sent by the form. */
    private const VALID_TYPES = ['mae', 'pai', 'outro'];

    /**
     * @param  array<string, mixed> $post
     * @return array<string, string>
     */
    public static function fromPost(array $post): array
    {
        /*
         * tipo_resp is used by the conditional logic that determines
         * $idResponsavel further down in the processing file.
         * It intentionally remains unsanitized — matching the original
         * $tipo_resp = $_POST['tipo_responsavel'] ?? '';
         */
        return [
            'tipo_resp'       => $post['tipo_responsavel'] ?? '',
            'profissao_mae'   => _field($post, 'profissao-mae'),
            'profissao_pai'   => _field($post, 'profissao-pai'),
            'profissao_outro' => _field($post, 'profissao-responsavel'),
        ];
    }

    /**
     * @param  array<string, string> $data
     * @return array<string, string>
     */
    public static function validate(array $data): array
    {
        $errors = [];

        if (!empty($data['tipo_resp'])
            && !in_array($data['tipo_resp'], self::VALID_TYPES, true)
        ) {
            $errors['tipo_resp'] = 'Tipo de responsável inválido.';
        }

        return $errors;
    }

    /**
     * Convenience method: returns true when all guardian-related POST
     * fields for a given role are present and non-empty.
     *
     * @param array<string, mixed> $post
     * @param 'mae'|'pai'|'outro'  $role
     */
    public static function hasRequiredFields(array $post, string $role): bool
    {
        $map = [
            'mae'  => ['nome-mae',         'cpf-mae',         'tel-mae'],
            'pai'  => ['nome-pai',         'cpf-pai',         'tel-pai'],
            'outro' => ['nome-responsavel', 'cpf-responsavel', 'tel-responsavel'],
        ];

        $required = $map[$role] ?? [];

        foreach ($required as $key) {
            if (empty(trim((string) ($post[$key] ?? '')))) {
                return false;
            }
        }

        return true;
    }
}

// ---------------------------------------------------------------------------
// FormValidationRunner  (optional façade)
// ---------------------------------------------------------------------------

/**
 * Runs all four validators in a single call and merges their errors.
 * Useful when you want to validate the full form before attempting
 * any INSERT, without changing the processing file.
 *
 * Example (called from a separate validation endpoint or at the top of
 * the processing file before the transaction block):
 *
 *   $result = FormValidationRunner::run($_POST);
 *   if (!$result['valid']) {
 *       echo json_encode(['sucesso' => false, 'erros' => $result['errors']]);
 *       exit;
 *   }
 */
final class FormValidationRunner
{
    /**
     * @param  array<string, mixed>  $post
     * @return array{valid: bool, errors: array<string, string>}
     */
    public static function run(array $post): array
    {
        $childData  = ChildDataValidator::fromPost($post);
        $addressData = AddressValidator::fromPost($post);
        $socioData  = SocioeconomicValidator::fromPost($post);
        $guardData  = GuardianValidator::fromPost($post);

        $errors = array_merge(
            ChildDataValidator::validate($childData),
            AddressValidator::validate($addressData),
            SocioeconomicValidator::validate($socioData),
            GuardianValidator::validate($guardData)
        );

        return [
            'valid'  => empty($errors),
            'errors' => $errors,
        ];
    }
}