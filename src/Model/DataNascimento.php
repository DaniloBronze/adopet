<?php 
class DataNascimento
{
    private string $data;

    public function __construct(string $data)
    {
        $hoje = new DateTime();
        $dataNascimento = new DateTime($data);

        if ($dataNascimento > $hoje) {
            header("Location: index.php?erro=Data Inválida (futura)");
            die();
        }

        $formatacaoValida = $this->validaFormatacao($data);
        $numerosValidos = $this->validaNumeros($data);

        if ($formatacaoValida === false || $numerosValidos === false) {
            header("Location: index.php?erro=Data De Nascimento");
            die();
        }

        $this->data = $data;

        // Verificar idade mínima de 18 anos
        $diferenca = $hoje->diff($dataNascimento);

        if ($diferenca->y < 18) {
            header("Location: index.php?erro=Idade Mínima de 18 anos");
            die();
        }
    }

    private function validaFormatacao(string $data): bool
    {
        return preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $data);
    }

    private function validaNumeros(string $data): bool
    {
        $dataSeparada = explode("-", $data);

        $ano = $dataSeparada[0];
        $mes = $dataSeparada[1];
        $dia = $dataSeparada[2];

        return checkdate($mes, $dia, $ano);
    }

    public function recuperaDataCompleta(): string
    {
        return $this->data;
    }
}

?>