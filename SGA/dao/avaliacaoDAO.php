<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 20:55
 */

require_once "db/conexao.php";
require_once "classes/avaliacao.php";

class avaliacaoDAO
{
    public function remover($avaliacao){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM Avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $avaliacao->getId());
            if ($statement->execute()) {
                return "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }


    //$this->id = $id;
    //$this->id_curso = $id_curso;
    //$this->id_turma = $id_turma;
    //$this->id_aluno = $id_aluno;
    //$this->nota1 = $nota1;
    //$this->nota2 = $nota2;
    //$this->nota_final = $nota_final;
//$id_curso = $resultado->getIdCurso();
//$id_turma = $resultado->getIdTurma();
//$id_aluno = $resultado->getIdAluno();
//$nota1 = $resultado->getNota1();
//$nota2 = $resultado->getNota2();
//$nota_final = $resultado->getNotaFinal();
//                idAvaliacao, Curso_idCurso, Turma_idTurma, Aluno_idAluno, Nota1, Nota2, NotaFinal
    public function salvar($avaliacao){

        global $pdo;
        try {
            if ($avaliacao->getIdCurso() != "") {
                $statement = $pdo->prepare("UPDATE avaliacao SET Curso_idCurso=:id_curso, Turma_idTurma=:id_turma, Aluno_idAluno=:id_aluno, Nota1=:nota1, Nota2=:nota2, NotaFinal=:nota_final  WHERE idCurso = :id;");
                $statement->bindValue(":id", $avaliacao->getIdcurso());
            } else {
                $statement = $pdo->prepare("INSERT INTO Avaliacao (Curso_idCurso, Turma_idTurma, Aluno_idAluno, Nota1, Nota2, NotaFinal) VALUES (:id_curso, :id_turma, :id_aluno, :nota1, :nota2, :nota_final)");
            }
            $statement->bindValue(":id_curso",$avaliacao->getIdCurso());
            $statement->bindValue(":id_turma",$avaliacao->getIdTurma());
            $statement->bindValue(":id_aluno",$avaliacao->getIdAluno());
            $statement->bindValue(":nota1",$avaliacao->getNota1());
            $statement->bindValue(":nota2",$avaliacao->getNota2());
            $statement->bindValue(":nota_final",$avaliacao->getNotaFinal());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Dados cadastrados com sucesso!";
                } else {
                    return "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($avaliacao){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT idAvaliacao, Curso_idCurso, Turma_idTurma, Aluno_idAluno, Nota1, Nota2, NotaFinal FROM avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $avaliacao->getId());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $avaliacao->setId($rs->idAvaliacao);
                $avaliacao->setIdCurso($rs->Curso_idCurso);
                $avaliacao->setIdTurma($rs->Turma_idTurma);
                $avaliacao->setIdAluno($rs->Aluno_idAluno);
                $avaliacao->setNota1($rs->Nota1);
                $avaliacao->setNota2($rs->Nota2);
                $avaliacao->setNotaFinal($rs->NotaFinal);
                return $avaliacao;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            var_dump($erro);
            return "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT idAvaliacao, Curso_idCurso, Turma_idTurma, Aluno_idAluno, Nota1, Nota2, NotaFinal FROM avaliacao LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM Curso";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

        /* Cálcula qual será a página final do nosso range */
        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        //$this->id_curso = $id_curso;
        //$this->id_turma = $id_turma;
        //$this->id_aluno = $id_aluno;
        //$this->nota1 = $nota1;
        //$this->nota2 = $nota2;
        //$this->nota_final = $nota_final;
        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>ID Avaliação</th>
        <th>ID Curso</th>
        <th>ID TURMA</th>
        <th>ID ALUNO</th>
        <th>NOTA 1</th>
        <th>NOTA 2</th>
        <th>NOTA FINAL</th>
        <th>SITUAÇÃO</th>
        <th colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach($dados as $inst):
                if (!isset($inst->NotaFinal)) {
                    $resultado = ($inst->Nota1 + $inst->Nota2) /2;
                    if ($resultado >= 7) {
                        $situacao = "Aprovado";
                    } else {
                        $situacao = "Reprovado";
                    }
                } else {
                    $resultado = ((($inst->Nota1 + $inst->Nota2) /2) + $inst->NotaFinal) /2;
                    if ($resultado >= 6) {
                        $situacao = "Aprovado";
                    } else {
                        $situacao = "Reprovado";
                    }
                }
                echo "<tr>
                    <td>$inst->idAvaliacao</td>
                    <td>$inst->Curso_idCurso</td>
                    <td>$inst->Turma_idTurma</td>
                    <td>$inst->Aluno_idAluno</td>
                    <td>$inst->Nota1</td>
                    <td>$inst->Nota2</td>
                    <td>$inst->NotaFinal</td>
                    <td>$situacao</td>
                    <td><a href='?act=upd&id=$inst->idAvaliacao'><i class='ti-reload'></i></a></td>
                    <td><a href='?act=del&id=$inst->idAvaliacao'><i class='ti-close'></i></a></td>
                   </tr>";
            endforeach;
            echo"
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i=$range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
       <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }
}