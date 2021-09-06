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
    public function addApprovalby($value)
    {
        if (is_int($value)) {
            $jumlah_transaksi = $value;
            // code...
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
        else
        {
            if ($value === 'p-diskondenda') {
                $approvneed = '{"Owner":"-"}';
                return $approvneed;
            }
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

            if ($schemenumber == 2) {
                $ceg = $this->signtheApprovalDiskonDenda($result->nama_level,$data_required);
                return $ceg;
                // return $checkallapproved;
            }
        }
    }

    public function signtheApproval($level, $data_required)
    {
    	
        $checkdata = $this->ci->Approval_lists_model->get_by_id($data_required['approval_id']);

        $leveldisale = json_decode($checkdata->approve_by, true);

        if ($leveldisale[$level] == '-') {
            $invoice = $data_required['invoice'];

            $leveldisale[$level] = $data_required['approvestatus'];

            $checkeverythingisapproved = $this->checkToMakeSureEverythingisApproved($leveldisale);

            if ($checkeverythingisapproved == 'belumlengkap') {
                $arr = array(
                    'dataapprovalupdate' => json_encode($leveldisale),
                    'status' => 'belumlengkap'
                );
                return $arr;
            }

            if ($checkeverythingisapproved == 'Approved') {
                $arr = array(
                    'dataapprovalupdate' => json_encode($leveldisale),
                    'status' => 'cicilanApproved'
                );
                return $arr;
            }

            if ($checkeverythingisapproved == 'Disapproved') {
                $arr = array(
                    'dataapprovalupdate' => json_encode($leveldisale),
                    'status' => 'Cicilandisapproved'
                );
                return $arr;
            }
        } else {
            $arr = array(
                'status' => 'alreadyapprove'
            );
            return $arr;
        }
    }

    public function checkToMakeSureEverythingisApproved($approvaldata)
    {
        $ass_array = $approvaldata;

        $approvedrequirement = count($ass_array);

        $sudahtandatangan = 0;
        $tandatangantrue = 0;
        $tandatanganfalse = 0;

        foreach($ass_array as $v) {
            if ($v != '-') { 
                $sudahtandatangan++;
            }
            if ($v === 'true') {
                $tandatangantrue++;
            }
            if ($v === 'false') {
                $tandatanganfalse++;
            }
        }
        
        if ($sudahtandatangan == $approvedrequirement) {
            if ($tandatanganfalse == $sudahtandatangan || $tandatanganfalse > 0) {
                return 'Disapproved';
            } else {
                return 'Approved';
            }
        }

        return 'belumlengkap';
    }

    public function apaAkuSudahApprove($level, $approval_id)
    {
        $checkdata = $this->ci->Approval_lists_model->get_by_id($approval_id);

        $leveldisale = json_decode($checkdata->approve_by, true);

        if (array_key_exists($level, $leveldisale) || $level === 'Admin Aplikasi') {
            if($level == 'Manager Unit' || $level == 'Owner')
            {
                if ($leveldisale[$level] != "-") {
                    return 'yes';
                }
                return 'no';
            }
            return 'no';
        }
        return 'yes';

    }

    public function signtheApprovalDiskonDenda($level, $data_required)
    {
        
        $checkdata = $this->ci->Approval_lists_model->get_by_id($data_required['approval_id']);

        $leveldisale = json_decode($checkdata->approve_by, true);

        if ($leveldisale[$level] == '-') {
            $invoice = $data_required['invoice'];

            $leveldisale[$level] = $data_required['approvestatus'];

            $checkeverythingisapproved = $this->checkToMakeSureEverythingisApproved($leveldisale);

            if ($checkeverythingisapproved == 'Approved') {
                $arr = array(
                    'dataapprovalupdate' => json_encode($leveldisale),
                    'status' => 'Approved'
                );
                return $arr;
            }

            if ($checkeverythingisapproved == 'Disapproved') {
                $arr = array(
                    'dataapprovalupdate' => json_encode($leveldisale),
                    'status' => 'Disapproved'
                );
                return $arr;
            }
        } else {
            $arr = array(
                'status' => 'alreadyapprove'
            );
            return $arr;
        }
    }
}