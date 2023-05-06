<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{

    public function getAreas()
    {
        $query = $this->db->select('*')->get('store_area');
        return $query->result();
    }

    public function getBrands()
    {
        $query = $this->db->select('*')->get('product_brand');
        return $query->result();
    }

    public function get_report_data($areas, $date_from, $date_to)
    {
        $this->db->select('pb.brand_name, sa.area_name, SUM(rp.compliance) / COUNT(*)* 100 AS nilai');
        $this->db->from('report_product rp');
        $this->db->join('product p', 'rp.product_id = p.product_id');
        $this->db->join('product_brand pb', 'p.brand_id = pb.brand_id');
        $this->db->join('store s', 'rp.store_id = s.store_id');
        $this->db->join('store_area sa', 's.area_id = sa.area_id');

        if (!empty($areas)) {
            $this->db->where_in('sa.area_name', $areas);
        }
        if (!empty($date_from)) {
            $this->db->where('rp.tanggal >=', $date_from);
        }
        if (!empty($date_to)) {
            $this->db->where('rp.tanggal <=', $date_to);
        }

        $this->db->group_by('pb.brand_name, sa.area_name');

        $query = $this->db->get();

        $data = [];
        foreach ($query->result() as $row) {
            $brand_name = $row->brand_name;
            $area_name = $row->area_name;
            $nilai = $row->nilai;

            if (!array_key_exists($brand_name, $data)) {
                $data[$brand_name] = array(
                    'brand_name' => $brand_name,
                    'area' => array()
                );
            }

            // Tambahkan data area baru pada brand yang sesuai
            $data[$brand_name]['area'][] = array(
                'area_name' => $area_name,
                'nilai' => $nilai
            );
        }

        return array_values($data);
    }

    public function get_report_chart_data($areas, $date_from, $date_to)
    {
        $this->db->select('sa.area_name, SUM(rp.compliance) / COUNT(*)* 100 AS nilai');
        $this->db->from('report_product rp');
        $this->db->join('store s', 'rp.store_id = s.store_id');
        $this->db->join('store_area sa', 's.area_id = sa.area_id');

        if (!empty($areas)) {
            $this->db->where_in('sa.area_name', $areas);
        }
        if (!empty($date_from)) {
            $this->db->where('rp.tanggal >=', $date_from);
        }
        if (!empty($date_to)) {
            $this->db->where('rp.tanggal <=', $date_to);
        }

        $this->db->group_by('sa.area_name');

        $query = $this->db->get();
        return $query->result();
    }

}