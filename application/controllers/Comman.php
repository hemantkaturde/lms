<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    require APPPATH . '/libraries/BaseController.php';

    class Comman extends BaseController
    {
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('comman_model');
            $this->load->model('database');
            $this->datas();
            // isLoggedIn / Login control function /  This function used login control
            $isLoggedIn = $this->session->userdata('isLoggedIn');
            if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
            {
                redirect('login');
            }
        }

        public function getstates() {
            if($this->input->post('country')) {
                $states = $this->comman_model->selectAllStates($this->input->post('country'));

                if(count($states) >= 1) {
                        $content = '<option value="">Select State</option><option value="all">All</option>';
                    foreach($states as $state) {
                        $content = $content.'<option value="'.$state["id"].'">'.$state["name"].'</option>';
                    }
                    echo $content;
                } else {
                    echo 'failure';
                }
            } else {
                echo 'failure';
            }
        }

        public function getcities() { 
            if($this->input->post('state_id')) {
                $states = $this->comman_model->selectAllCities($this->input->post('state_id'));
                if(count($states) >= 1) {
                        $content = '<option value="">Select City</option><option value="all">All</option>';
                    foreach($states as $state) {
                        $content = $content.'<option value="'.$state["id"].'">'.$state["name"].'</option>';
                    }
                    echo $content;
                } else {
                    echo 'failure';
                }
            } else {
                echo 'failure';
            }
        }

    }

?>