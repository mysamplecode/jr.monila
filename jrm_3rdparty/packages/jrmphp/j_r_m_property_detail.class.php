<?php

use Config\Central;
use Config\Constants;

class JRMPropertyDetail extends RSBase {

    private $file = 'property_detail.html';

    public function __construct() {
        try {
            parent::__construct();
            $this->template = $this->central->load_normal($this->file);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function get_db_data($q) {

        try {
            $res_prop_id = $q;

            try {
                $sql = PluSQL::from($this->profile)->res_prop->select("*")->where("res_prop_id= '$res_prop_id'")->run()->res_prop;
                $sql_pdf = PluSQL::from($this->profile)->pdf_res_prop->select("*")->where("res_prop_id= '$res_prop_id'")->run()->pdf_res_prop;
                $pdffile = 'packages/jrmpdf/' . $sql_pdf->pdf_path;
                if (file_exists($pdffile)) {
                    $this->pdf->pdf($sql, 0);
                    $this->template->setValue('#downpdf@href', $pdffile);
                } else {
                    $this->pdf->pdf($sql, 0);
                    $this->template->setValue('#downpdf@href', $pdffile);
                }
            } catch (EmptySetException $e) {
                try {
                    $pdffile = 'packages/jrmpdf/' . $sql->mls_ . '.pdf';
                    $this->pdf->pdf($sql);
                    $this->template->setValue('#downpdf@href', $pdffile);
                } catch (EmptySetException $e) {
                    
                }
            }
            try {
                $sql = PluSQL::from($this->profile)->res_prop->select("*")->where("res_prop_id= '$res_prop_id'")->orderby("res_prop_id ASC")->run()->res_prop;
                foreach ($sql as $s) {
                    $this->template->setValue('#address1', $s->street_box_number . ' ' . $s->street_name);
                    $this->template->setValue('#address2', $s->city . ', ' . $s->state . ' ' . $s->zip_code);
                    if (!is_null($s->list_price) || !empty($s->list_price)) {
                        $this->template->setValue('#listprice', '$' . number_format($s->list_price));
                    } else {
                        $this->template->setValue('#listprice', '');
                    }
                    if (!is_null($s->_bedrooms) || !empty($s->_bedrooms) || !is_null($s->_full_baths) || !empty($s->_full_baths) || !is_null($s->sqft) || !empty($s->sqft) || !is_null($s->acres) || !empty($s->acres)) {
                        if (!is_null($s->_bedrooms) || !empty($s->_bedrooms)) {
                            $this->template->setValue('#beds1', $s->_bedrooms . ' Bed');
                        } else {
                            $this->template->setValue('#beds1', '');
                        }
                        if (!is_null($s->_full_baths) || !empty($s->_full_baths)) {
                            $this->template->setValue('#baths1', $s->_full_baths . ' Bath');
                        } else {
                            $this->template->setValue('#baths1', '');
                        }
                        if (!is_null($s->sqft) || !empty($s->sqft)) {
                            $this->template->setValue('#sqft', number_format($s->sqft) . ' Square Feet');
                        } else {
                            $this->template->setValue('#sqft', '');
                        }
                        if (!is_null($s->acres) || !empty($s->acres)) {
                            $this->template->setValue('#acres', number_format($s->acres, 2) . ' Acres');
                        } else {
                            $this->template->setValue('#acres', '');
                        }
                    } else {
                        $this->template->setValue('#houseinfo', '');
                    }
                    $this->template->setValue('#mlsno', 'MLS# ' . $s->mls_);
                    if (!is_null($s->property_description) || !empty($s->property_description)) {
                        $this->template->setValue('#description', ucfirst(strtolower($s->property_description)));
                    } else {
                        $this->template->setValue('#description', 'No Description Available.');
                    }
                    if (!is_null($s->listing_agent_name) || !empty($s->listing_agent_name) || !is_null($s->listing_office_name) || !empty($s->listing_office_name)) {
                        $this->template->setValue('#agentname', 'Listing Agent: ' . ucwords(strtolower($s->listing_agent_name)));
                    } else {
                        $this->template->setValue('#agentname', '');
                    }
                    if (!is_null($s->listing_office_name) || !empty($s->listing_office_name)) {
                        $this->template->setValue('#brokeroffice', 'Broker: ' . ucwords(strtolower($s->listing_office_name)));
                    } else {
                        $this->template->setValue('#brokeroffice', '');
                    }
                    if ($s->photo_count > 0) {
                        $imageli = $this->template->repeat('#image_li');
                        $imagelii = $this->template->repeat('#image_all');
                        try {
                            $sql_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path LIKE ('HR%')")->orderby("res_prop_id")->run()->img_res_prop;
                            foreach ($sql_image as $si) {
                                $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s -> uid, -2)."/".$si->image_path;
                                $imageli->setValue('#res_image@src', $imagepath);
                                $imagelii->setValue('#res_image_all@src', $imagepath);
                                $imageli->next();
                                $imagelii->next();
                            }
                            Central::remove_last_repeating_element($this->template, '#last_image', 1, 2, 0);
                            Central::remove_last_repeating_element($this->template, '#last_image_all', 1, 2, 0);
                        } catch (Exception $e) {

                            $this->template->setValue('#res_image@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
                            $this->template->setValue('#res_image_all@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
                        }
                    } else {
                        $this->template->setValue('#res_image@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
                        $this->template->setValue('#res_image_all@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
                    }
                }
            } catch (Exception $e) {
                //echo $e->getMessage();
                $this->template->setValue('#res_image@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
                $this->template->setValue('#res_image_all@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            $this->template->setValue('#res_image@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
            $this->template->setValue('#res_image_all@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//throw $e;
        }
    }

    public function update_main_contents() {

        $this->template->remove('.static');
        $this->close_open_box('openhouse_val');
        $this->close_open_box('photos_count_val');
        $this->close_open_box('parking_val');
        $this->update_checkbox($this->template, 'property_status_val', 'status', 'status_repeat', 'last_flag1', 'active_status', 'lactive_status', '', '', 'totalselectedstatus');
        //property type
        $this->set_city();
        $this->update_checkbox($this->template, 'proptypes_val', 'property_type', 'repeat_checkbox', 'last_flag2', 'inputname_checkbox', 'lname_checkbox', '', 'RES-', 'totalselectedprops');
        $this->set_sliders();

        if (isset($_REQUEST['q']) && $_REQUEST['q'] != "") {
            $q = $this->esc($_REQUEST['q']);
            $this->get_db_data($q);
        } else {
            @header("Location: ?r=JRMIndex");
        }
    }

}

?>
