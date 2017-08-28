<?php

namespace Classy\Domain;

class Student 
{
    /**
     * student id.
     *
     * @var integer
     */
    private $id;

    /**
     * student gender.
     *
     * @var string
     */
    private $gender;

    /**
     * student fistname.
     *
     * @var string
     */
    private $firstname;

    /**
     * student name.
     *
     * @var integer
     */
    private $name;

    /**
     * student birth date.
     *
     * @var date
     */
    private $birth;

    /**
     * student mom name.
     *
     * @var string
     */
    private $momName;

    /**
     * student mom name.
     *
     * @var string
     */
    private $dadName;

    /**
     * student parent tel.
     *
     * @var string
     */
    private $tel;

    /**
     * student parent adresse.
     *
     * @var string
     */
    private $adress;

    /**
     * student parent CP.
     *
     * @var int
     */
    private $cp;

    /**
     * student parent city.
     *
     * @var int
     */
    private $city;

    /**
     * student previous etab.
     *
     * @var int
     */
    private $prevEtab;

    /**
     * student PPRE.
     *
     * @var boolean
     */
    private $ppre;

    /**
     * student RASED.
     *
     * @var boolean
     */
    private $rased;

    /**
     * student PAI.
     *
     * @var boolean
     */
    private $pai;

    /**
     * student APC.
     *
     * @var boolean
     */
    private $apc;

    /**
     * student PPRE note.
     *
     * @var string
     */
    private $ppreNote;

    /**
     * student RASED note.
     *
     * @var string
     */
    private $rasedNote;

    /**
     * student PAI note.
     *
     * @var string
     */
    private $paiNote;

    /**
     * student APC note.
     *
     * @var string
     */
    private $apcNote;

    /**
     * student coop.
     *
     * @var boolean
     */
    private $coop;

    /**
     * student coll (collectif meal)
     *
     * @var boolean
     */
    private $coll;

    /**
     * student general note.
     *
     * @var string
     */
    private $note;

    /**
     * Associated class.
     *
     * @var \Classy\Domain\Classe
     */
    private $class;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setBirth($birth) {
        $this->birth = $birth;
        return $this;
    }

    public function getBirth() {
        return $this->birth;
    }

    public function setMomName($momName) {
        $this->momName = $momName;
        return $this;
    }

    public function getMomName() {
        return $this->momName;
    }

    public function setDadName($dadName) {
        $this->dadName = $dadName;
        return $this;
    }

    public function getDadName() {
        return $this->dadName;
    }

    public function setTel($tel) {
        $this->tel = $tel;
        return $this;
    }

    public function getTel() {
        return $this->tel;
    }

    public function setAdress($adress) {
        $this->adress = $adress;
        return $this;
    }

    public function getAdress() {
        return $this->adress;
    }

    public function setCP($cp) {
        $this->cp = $cp;
        return $this;
    }

    public function getCP() {
        return $this->cp;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setPrevEtab($prevEtab) {
        $this->prevEtab = $prevEtab;
        return $this;
    }

    public function getPrevEtab() {
        return $this->prevEtab;
    }

    public function setPPRE($ppre) {
        $this->ppre = $ppre;
        return $this;
    }

    public function getPPRE() {
        return $this->ppre;
    }

    public function setRASED($rased) {
        $this->rased = $rased;
        return $this;
    }

    public function getRASED() {
        return $this->rased;
    }

    public function setPAI($pai) {
        $this->pai = $pai;
        return $this;
    }

    public function getPAI() {
        return $this->pai;
    }

    public function setAPC($apc) {
        $this->apc = $apc;
        return $this;
    }

    public function getAPC() {
        return $this->apc;
    }

    public function setPPRENote($ppreNote) {
        $this->ppreNote = $ppreNote;
        return $this;
    }

    public function getPPRENote() {
        return $this->ppreNote;
    }

    public function setRASEDNote($rasedNote) {
        $this->rasedNote = $rasedNote;
        return $this;
    }

    public function getRASEDNote() {
        return $this->rasedNote;
    }

    public function setPAINote($paiNote) {
        $this->paiNote = $paiNote;
        return $this;
    }

    public function getPAINote() {
        return $this->paiNote;
    }

    public function setAPCNote($apcNote) {
        $this->apcNote = $apcNote;
        return $this;
    }

    public function getAPCNote() {
        return $this->apcNote;
    }

    public function setCoop($coop) {
        $this->coop = $coop;
        return $this;
    }

    public function getCoop() {
        return $this->coop;
    }

    public function setColl($coll) {
        $this->coll = $coll;
        return $this;
    }

    public function getColl() {
        return $this->coll;
    }

    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    public function getNote() {
        return $this->note;
    }

    public function setClass(Classe $class) {
        $this->class = $class;
        return $this;
    }
}