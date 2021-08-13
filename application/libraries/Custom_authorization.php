<?php
Class Custom_authorization{
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model('Sale_model');
    }

    public function user_login(){
        $this->ci->load->model('user_m');
        $user_id = $this->ci->session->userdata('userid');
        $user_data = $this->ci->user_m->get($user_id)->row();
        return $user_data;
    }

    // for adding new data
    public function addApprovalby($jumlah_transaksi)
    {
        if (intval($jumlah_transaksi) <= 5000000 ) {
            $approvneed = '{"Manager Unit":"-"}';
            return $approvneed;
        }

        if (intval($jumlah_transaksi) > 5000000 && intval($jumlah_transaksi) <= 10000000) {
            $approvneed = '{"Manager Unit":"-","Owner":"-"}';
            return $approvneed;
        }

        if (intval($jumlah_transaksi) > 5000000 ) {
            $approvneed = '{"Manager Unit":"-","Owner":"-"}';
            return $approvneed;
        }
    }

    public function authorization_scheme($scheme, $level_id, $data_required)
    {

        $this->ci->db->where('level_id', $level_id);
        $result = $this->ci->db->get('level')->row();
        if ($result->strict_authorization == 1 ) {
            // let's do it!
            $schemenumber = $scheme;
            if ($schemenumber == 1) {
                $ceg = $this->signtheApproval($result->nama_level,$data_required);
                return $ceg;
                // return $checkallapproved;
            }
        }
    }

    public function signtheApproval($level, $data_required)
    {	
    	// Jika transaksi kurang dari sama dengan 5 jete
        $howmuchtransaction = $data_required['howmuchtransaction'];
        $invoice = $data_required['invoice'];

        $checkdata = $this->ci->Sale_model->get_by_invoice($invoice);

        $leveldisale = json_decode($checkdata->approval_stage, true);

        $leveldisale[$level] = "true";
        
        $checkeverythingisapproved = $this->checkToMakeSureEverythingisApproved($leveldisale);

        if ($checkeverythingisapproved == 'no') {
            $dataapprovalupdate = json_encode($leveldisale);
            return $dataapprovalupdate;
        }

        if ($checkeverythingisapproved == 'ok') {
            return 'cicilanApproved';
        }
        
    }

    public function checkToMakeSureEverythingisApproved($approvaldata)
    {
        $ass_array = $approvaldata;

        $approvedrequirement = count($ass_array);

        $c = 0;
        foreach($ass_array as $v) {
            if ($v === 'true') { 
                $c++;
            }
        }
        
        if ($c < $approvedrequirement) {
            return 'no';
        }

        return 'ok';
    }

    public function apaAkuSudahApprove($level, $invoice)
    {
        $checkdata = $this->ci->Sale_model->get_by_invoice($invoice);

        $leveldisale = json_decode($checkdata->approval_stage, true);

        if($level == 'Manager Unit' || $level == 'Owner')
        {
            if ($leveldisale[$level] == "true") {
            return 'yes';
            }

            if ($leveldisale[$level] == "-") {
                return 'no';
            }
        }
        

        return 'aah youre an admin? ok';
    }
}