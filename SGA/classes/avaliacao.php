<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 20:53
 */

class avaliacao
{
    private $id;
    private $id_curso;
    private $id_turma;
    private $id_aluno;
    private $nota1;
    private $nota2;
    private $nota_final;

    /**
     * avaliacao constructor.
     * @param $id
     * @param $id_curso
     * @param $id_turma
     * @param $id_aluno
     * @param $nota1
     * @param $nota2
     * @param $nota_final
     */
    public function __construct($id, $id_curso, $id_turma, $id_aluno, $nota1, $nota2, $nota_final)
    {
        $this->id = $id;
        $this->id_curso = $id_curso;
        $this->id_turma = $id_turma;
        $this->id_aluno = $id_aluno;
        $this->nota1 = $nota1;
        $this->nota2 = $nota2;
        $this->nota_final = $nota_final;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdCurso()
    {
        return $this->id_curso;
    }

    /**
     * @param mixed $id_curso
     */
    public function setIdCurso($id_curso)
    {
        $this->id_curso = $id_curso;
    }

    /**
     * @return mixed
     */
    public function getIdTurma()
    {
        return $this->id_turma;
    }

    /**
     * @param mixed $id_turma
     */
    public function setIdTurma($id_turma)
    {
        $this->id_turma = $id_turma;
    }

    /**
     * @return mixed
     */
    public function getIdAluno()
    {
        return $this->id_aluno;
    }

    /**
     * @param mixed $id_aluno
     */
    public function setIdAluno($id_aluno)
    {
        $this->id_aluno = $id_aluno;
    }

    /**
     * @return mixed
     */
    public function getNota1()
    {
        return $this->nota1;
    }

    /**
     * @param mixed $nota1
     */
    public function setNota1($nota1)
    {
        $this->nota1 = $nota1;
    }

    /**
     * @return mixed
     */
    public function getNota2()
    {
        return $this->nota2;
    }

    /**
     * @param mixed $nota2
     */
    public function setNota2($nota2)
    {
        $this->nota2 = $nota2;
    }

    /**
     * @return mixed
     */
    public function getNotaFinal()
    {
        return $this->nota_final;
    }

    /**
     * @param mixed $nota_final
     */
    public function setNotaFinal($nota_final)
    {
        $this->nota_final = $nota_final;
    }

}