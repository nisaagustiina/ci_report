<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model');
    }

    public function index()
    {
        $data['areas'] = $this->report_model->getAreas();

        $areas = $this->input->post('area');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $data['selected_area'] = $areas;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        $data['report_data'] = $this->report_model->get_report_data($areas, $date_from, $date_to);
        $data['chart_data'] = $this->report_model->get_report_chart_data($areas, $date_from, $date_to);

        $this->load->view('report_view', $data);
    }

}