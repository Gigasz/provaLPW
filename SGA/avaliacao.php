<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 09/01/2018
 * Time: 13:33
 */

//carrega o cabeçalho e menus do site
include_once 'estrutura/Template.php';

//Class
require_once 'dao/avaliacaoDAO.php';

$template = new Template();

$template->header();
$template->sidebar();
$template->navbar();

$object = new avaliacaoDAO();

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $id_curso = (isset($_POST["id_curso"]) && $_POST["id_curso"] != null) ? $_POST["id_curso"] : 1;
    $id_turma = (isset($_POST["id_turma"]) && $_POST["id_turma"] != null) ? $_POST["id_turma"] : 1;
    $id_aluno = (isset($_POST["id_aluno"]) && $_POST["id_aluno"] != null) ? $_POST["id_aluno"] : 1;
    $nota1 = (isset($_POST["nota1"]) && $_POST["nota1"] != null) ? $_POST["nota1"] : null;
    $nota2 = (isset($_POST["nota2"]) && $_POST["nota2"] != null) ? $_POST["nota2"] : null;
    $nota_final = (isset($_POST["nota_final"]) && $_POST["nota_final"] != null) ? $_POST["nota_final"] : null;

} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $id_curso = 1;
    $id_turma = 1;
    $id_aluno = 1;
    $nota1 = NULL;
    $nota2 = NULL;
    $nota_final = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    $avaliacao = new avaliacao($id, null, null, null, null, null, null);
    $resultado = $object->atualizar($avaliacao);
    $id_curso = $resultado->getIdCurso();
    $id_turma = $resultado->getIdTurma();
    $id_aluno = $resultado->getIdAluno();
    $nota1 = $resultado->getNota1();
    $nota2 = $resultado->getNota2();
    $nota_final = $resultado->getNotaFinal();
}
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $id_curso != null && $id_turma != null && $id_aluno != null) {
    $avaliacao = new avaliacao($id, $id_curso, $id_turma, $id_aluno, $nota1, $nota2, $nota_final);
    $msg = $object->salvar($avaliacao);
    $id = null;
    $id_curso = 1;
    $id_turma = 1;
    $id_aluno = 1;
    $nota1 = NULL;
    $nota2 = NULL;
    $nota_final = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $avaliacao = new avaliacao($id, null, null, null, null, null, null);
    $msg = $object->remover($avaliacao);
    $id = null;
}

?>
<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Avaliações</h4>

                        <p class='category'>Lista de cursos do sistema</p>

                    </div>
                    <div class='content table-responsive'>

                        <form action="?act=save" method="POST" name="form1">
                            Curso:
                            <select name="id_curso"><?php
                                $query = "SELECT * FROM Curso order by Nome;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->idCurso == $id_curso || $key == 0) {
                                            echo "<option value='$rs->idCurso' selected>$rs->Sigla</option>";
                                        } else {
                                            echo "<option value='$rs->idCurso'>$rs->Sigla</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            Turma:
                            <select name="id_turma"><?php
                                $query = "SELECT * FROM Turma order by Nome;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $rs) {
                                        if ($rs->idTurma == $id_turma || $key == 0) {
                                            echo "<option value='$rs->idCurso' selected>$rs->Nome</option>";
                                        } else {
                                            echo "<option value='$rs->idCurso'>$rs->Nome</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>Aluno:
                            <select name="id_curso"><?php
                                $query = "SELECT * FROM Aluno order by Nome;";
                                $statement = $pdo->prepare($query);
                                if ($statement->execute()) {
                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $key=>$rs) {
                                        if ($rs->idAluno == $id_aluno || $key == 0) {
                                            echo "<option value='$rs->idAluno' selected>$rs->Nome</option>";
                                        } else {
                                            echo "<option value='$rs->idAluno'>$rs->Nome</option>";
                                        }
                                    }
                                } else {
                                    throw new PDOException("Erro: Não foi possível executar a declaração sql");
                                }
                                ?>
                            </select>
                            <br />
                            Nota 1:
                            <input type="text" size="20" name="nota1" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota1) && ($nota1 != null || $nota1 != "")) ? $nota1 : '';
                            ?>"/>
                            Nota 2:
                            <input type="text" size="20" name="nota2" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota2) && ($nota2 != null || $nota2 != "")) ? $nota2 : '';
                            ?>"/>
                            Nota Final:
                            <input type="text" size="20" name="nota_final" value="<?php
                            // Preenche o nome no campo nome com um valor "value"
                            echo (isset($nota_final) && ($nota_final != null || $nota_final != "")) ? $nota_final : '';
                            ?>"/>
                            <input type="submit" VALUE="Cadastrar"/>
                            <hr>
                        </form>
                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        //chamada a paginação
                        $object->tabelapaginada();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$template->footer();
?>
