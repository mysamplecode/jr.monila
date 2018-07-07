<?php

use Config\Central;

class JRMNeighborHoods extends RSBase {

    private $file = 'neighborhoods.html';

    public function __construct() {
        try {
            parent::__construct();
            $this->template = $this->central->load_normal($this->file);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function update_main_contents() {
        $this->template->setValue('#detail@href','packages/jrmhtml/detail.html');
    }

}

?>
