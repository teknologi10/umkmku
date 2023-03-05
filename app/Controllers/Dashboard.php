<?php

namespace App\Controllers;


class Dashboard extends BaseController
{
    public function index()
    {
        $this->db->table('grafik_dashboard')->truncate();
        $bulan1 = date("Y-m-d", strtotime("-2 Months"));
        $bulan2 = date("Y-m-d", strtotime("-1 Months"));
        $bulan3 = date("Y-m-d", strtotime("0 Months"));
        $d = strtotime("-2 Months");
        $awal = date("Y-m-d", $d);
        $akhir = date("Y-m-d");
        $blibli = $this->db->table('umum_blibli')->where('tgl>=', $awal)->where('tgl<=', $akhir)->get()->getResultArray();
        $shopee = $this->db->table('umum_shopee')->where('tgl>=', $awal)->where('tgl<=', $akhir)->get()->getResultArray();
        $tokped = $this->db->table('umum_tokped')->where('tgl>=', $awal)->where('tgl<=', $akhir)->get()->getResultArray();
        // dd($blibli);
        foreach ($blibli as $b) {
            $simpanb = [
                'tgl' => $b['tgl'],
                'jual_blibli' => $b['penjualan']
            ];
            // dd($simpanb);
            $this->db->table('grafik_dashboard')->insert($simpanb);
        }
        foreach ($shopee as $s) {
            $simpans = [
                'tgl' => $s['tgl'],
                'jual_shopee' => $s['penjualan']
            ];
            // dd($simpans);
            $this->db->table('grafik_dashboard')->insert($simpans);
        }
        foreach ($tokped as $t) {
            $simpant = [
                'tgl' => $t['tgl'],
                'jual_tokped' => $t['pendapatan_bersih']
            ];
            // dd($simpans);
            $this->db->table('grafik_dashboard')->insert($simpant);
        }
        $grafik = $this->db->table('grafik_dashboard')->select('date_format(tgl, "%Y-%m") as periode, sum(jual_blibli) as blibli, sum(jual_shopee) as shopee, sum(jual_tokped) as tokped')
            ->groupBy('periode')->orderBy('periode', 'asc')->get()->getResultArray();
        $data['grafik'] = $grafik;
        if (empty($grafik)) {
            $bulan[0]['periode'] = $bulan1;
            $bulan[1]['periode'] = $bulan2;
            $bulan[2]['periode'] = $bulan3;
            $data['bulan'] = $bulan;
        }
        // dd($data);
        return view('dashboard/index', $data);

        // echo view('admin/footer');
    }
}
