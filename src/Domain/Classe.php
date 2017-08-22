<?php

namespace Classy\Domain;

class Classe 
{
    /**
     * Class id.
     *
     * @var integer
     */
    private $id;

    /**
     * Class level
     *
     * @var string
     */
    private $lvl;

    /**
     * Class etablissement
     *
     * @var string
     */
    private $etab;

    

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getLvl() {
        return $this->lvl;
    }

    public function setLvl($lvl) {
        $this->lvl = $lvl;
        return $this;
    }

    public function getEtab() {
        return $this->etab;
    }

    public function setEtab($etab) {
        $this->etab = $etab;
        return $this;
    }
}