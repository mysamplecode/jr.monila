<?php

use Config\Central;

class JRMMakePdf implements RocketSled\Runnable {

    private $file = 'pdf.html';
    private $mlsno = '';
    private $res_prop_id = '';
    private $central;
    private $profile = 'default';

    public function __construct() {
        try {
            $this->central = Central::instance();
            $this->central->set_alias_connection($this->profile);
            //parent::__construct();
            $this->template = $this->central->load_normal($this->file);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function set_value($id, $text, $val, $a = 0) {
        if ($a == 1) {
            $this->template->setValue($id, $text . 'Not Available');
        } else {
            if (!is_null($val) && !empty($val)) {
                $this->template->setValue($id, $text . $val);
            } else {
                $this->template->setValue($id, $text . 'Not Available');
            }
        }
    }

    public function set_multiple_values($id, $text, $val1, $val2, $a = 0) {
        if ($a == 1) {
            $this->template->setValue($id, $text . 'Not Available');
        } else {
            if (!is_null($val1) && !empty($val1) && !is_null($val2) && !empty($val2)) {
                $this->template->setValue($id, $text . $val1 . ' X ' . $val2);
            } else {
                $this->template->setValue($id, $text . 'Not Available');
            }
        }
    }

    public function make_pdf_files($s) {
        try {
            try {
                $sql4img = PluSQL::from($this->profile)->img_res_prop->select("*")->where("res_prop_id = {$s->res_prop_id} AND image_path LIKE '%HR%' and primary_pic=1")->limit("0, 1")->run()->img_res_prop;
                $images = PACKAGES_DIR . "/jrmimages/" . $sql4img->image_path;
                
                if (file_exists($images) && imagecreatefromjpeg($images) !== False) {
                    $this->template->setvalue('#image@src', PACKAGES_DIR . "/jrmimages/" . $sql4img->image_path);
                } else {
                    $this->template->setvalue('#image@src', PACKAGES_DIR . Config\Constants::DEFAULT_IMAGE);
                }
            } catch (Exception $e) {
                try {
                    $sql4img = PluSQL::from($this->profile)->img_res_prop->select("*")->where("res_prop_id = {$s->res_prop_id} AND image_path LIKE '%HR%'")->limit("0, 1")->run()->img_res_prop;
                    $images = PACKAGES_DIR . "/jrmimages/" . $sql4img->image_path;
                    if (file_exists($images) && imagecreatefromjpeg($images) !== False) {
                        $this->template->setvalue('#image@src', PACKAGES_DIR . "/jrmimages/" . $sql4img->image_path);
                    } else {
                        $this->template->setvalue('#image@src', PACKAGES_DIR . Config\Constants::DEFAULT_IMAGE);
                    }
                } catch (Exception $e) {
                    $this->template->setvalue('#image@src', PACKAGES_DIR . Config\Constants::DEFAULT_IMAGE);
                }
            }
            $this->res_prop_id = $s->res_prop_id;
            $this->mlsno = $s->mls_;
            $this->template->setValue('#ADDRESS', strtoupper($s->street_box_number . ' ' . $s->street_name . ' | ' . $s->city . ', ' . $s->state . ' ' . $s->zip_code));
            $this->template->setValue('#homeinfo', number_format($s->_bedrooms) . ' Beds ' . ' | ' . number_format($s->total_baths) . ' Baths ' . ' | ' . number_format($s->sqft) . ' SQ. FT. ' . ' | ' . $s->acres . ' Acres ');
            $this->set_value('#description', '', $s->property_description);
            //$this->set_value('#UPDATED', 'Updated: ', '', 1); //pending value
            $this->set_value('#MLSNO', 'MLS# ', $s->mls_);
            $this->set_value('#PRICE', '$', number_format($s->list_price));
            //$this->set_value('#agentname', 'LISTING AGENT: ', strtoupper($s->listing_agent_name));
            //$this->set_value('#brokeroffice', 'BROKER: ', strtoupper($s->listing_office_name));
            $this->set_value('#YEARBUILT', 'YEAR BUILT: ', $s->year_built);
            $this->set_value('#ACRES', 'ACRES: ', $s->acres);
//            $this->set_value('#FOUNDATION', 'FOUNDATION: ', strtoupper($s->foundation));
            //$this->set_value('#ROOF', 'ROOF: ', strtoupper($s->roof));
            //          $this->set_value('#EXTERIOR', 'EXTERIOR: ', $s->exterior_buildings);
            $this->set_value('#FIREPLACE', 'FIREPLACE: ', $s->_fireplaces);
            $this->set_value('#ESCHOOL', 'ELEMENTARY SCHOOL: ', '', 1); //pending value
            $this->set_value('#MSCHOOL', 'MIDDLE SCHOOL: ', '', 1); //pending value
            $this->set_value('#HSCHOOL', 'HIGH SCHOOL: ', '', 1); //pending value
            $this->set_multiple_values('#UTILITY', 'UTILITY ROOM: ', $s->utility_length, $s->utility_width);
            $this->set_multiple_values('#BEDROOM4', 'BEDROOM 4: ', $s->bedroom_5_length, $s->bedroom_5_width);
            $this->set_multiple_values('#BEDROOM3', 'BEDROOM 3: ', $s->bedroom_4_length, $s->bedroom_4_width);
            $this->set_multiple_values('#BEDROOM2', 'BEDROOM 2: ', $s->bedroom_3_length, $s->bedroom_3_width);
            $this->set_multiple_values('#BEDROOM1', 'BEDROOM 1: ', $s->bedroom_2_length, $s->bedroom_2_width);
            $this->set_multiple_values('#KITCHEN', 'KITCHEN: ', $s->kitchen_length, $s->kitchen_width);
            $this->set_multiple_values('#LIVING1', 'LIVING ROOM 1: ', $s->living_1_length, $s->living_1_width);
            $this->set_multiple_values('#LIVING2', 'LIVING ROOM 2: ', $s->living_2_length, $s->living_2_width);
            $this->set_multiple_values('#LIVING3', 'LIVING ROOM 3: ', $s->living_3_length, $s->living_3_width);
            $this->set_multiple_values('#DINING', 'DINING ROOM : ', $s->formal_dining_length, $s->formal_dining_width);
            $this->set_multiple_values('#LIBRARY', 'LIBRARY: ', $s->study_length, $s->study_width);
            $this->set_multiple_values('#G_ROOM', 'GARDEN ROOM: ', '', '', 1); //pending value
            $this->set_multiple_values('#SPORCH', 'SCREENED PORCH: ', '', '', 1); //pending value
            $this->set_multiple_values('#MROOM', 'MORNING ROOM : ', '', '', 1); //pending value
        } catch (EmptySetException $e) {
            echo $e->getMessage();
        }
        return $this->template->html();
    }

    public function update_main_contents() {
        
    }

    private function create_pdf() {
        ob_start();
        echo Plusql::from($this->profile)->pdf_res_prop->select("res_prop_id");
        $tablematch = ob_get_contents();
        ob_end_clean();
        $str = "res_prop_id NOT IN( $tablematch )";
        $sql4pdf = PluSQL::from($this->profile)->res_prop->select("*")->where($str)->run()->res_prop;
        $this->pdf($sql4pdf);
    }

    public function pdf($sql4pdf, $ins = 1) {
        foreach ($sql4pdf as $s) {
            ob_start();
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetMargins(10, 10);
            $pdf->AddPage();
            $check = 0;
            $html = $this->make_pdf_files($s);
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            ob_end_clean();
            $buffer = '';
            $buffer = $pdf->Output('test.pdf', 'S');
            $file_name = $this->mlsno . ".pdf";
            $path = __DIR__ . "/../jrmpdf/" . "$file_name";
            $filsaved = file_put_contents($path, $buffer);
            if ($filsaved && $ins == 1) {
                PluSQL::into($this->profile)->pdf_res_prop(array('res_prop_id' => $this->res_prop_id, 'pdf_path' => $file_name))->insert();
            }
        }
    }

    public function run() {
        $this->create_pdf();
    }

}

?>
