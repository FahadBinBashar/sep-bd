<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->database();
        $this
            ->load
            ->model('admin_model');
        $this
            ->load
            ->library('form_validation');
        $this
            ->load
            ->helper('utility');
        $this
            ->load
            ->helper('url');
        date_default_timezone_set("Asia/Dhaka");
        //$today = date('Y-m-d');
        
    }

    public function daily_collection()
    {
        echo $this
            ->input
            ->post('acid', true);
        //echo "<font color=red>Collected</font>";
        if (!empty($this
            ->input
            ->post('installments', true)) && $this
            ->input
            ->post('installment', true) > 0)
        {

            $qnt = $this
                ->input
                ->post('qnt', true);
            $asol = $this
                ->input
                ->post('asol', true);
            $profit = $this
                ->input
                ->post('profit', true);

            $loan_id = $this
                ->input
                ->post('loan_id', true);
            $employee_id = get_name_by_auto_id('account_loan', $loan_id, 'employee_id');

            $data = array(
                'loan_id' => $loan_id,
                'amount_receive' => $this
                    ->input
                    ->post('installment', true) ,
                'asol' => $qnt * $asol,
                'profit' => $qnt * $profit,
                'sts' => 1,
                'employee_id' => $employee_id,
                'uid' => $_SESSION['user_id'],
                'pdate' => date('Y-m-d') ,
                'ptime' => date('H:i:s') ,
                'qnt' => $this
                    ->input
                    ->post('qnt', true)
            );
            $query1 = $this
                ->db
                ->insert('loan_collection', $data);
        }

        if ($this
            ->input
            ->post('saving', true) != '' && $this
            ->input
            ->post('saving', true) > 0)
        {

            $ac_id = $this
                ->input
                ->post('ac_id', true);
            $employee_id = get_name_by_auto_id('account', $ac_id, 'employee_id');

            $data = array(
                'ac_id' => $ac_id,
                'ac_no' => $ac_id,
                'amount_receive' => $this
                    ->input
                    ->post('saving', true) ,
                'amount_return' => 0,
                'sts' => 1,
                'employee_id' => $employee_id,
                'uid' => $_SESSION['user_id'],
                'pdate' => date('Y-m-d') ,
                'ptime' => date('H:i:s')
            );
            $query2 = $this
                ->db
                ->insert('saving_collection', $data);
        }

    }

    public function login()
    {

        $this
            ->load
            ->view('login');
    }

    public function admin_login()
    {

        if (($this
            ->input
            ->post('username', true) != '') && ($this
            ->input
            ->post('password', true) != ''))
        {
            $this
                ->form_validation
                ->set_rules('username', 'Username', 'required');
            $this
                ->form_validation
                ->set_rules('password', 'Password', 'required');

            if ($this
                ->form_validation
                ->run())
            {
                $username = $this
                    ->input
                    ->post('username', true);
                $password = $this
                    ->input
                    ->post('password', true);
                $results = $this
                    ->admin_model
                    ->admin_login_info($username, $password);

                if ($results)
                {
                    foreach ($results as $key => $result)
                    {
                        $_SESSION['user_id'] = $result->id;
                        $_SESSION['name'] = $result->name;
                        $_SESSION['mobile'] = $result->mobile;
                        $_SESSION['pass'] = $result->pass;
                        $_SESSION['status'] = $result->status;

                        if($result->status){
                        redirect(base_url('admin/dashboard'));
                        }
                    }

                }
                else
                {
                    $this
                        ->session
                        ->set_flashdata('error', 'Username or Password is incorrect.');
                    $this->login();
                }
            }
        }
        else
        {
            $this
                ->session
                ->set_flashdata('error', 'Type username & password.');
            $this->login();
        }

    }

    public function logout()
    {
        session_destroy();
        //$this->session->sess_destroy();
        $this
            ->session
            ->unset_userdata("username", "ppp");
        $this
            ->session
            ->set_flashdata('error', 'Logout Successfull.');
        $this->login();
    }

    public function forget_password()
    {
        echo "Please Contact with Software Developer. <a href='admin'>Go Login Page</a>";
        //$this->load->view('admin/forget_password');
        
    }

    public function dashboard()
    {
        $data['zone_list'] = $this
            ->admin_model
            ->zone_list();
        $data['employee_list'] = $this
            ->admin_model
            ->employee_list();
        $data['account_list'] = $this
            ->admin_model
            ->account_list();
        $id = $_SESSION['user_id'];
        
        // $data['total_saving_collection'] = $this
        //     ->admin_model
        //     ->dashboard_emp_total_saving_collection($id);
        
        // $data['total_saving_return'] = $this
        //     ->admin_model
        //     ->dashboard_emp_total_saving_return($id);
            
        $saving                             = $this->admin_model->printb_emp_total_saving($id);    
        $data['total_saving_collection']    = $saving['collection'];
        $data['total_saving_return']        = $saving['sreturn'];
        
        $loan = $this
            ->admin_model
            ->dashboard_emp_total_loan($id);  
        $data['totala']  = $loan['totala'];
        $data['totalp']  = $loan['totalp'];
            
        //$data['totalp'] = $this->admin_model->dashboard_emp_total_loan_profit($id);    
       
            
        $this
            ->load
            ->view('dashboard', $data);
    }

    public function change_password()
    {
        $this
            ->load
            ->view('change_password');
    }

    public function employee_list()
    {
        $data['results'] = $this
            ->admin_model
            ->employee_list();
        $this
            ->load
            ->view('employee_list', $data);
    }
    public function transfer_member()
    {
        $data['results'] = $this
            ->admin_model
            ->employee_list();
        $this
            ->load
            ->view('transfer_member', $data);
    }

    public function employee_add()
    {
        $data['zone_list'] = $this
            ->admin_model
            ->zone_list();
        $this
            ->load
            ->view('employee_add', $data);
    }

    public function employee_edit()
    {
        $this
            ->load
            ->view('employee_edit');
    }

    public function zone_list()
    {
        $data['results'] = $this
            ->admin_model
            ->zone_list();
        $this
            ->load
            ->view('zone_list', $data);
    }

    public function zone_store()
    {
        if (!empty($this
            ->input
            ->post('name', true)))
        {
            $data = array(
                'name' => $this
                    ->input
                    ->post('name', true) ,
                'sts' => 1
            );
            $this
                ->db
                ->insert('zone', $data);
            if ($this
                ->db
                ->affected_rows())
            {
                $this
                    ->session
                    ->set_flashdata('msg', '<font color=green>Save Success!</font>');
                redirect(base_url('admin/zone_list'));
            }
            else
            {
                $this
                    ->session
                    ->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function account_list()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->account_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_account_list($employee_id);
        }

        $this
            ->load
            ->view('account_list', $data);
    }
    // public function account_close($id, $emp_id)
    // {  
    //     $data = array(
    //         'sts' => 0,
    //         'cdate' => date('Y-m-d')
    //     );
    //     $this
    //         ->db
    //         ->update('account', $data, ['id' => $id]);
    //     $this
    //         ->session
    //         ->set_flashdata('msg', '<font color=green>Closed!</font>');
    //     redirect(base_url('admin/account_employee?employee_id=' . $emp_id));

    // }
    
    public function account_close()
    {  
        if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$data = array(
            'sts' => 0,
            'cdate' => date('Y-m-d')
            );
            $this
                ->db
                ->update('account', $data, ['id' => $id]);
			
			echo json_encode(array(
				"statusCode"=>200
			));
		} 

    }
    
    public function ssp_account_close($id, $emp_id)
    {
        $data = array(
            'sts' => 0
        );
        $this
            ->db
            ->update('account_diposit', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Closed!</font>');
        redirect(base_url('admin/ssp_account?employee_id=' . $emp_id));

    }
    // public function account_loan_close($id, $emp_id)
    // {
        // $data = array(
        //     'sts' => 0,
        //     'cdate' => date('Y-m-d')
        // );
        // $this
        //     ->db
        //     ->update('account_loan', $data, ['id' => $id]);
    //     $this
    //         ->session
    //         ->set_flashdata('msg', '<font color=green>Closed!</font>');
    //     redirect(base_url('admin/account_employee?employee_id=' . $emp_id));

    // }
    
     public function account_loan_close()
    {  
        if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$data = array(
            'sts' => 0,
            'cdate' => date('Y-m-d')
            );
            $this
                ->db
                ->update('account_loan', $data, ['id' => $id]);
			
			echo json_encode(array(
				"statusCode"=>200
			));
		} 

    }
    
    public function account_list_transfar()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->account_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_account_list($employee_id);
        }

        $this
            ->load
            ->view('account_list_transfar', $data);
    }

    public function account_add()
    {
        $data['zone_list'] = $this
            ->admin_model
            ->zone_list();
        $data['employee_list'] = $this
            ->admin_model
            ->employee_list();
        $this
            ->load
            ->view('account_add', $data);
    }

    public function account_edit()
    {
        $data['zone_list'] = $this
            ->admin_model
            ->zone_list();
        $data['employee_list'] = $this
            ->admin_model
            ->employee_list();
        $this
            ->load
            ->view('account_edit', $data);
    }
    
    public function ssp_account_edit()
    {
        $data['employee_list'] = $this
            ->admin_model
            ->employee_list();
        $this
            ->load
            ->view('ssp_account_edit', $data);
    }

    public function account_sl()
    {
        $employee_id = $_SESSION['user_id'];
        $data['results'] = $this
            ->admin_model
            ->employee_account_list($employee_id);
        $this
            ->load
            ->view('account_sl', $data);
    }

    public function account_sl_update()
    {

        foreach ($this
            ->input
            ->post('ss[]', true) as $key => $reports)
        {
            $id = $this
                ->input
                ->post('id[]', true) [$key];
            $sl = $this
                ->input
                ->post('sl[]', true) [$key];

            $data = array(
                'sl' => $sl
            );
            $this
                ->db
                ->update('account', $data, ['id' => $id]);
        }
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Update Success!</font>');
        redirect(base_url('admin/account_list'));

    }

    public function loan_list()
    {

        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->loan_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_loan_list($employee_id);
        }
        $this
            ->load
            ->view('loan_list', $data);
    }
    
    public function loan_list_ajax()
   {
    
        $this->load->view('loan_list_ajax');
   
  }
   public function fatchLoanData()
   {
   $columns = array( 
                            0=>'id', 
                            1=> 'ac_no',
                            2=> 'name',
                            3=> 'installment_qnt',
                            4=> 'total',
                            5=> 'collected',
                            6=> 'due',
                            7=> 'loan_date',
                            8=> 'last_date',
                            9=>'link',
                            10=>'action',
                            11=>'id',
                        );

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        
        if ($_SESSION['status'] == 'u')
                {
                   $employee_id = $_SESSION['user_id'];
                   $totalData = $this->admin_model->allpostsemp_count($employee_id);
                }else{
                    $totalData = $this->admin_model->allposts_count();
                }
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {   
           if ($_SESSION['status'] == 'u')
                {
                   $employee_id = $_SESSION['user_id'];
                   $posts = $this->admin_model->allpostsemp($limit,$start,$order,$dir,$employee_id);
                }else{
                   $posts = $this->admin_model->allposts($limit,$start,$order,$dir); 
        
                }   
        }
        else {
            $search = $this->input->post('search')['value']; 

            $posts =  $this->admin_model->posts_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->admin_model->posts_search_count($search);
        }

        $data = array();
        if(!empty($posts))
        {  
            
            foreach ($posts as $post)
            {
               
                $nestedData['id'] = $id=$post->id;
                $nestedData['name'] = get_name_by_auto_id('account', $post->account_id, 'name');
                $nestedData['ac_no'] = $post->account_id;
                
                //$cnt = 0;
                //$queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $post->id)->where('sts', 1)->get();
               // foreach ($queryc->result() as $valuec) { $cnt = $cnt+$valuec->qnt; } $cnt;
               // $nestedData['installment_qnt'] = $post->installment_qnt."/".$cnt;
        
               $nestedData['installment_qnt'] = $post->installment_qnt."/".$this->admin_model->complete_qnt($id);
               $nestedData['collected'] = $this->admin_model->collected_amt($id);
               $nestedData['total'] = $post->total;
               $nestedData['due'] = $post->total-$this->admin_model->collected_amt($id);
               $nestedData['loan_date'] = $post->loan_date;
               $nestedData['last_date'] = $post->last_date;
               $nestedData['link'] = "<a href=".base_url()."admin/loan_collection_details?loan_id=".$post->id.">Details</a>";
               
               if($_SESSION['status']=='a'  && $post->installment_qnt==$this->admin_model->complete_qnt($id)){
               $nestedData['action'] = "<a style='color: red' href=".base_url()."admin/loan_close/".$post->id." onclick='confirmClose();'>Close Now</a>";
               }elseif($post->sts == '1'){
                   $nestedData['action'] = "Runing";
               }elseif($post->sts == '2'){
                   $nestedData['action'] = "<font color=red>Pending</font>";
               }
               
                
                                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);
   
  }
    
   public function loan_delete($id,$Vno)
    {
        // Check if the loan has any transactions
        $transactionCount = $this->db->where('loan_id', $id)->count_all_results('loan_collection');
    
        if ($transactionCount > 0) {
            $this->session->set_flashdata('msg', '<font color=red>You cannot delete this loan. Please delete ' . $transactionCount . ' transactions associated with this loan first.</font>');
        } else {
            
            
             $this->db->delete('acc_transaction', ['VNo' => $Vno]);
            // If no transactions, proceed with deletion
            $this->db->delete('account_loan', ['id' => $id]);
            $this->session->set_flashdata('msg', '<font color=green>Loan deleted successfully!</font>');
        }
    
        redirect(base_url('admin/approved_loan_list'));
    }
    
    
    

    public function loan_add()
    {
        $this
            ->load
            ->view('loan_add');
    }

    public function loan_add_old()
    {
        $this
            ->load
            ->view('loan_add_old');
    }

    public function loan_collection()
    {
        $data['loan_id'] = $_GET['loan_id'];
        $this
            ->load
            ->view('loan_collection', $data);
    }

    public function loan_collection_details()
    {
        $loan_id = $_GET['loan_id'];
        $account_id = get_name_by_auto_id('account_loan', $loan_id, 'account_id');
        $account_name = get_name_by_auto_id('account', $account_id, 'name');

        $data['loan_id'] = $loan_id;
        $data['account_name'] = $account_name;
        $this
            ->load
            ->view('loan_collection_details', $data);
    }

    public function loan_close($id)
    {
        $data = array(
            'sts' => 0,
          	'cdate' => date('Y-m-d')
        );
        $this
            ->db
            ->update('account_loan', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Closed!</font>');
        redirect(base_url('admin/loan_list_ajax'));

    }

    public function date_add()
    {
        $this
            ->load
            ->view('date_add');
    }
    
    public function setting()
    {
          $data['setting'] = $this
            ->admin_model
            ->setting_disable_date();
   
        $this
            ->load
            ->view('setting', $data);
    }

    public function date_list()
    {

        $data['results'] = $this
            ->admin_model
            ->date_list();

        $this
            ->load
            ->view('date_list', $data);
    }
    public function date_delete($id)
        	{
        	
        		$this->db->delete('admin_selected_date',['id' => $id]);
        		$this->session->set_flashdata('msg', '<font color=red>Deleted!</font>');
        		redirect(base_url('admin/date_list'));
        
        
        	}
    public function delete_sentry($id,$Vno,$ac_no)
        	{
        	
        		$this->db->delete('saving_collection',['id' => $id]);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'SavingHisab']);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'SavingCash']);
        		$this->session->set_flashdata('msg', '<font color=red>Deleted!</font>');
        	    redirect(base_url('admin/account_details/' . $ac_no));
        
        	}
    public function delete_sspentry($Vno,$ac_no)
        	{
        	
        		$this->db->delete('diposit_collection',['Vno' => $Vno]);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'AutoSSPRDr']);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'AutoSRDr']);
        		$this->session->set_flashdata('msg', '<font color=red>Deleted!</font>');
        	    redirect(base_url('admin/account_ssp_details/' . $ac_no));
        
        	}
    public function delete_lentry($id,$Vno,$ac_no)
        	{
        	
        		$this->db->delete('loan_collection',['id' => $id]);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'AsolCash']);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'AsolHisab']);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'ProfitCash']);
        		$this->db->delete('acc_transaction',['VNo' => $Vno,'Vtype' => 'ProfitHisab']);
        		$this->session->set_flashdata('msg', '<font color=red>Deleted!</font>');
        	    redirect(base_url('admin/account_details/' . $ac_no));
        
        	}
    
    // public function delete_alll_entry_today($date,$empid)
    //     	{
        	
    //     		$this->db->delete('loan_collection',['pdate' => $date,'employee_id'=> $empid]);
    //     		$this->db->delete('saving_collection',['pdate' => $date,'employee_id'=> $empid]);
    //         	$this->db->delete('acc_transaction', ['VDate' => $date, 'CreateBy' => $empid, 'ledger_id NOT IN' => [32, 40, 51, 56, 55, 46, 57]]);
        		
    //     		$this->session->set_flashdata('msg', '<font color=red>Deleted!</font>');
    //     	    redirect(base_url('admin/collection_report_employee'));
        
    //     	}
    
    public function delete_alll_entry_today($date, $empid)
    {
        // Debugging the SQL queries
        // Ensure that the date and empid are in the expected format
        echo "Date: " . $date . " | Employee ID: " . $empid . "<br>";
    
        // Attempt to delete from loan_collection
        $this->db->delete('loan_collection', ['pdate' => $date, 'employee_id' => $empid]);
        echo $this->db->last_query();  // Log the query for loan_collection
    
        // Attempt to delete from saving_collection
        $this->db->delete('saving_collection', ['pdate' => $date, 'employee_id' => $empid]);
        echo $this->db->last_query();  // Log the query for saving_collection
    
        // Attempt to delete from acc_transaction
        $this->db->where('VDate', $date);
        $this->db->where('CreateBy', $empid);
        $this->db->where_not_in('Vtype', ["AutoCr", "AutoDr"]);
        $this->db->delete('acc_transaction');
        echo $this->db->last_query();  // Log the query for acc_transaction
        
        // Check for any database errors using db->error()
        $error = $this->db->error();  // This returns an array with code and message
        if ($error['code'] != 0) {
            echo "DB Error: " . $error['message'];  // Log the database error message
        }
    
        // Set flash message for user feedback
        $this->session->set_flashdata('msg', '<font color="red">Deleted!</font>');
        
        // Redirect to the collection report page
        redirect(base_url('admin/collection_report_employee'));
    }



    public function ledger_add()
    {
        $this
            ->load
            ->view('ledger_add');
    }

    public function ledger_list()
    {

        $data['results'] = $this
            ->admin_model
            ->ledger_list();

        $this
            ->load
            ->view('ledger_list', $data);
    }
    public function bs_ledger_add()
    {
        $this
            ->load
            ->view('bs_ledger_add');
    }

    public function bs_ledger_list()
    {

        $data['results'] = $this
            ->admin_model
            ->bs_ledger_list();

        $this
            ->load
            ->view('bs_ledger_list', $data);
    }

    public function diposit_list()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->diposit_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_diposit_list($employee_id);
        }

        $this
            ->load
            ->view('diposit_list', $data);
    }

    public function diposit_add()
    {
        $this
            ->load
            ->view('diposit_add');
    }

    public function diposit_collection()
    {

        $this
            ->load
            ->view('diposit_collection');
    }
    public function office_employee()
    {

        $this
            ->load
            ->view('office_employee');
    }

    public function dr_voucher()
    {

        $this
            ->load
            ->view('dr_voucher');
    }

    public function cr_voucher()
    {

        $this
            ->load
            ->view('cr_voucher');
    }

    public function diposit_return()
    {
        $data['setting'] = $this
            ->admin_model
            ->setting_disable_date();
        $this
            ->load
            ->view('diposit_return', $data);
    }

    public function investment_list()
    {

        $data['results'] = $this
            ->admin_model
            ->investment_list();

        $this
            ->load
            ->view('investment_list', $data);
    }
     public function multiple_investment_entry()
    {

        $data['results'] = $this
            ->admin_model
            ->investment_list();

        $this
            ->load
            ->view('multiple_investment_entry', $data);
    }
    public function investment_add()
    {
        $this
            ->load
            ->view('investment_add');
    }

    public function investment_collection()
    {

        $this
            ->load
            ->view('investment_collection');
    }

    public function investment_return()
    {
        $this
            ->load
            ->view('investment_return');
    }

    public function expense_cat()
    {
        $data['results'] = $this
            ->admin_model
            ->expense_cat();
        $this
            ->load
            ->view('expense_cat', $data);
    }

    public function expense_new()
    {
        $data['category_list'] = $this
            ->admin_model
            ->category_list();
        $data['expense_info'] = $this
            ->admin_model
            ->expense_info();
        $this
            ->load
            ->view('expense_new', $data);
    }

    public function expense_report()
    {
        $this
            ->load
            ->view('expense_report');
    }

    public function salary_pay()
    {
        $data['employee_list'] = $this
            ->admin_model
            ->employee_list();
        $data['salary_info'] = $this
            ->admin_model
            ->salary_info();
        $this
            ->load
            ->view('salary_pay', $data);
    }

    public function salary_editxxxxxx($salary_id)
    {
        $data['salary_id'] = $salary_id;
        $data['single_salary'] = $this
            ->admin_model
            ->single_salary($salary_id);
        $this
            ->load
            ->view('fishing/salary_edit', $data);
    }

    public function salary_detailsxxxxxxx($employee_id)
    {
        $data['employee_id'] = $employee_id;
        $data['employee_salary'] = $this
            ->admin_model
            ->employee_salary($employee_id);
        $this
            ->load
            ->view('fishing/salary_details', $data);
    }

    public function salary_report()
    {
        $this
            ->load
            ->view('salary_report');
    }

    public function saving_collection()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->account_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_account_list($employee_id);
        }

        $this
            ->load
            ->view('saving_collection', $data);
    }

    public function collection()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->account_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_account_list($employee_id);
        }

        $this
            ->load
            ->view('collection', $data);
    }
    
    public function thanks()
    {
        

        $this
            ->load
            ->view('thanks');
    }


    public function pre_collection()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->account_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_account_list($employee_id);
        }

        $this
            ->load
            ->view('pre_collection', $data);
    }

    public function collection_report_user()
    {
        $this
            ->load
            ->view('collection_report_user');
    }

    public function collection_report_employee()
    {
        $this
            ->load
            ->view('collection_report_employee');
    }

    public function old_collection()
    {
        if ($_SESSION['status'] == 'a')
        {
            $data['results'] = $this
                ->admin_model
                ->account_list();
        }
        elseif ($_SESSION['status'] == 'u')
        {
            $employee_id = $_SESSION['user_id'];
            $data['results'] = $this
                ->admin_model
                ->employee_account_list($employee_id);
        }

        $this
            ->load
            ->view('old_collection', $data);
    }

    public function saving_return()
    {
        $data['setting'] = $this
            ->admin_model
            ->setting_disable_date();
        $this
            ->load
            ->view('saving_return', $data);
    }

    public function return_approved()
    {
        $this
            ->load
            ->view('return_approved');
    }

    public function returned_list()
    {
        $this
            ->load
            ->view('returned_list');
    }
    public function approved_loan_list()
    {
        $this
            ->load
            ->view('approved_loan_list');
    }
    public function loan_confirm($id, $Vno)
    {
        $data = array(
            'sts' => 1
        );
        $this
            ->db
            ->update('account_loan', $data, ['id' => $id]);

        $vdata = array(
            'IsAppove' => 1
        );
        $this
            ->db
            ->update('acc_transaction', $vdata, ['Vno' => $Vno]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Loan Approved!</font>');
        redirect(base_url('admin/pending_loan_list'));

    }
    
     public function loan_reject($id, $Vno)
    {
        $data = array(
            'sts' => 3,
          	'cdate' => date('Y-m-d')
        );
        $this
            ->db
            ->update('account_loan', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=red>Rejeted!</font>');
        redirect(base_url('admin/pending_loan_list'));

    }
    public function saving_return_confirm($id, $Vno)
    {
        $data = array(
            'sts' => 1
        );
        $this
            ->db
            ->update('saving_collection', $data, ['id' => $id]);

        $vdata = array(
            'IsAppove' => 1
        );
        $this
            ->db
            ->update('acc_transaction', $vdata, ['Vno' => $Vno]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Approved!</font>');
        redirect(base_url('admin/pending_return_list'));

    }
    public function saving_return_reject($id)
    {
        $data = array(
            'sts' => 3
        );
        $this
            ->db
            ->update('saving_collection', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=red>Rejected!</font>');
        redirect(base_url('admin/pending_return_list'));

    }
    public function ssp_returned_list()
    {
        $this
            ->load
            ->view('ssp_returned_list');
    }
     public function ssp_return_confirm($id, $Vno)
    {
        $data = array(
            'sts' => 1
        );
        $this
            ->db
            ->update('diposit_collection', $data, ['id' => $id]);

        $vdata = array(
            'IsAppove' => 1
        );
        $this
            ->db
            ->update('acc_transaction', $vdata, ['Vno' => $Vno]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Approved!</font>');
        redirect(base_url('admin/pending_ssp_return_list'));

    }
    public function ssp_return_reject($id)
    {
        $data = array(
            'sts' => 3
        );
        $this
            ->db
            ->update('diposit_collection', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Approved!</font>');
        redirect(base_url('admin/pending_ssp_return_list'));

    }

    public function date_confirm($id)
    {
        $data = array(
            'sts' => 1
        );
        $this
            ->db
            ->update('admin_selected_date', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Active!</font>');
        redirect(base_url('admin/date_list'));

    }

    public function date_reject($id)
    {
        $data = array(
            'sts' => 0
        );
        $this
            ->db
            ->update('admin_selected_date', $data, ['id' => $id]);
        $this
            ->session
            ->set_flashdata('msg', '<font color=red>disable!</font>');
        redirect(base_url('admin/date_list'));

    }

    public function transfer_confirm()
    {
        $emp = $this
            ->input
            ->post('emp');
        if (!empty($this
            ->input
            ->post('checkbox')) && !empty($this
            ->input
            ->post('checkboxl')))
        {

            $a = implode(",", $this
                ->input
                ->post('checkbox'));
            $al = implode(",", $this
                ->input
                ->post('checkboxl'));
            $sql = "UPDATE account SET employee_id=$emp,uid=$emp WHERE id IN ($a)";
            $this
                ->db
                ->query($sql);
            $sql = "UPDATE account_loan SET employee_id=$emp,uid=$emp WHERE ac_no IN ($a)";
            $this
                ->db
                ->query($sql);
            $sql = "UPDATE loan_collection SET employee_id=$emp,uid=$emp WHERE loan_id IN ($al)";
            $this
                ->db
                ->query($sql);
            $sql = "UPDATE saving_collection SET employee_id=$emp,uid=$emp WHERE ac_no IN ($a)";
            $this
                ->db
                ->query($sql);
            redirect(base_url('admin/transfer_member'));
        }
    }

    public function account_employee()
    {
       $id=$_GET['employee_id'];
       $data['cnt'] = $this
            ->admin_model
            ->member_countByemp($id);
       $data['list'] = $this
            ->admin_model
            ->member_listByemp($id);
       $this
            ->load
            ->view('account_employee', $data);
    }
    public function ssp_account()
    {
        $this
            ->load
            ->view('ssp_account');
    }
    public function transfermember_list_emp()
    {
        $this
            ->load
            ->view('transfermember_list_emp');
    }
     public function multi_invest_confirm()
    {   
        foreach ($this
            ->input
            ->post('id[]', true) as $key => $ids)
        {
            $time=time() + 60*60;
           $data = array(
                      	
                        'ac_id'          => $ids,
                        'amount_receive' => $this->input->post('amount_receive', true),
                        'amount_return'  => 0,
                        'sts'            => 1,
                        'uid'            => $_SESSION['user_id'],
                        'pdate'          => $this->input->post('pdate', true),
                        'ptime'          => date("H:s:i"),
                        'Vno'            => $time.$ids
                    );
        
        $this->db->insert('investment_collection', $data);
        
        //query for account type
                     
                     $query = $this->db->select('*')->from('account_investment')->where('id', $ids)->get();
                     foreach ($query->result() as $key => $value) {
                        $type=$value->type;
                      }
                    
                    if($type==0){
                    
                    
                    $INVDCash = array(
    
                        'VNo' => $time.$ids,
                        'Vtype' => 'AutoINVDC',
                        'VDate' => $this->input->post('pdate', true),
                        'ledger_id' => 1,
                        'Narration' => "সদস্য বিনিয়োগ হিসাব আদায়--" . $_SESSION['name'],
                        'Debit' => $this->input->post('amount_receive', true),
                        'Credit' => 0,
                        'IsPosted' => $ids,
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVDCash);
                    $INVD = array(
                        'VNo' => $time.$ids,
                        'Vtype' => 'AutoSSPDC',
                        'VDate' => $this->input->post('pdate', true) ,
                        'ledger_id' => 48,
                        'Narration' => "সদস্য বিনিয়োগ হিসাব আদায়--" . $_SESSION['name'],
                        'Debit' => 0,
                        'Credit' => $this->input->post('amount_receive', true),
                        'IsPosted' => $ids,
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVD);
                        
                    }else{
                      $INVDCash = array(
    
                        'VNo' => $time.$ids,
                        'Vtype' => 'AutoINVDC',
                        'VDate' => $this->input->post('pdate', true) ,
                        'ledger_id' => 1,
                        'Narration' => "পরিচালক আমানত হিসাব আদায়--" . $_SESSION['name'],
                        'Debit' => $this->input->post('amount_receive', true),
                        'Credit' => 0,
                        'IsPosted' => $ids,
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVDCash);
                    $INVD = array(
                        'VNo' =>   $time.$ids,
                        'Vtype' => 'AutoSSPDC',
                        'VDate' => $this->input->post('pdate', true),
                        'ledger_id' => 42,
                        'Narration' => "পরিচালক আমানত হিসাব আদায়--" . $_SESSION['name'],
                        'Debit' => 0,
                        'Credit' => $this->input->post('amount_receive', true),
                        'IsPosted' => $ids,
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVD);
                    }
        
        
        
        
        
        
        
        
         }
         
         
         
         
        
        if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/multiple_investment_entry'));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                    }   
    }
    
     public function collection_confirm()
    {   
        $empid=$_SESSION['user_id'];
        $date=date('Y-m-d');
        $total_asol=0;
        $total_profit=0;
        foreach ($this
            ->input
            ->post('xx[]', true) as $key => $reports)
        {
            
            $installment = $this
                ->input
                ->post('installment[]', true) [$key]??0;
            if (!empty($installment) && $installment > 0)
            {
                $res = $this
                    ->input
                    ->post('Vno[]', true) [$key]??0;
                $qnt = $this
                    ->input
                    ->post('qnt[]', true) [$key]??0;
                $asol = $this
                    ->input
                    ->post('asol[]', true) [$key]??0;
                $profit = $this
                    ->input
                    ->post('profit[]', true) [$key]??0;
                $loan_id = $this
                    ->input
                    ->post('loan_id[]', true) [$key]??0;
                $ac_id = $this
                    ->input
                    ->post('ac_id[]', true) [$key]??0;
                $time = time() + 60 * 60;
                
                $data = array(
                    'loan_id' => $loan_id,
                    'amount_receive' => $installment,
                    'asol' => $qnt * $asol,
                    'profit' => $qnt * $profit,
                    'sts' => 1,
                    'employee_id' => $_SESSION['user_id'],
                    'uid' => $_SESSION['user_id'],
                    'pdate' => date('Y-m-d') ,
                    'ptime' => date('H:i:s') ,
                    'qnt' => $qnt,
                    'Vno' => $res
                );
                
               $queryl = $this
                    ->db
                    ->insert('loan_collection', $data);
                
                $loan_asolCash = array(

                    'VNo' => $res,
                    'Vtype' => 'AsolCash',
                    'VDate' => date('Y-m-d') ,
                    'ledger_id' => 1,
                    'Narration' => get_name_by_auto_id('account', $ac_id, 'name')."-আসল ঋণ হিসাব আদায়--" . $_SESSION['name'],
                    'Debit' => $qnt * $asol,
                    'Credit' => 0,
                    'IsPosted' => $_SESSION['user_id'],
                    'CreateBy' => $_SESSION['user_id'],
                    'CreateDate' => date('Y-m-d H:i:s') ,
                    'IsAppove' => 1
                );
                $query = $this
                    ->db
                    ->insert('acc_transaction', $loan_asolCash);
                $loan_asol = array(
                    'VNo' => $res,
                    'Vtype' => 'AsolHisab',
                    'VDate' => date('Y-m-d') ,
                    'ledger_id' => 53,
                    'Narration' => get_name_by_auto_id('account', $ac_id, 'name')."-আসল ঋণ হিসাব আদায়--" . $_SESSION['name'],
                    'Debit' => 0,
                    'Credit' => $qnt * $asol,
                    'IsPosted' => $_SESSION['user_id'],
                    'CreateBy' => $_SESSION['user_id'],
                    'CreateDate' => date('Y-m-d H:i:s') ,
                    'IsAppove' => 1
                );
                $query = $this
                    ->db
                    ->insert('acc_transaction', $loan_asol);
                $loan_profitCash = array(

                    'VNo' => $res,
                    'Vtype' => 'ProfitCash',
                    'VDate' => date('Y-m-d') ,
                    'ledger_id' => 1,
                    'Narration' => get_name_by_auto_id('account', $ac_id, 'name')."-ঋণ মুনাফা আদায়--" . $_SESSION['name'],
                    'Debit' => $qnt * $profit,
                    'Credit' => 0,
                    'IsPosted' => $_SESSION['user_id'],
                    'CreateBy' => $_SESSION['user_id'],
                    'CreateDate' => date('Y-m-d H:i:s') ,
                    'IsAppove' => 1
                );
                $query = $this
                    ->db
                    ->insert('acc_transaction', $loan_profitCash);
                $loan_profit = array(
                    'VNo' => $res,
                    'Vtype' => 'ProfitHisab',
                    'VDate' => date('Y-m-d') ,
                    'ledger_id' => 31,
                    'Narration' => get_name_by_auto_id('account', $ac_id, 'name')."-ঋণ মুনাফা আদায়--" . $_SESSION['name'],
                    'Debit' => 0,
                    'Credit' => $qnt * $profit,
                    'IsPosted' => $_SESSION['user_id'],
                    'CreateBy' => $_SESSION['user_id'],
                    'CreateDate' => date('Y-m-d H:i:s') ,
                    'IsAppove' => 1
                );
                $query = $this
                    ->db
                    ->insert('acc_transaction', $loan_profit);
            }
            
        }
        
        
        
        
        
        foreach ($this
            ->input
            ->post('zz[]', true) as $key => $reports)
        {
            $saving = $this
                ->input
                ->post('saving[]', true) [$key]??0;
            if (!empty($saving) && $saving > 0)
            {
               $ress = $this
                    ->input
                    ->post('VSno[]', true) [$key];
               
                $ac_id = $this
                    ->input
                    ->post('ac_id[]', true) [$key]??0;
                

                $data = array(
                    'ac_id' => $ac_id,
                    'ac_no' => $ac_id,
                    'amount_receive' => $saving,
                    'amount_return' => 0,
                    'sts' => 1,
                    'employee_id' => $_SESSION['user_id'],
                    'uid' => $_SESSION['user_id'],
                    'pdate' => date('Y-m-d') ,
                    'ptime' => date('H:i:s'),
                    'VNo' => $ress
                );
                $querys = $this
                    ->db
                    ->insert('saving_collection', $data);
                $savingDCash = array(

                    'VNo' => $ress,
                    'Vtype' => 'SavingCash',
                    'VDate' => date('Y-m-d') ,
                    'ledger_id' => 1,
                    'Narration' => get_name_by_auto_id('account', $ac_id, 'name')."-সঞ্চয় হিসাব আদায়--" . $_SESSION['name'],
                    'Debit' => $saving,
                    'Credit' => 0,
                    'IsPosted' => $ac_id,
                    'CreateBy' => $_SESSION['user_id'],
                    'CreateDate' => date('Y-m-d H:i:s') ,
                    'IsAppove' => 1
                );
                $query = $this
                    ->db
                    ->insert('acc_transaction', $savingDCash);
                $savingD = array(
                    'VNo' => $ress,
                    'Vtype' => 'SavingHisab',
                    'VDate' => date('Y-m-d') ,
                    'ledger_id' => 26,
                    'Narration' => get_name_by_auto_id('account', $ac_id, 'name')."-সঞ্চয় হিসাব আদায়--" . $_SESSION['name'],
                    'Debit' => 0,
                    'Credit' => $saving,
                    'IsPosted' => $ac_id,
                    'CreateBy' => $_SESSION['user_id'],
                    'CreateDate' => date('Y-m-d H:i:s') ,
                    'IsAppove' => 1
                );
                $query = $this
                    ->db
                    ->insert('acc_transaction', $savingD);

                
            }
        }
        
        
       
                    
                   
        $this
            ->session
            ->set_flashdata('msg', '<font color=green>Update Success!</font>');
        redirect(base_url('admin/thanks'));

        //$this->load->view('account_employee');
        
    }

   public function pre_collection_confirm()
    {
        
        
            

                foreach ($this
                    ->input
                    ->post('xx[]', true) as $key => $reports)
                {

                    $installment = $this
                        ->input
                        ->post('installment[]', true) [$key];
                    if (!empty($installment) && $installment > 0)
                    {
                        $date = $this
                            ->input
                            ->post('date', true);
                        $qnt = $this
                            ->input
                            ->post('qnt[]', true) [$key];
                        $asol = $this
                            ->input
                            ->post('asol[]', true) [$key];
                        $profit = $this
                            ->input
                            ->post('profit[]', true) [$key];
                        $loan_id = $this
                            ->input
                            ->post('loan_id[]', true) [$key];
                        $data = array(
                            'loan_id' => $loan_id,
                            'amount_receive' => $installment,
                            'asol' => $qnt * $asol,
                            'profit' => $qnt * $profit,
                            'sts' => 1,
                            'employee_id' => $_SESSION['user_id'],
                            'uid' => $_SESSION['user_id'],
                            'pdate' => $date,
                            'ptime' => '16:26:47',
                            'qnt' => $qnt
                        );
                        $query1 = $this
                            ->db
                            ->insert('loan_collection', $data);
                    }
                }

                foreach ($this
                    ->input
                    ->post('zz[]', true) as $key => $reports)
                {
                    $saving = $this
                        ->input
                        ->post('saving[]', true) [$key];
                    if (!empty($saving) && $saving > 0)
                    {
                        $ac_id = $this
                            ->input
                            ->post('ac_id[]', true) [$key];
                        $date = $this
                            ->input
                            ->post('date', true);
                        $data = array(
                            'ac_id' => $ac_id,
                            'ac_no' => $ac_id,
                            'amount_receive' => $saving,
                            'amount_return' => 0,
                            'sts' => 1,
                            'employee_id' => $_SESSION['user_id'],
                            'uid' => $_SESSION['user_id'],
                            'pdate' => $date,
                            'ptime' => '16:26:47'
                        );
                        $query2 = $this
                            ->db
                            ->insert('saving_collection', $data);
                    }
                }
                $this
                    ->session
                    ->set_flashdata('msg', '<font color=green>Update Success!</font>');
                redirect(base_url('admin/thanks'));
            
       
    }
    public function account_details($id)
    {
        $data['id'] = $id;
        $this
            ->load
            ->view('account_details', $data);
    }
    public function account_ssp_details($id)
    {
        $data['id'] = $id;
        $this
            ->load
            ->view('account_ssp_details', $data);
    }
   public function print_balance($id)
	{	
      	$data['currect_date']               = date('Y-m-d');
      	$data['id']                         = $id;
      	$data['count']                      = $this->admin_model->active_member($id);
//         $saving                             = $this->admin_model->printb_emp_total_saving($id);    
//         $data['total_saving_collection']    = $saving['collection'];
//         $data['total_saving_return']        = $saving['sreturn'];
//         $data['totalsaving']                = $saving['collection']-$saving['sreturn'];
//         $loan_t                             = $this->admin_model->printb_emp_total_loan($id);
// 		$data['totala']                     = $loan_t['asol'];
//         $data['totalp']                     = $loan_t['profit'];
//         $data['totalloan']                  = $loan_t['asol']+$loan_t['profit'];
        $data['account_list']               = $this->admin_model->employee_account_list($id);
        
        
        $this->load->view('print_balance', $data);
	}
	
	public function custom_print_balance()
	{	
	    $id= $this->input->post('id', true);
        $sdate= $this->input->post('sdate', true);
      	$date=date_create("$sdate"); 
      	$data['count']                      = $this->admin_model->custom_active_member($id,$sdate);
        // $saving                             = $this->admin_model->custom_printb_emp_total_saving($id,$sdate);    
        // $data['total_saving_collection']    = $saving['collection'];
        // $data['total_saving_return']        = $saving['sreturn'];
        // $data['totalsaving']                = $saving['collection']-$saving['sreturn'];
        // $loan_t                             = $this->admin_model->custom_printb_emp_total_loan($id,$sdate);
        // $data['totala']                     = $loan_t['asol'];
        // $data['totalp']                     = $loan_t['profit'];
        // $data['totalloan']                  = $loan_t['asol']+$loan_t['profit'];
        $data['account_list']               = $this->admin_model->custom_employee_account_list($id,$sdate);
        $data['id']                         = $id;
        $data['sdate']                      = date_format($date,"d-m-Y");
        $data['qqsdate']                      = $sdate;
        
        $this->load->view('custom_print_balance', $data);
	}
	
	public function print_balancee()
	{
	
		$this->load->view('custom_print_balance');
	}
    public function total_collection_report()
    {
        $this
            ->load
            ->view('total_collection_report');
    }
     public function all_collection_report()
    {
        $data['results'] = $this
            ->admin_model
            ->employee_list();
        $this
            ->load
            ->view('all_collection_report', $data);
        
        
    }
    public function emp_total_collection_report()
    {
        $this
            ->load
            ->view('emp_total_collection_report');
    }
    
    public function emp_total_ssp_report()
	{
		$this->load->view('emp_total_ssp_report');
	}
	public function ssp_report()
	{
		$this->load->view('ssp_report');
	}
    public function cash_book()
    {
        $this
            ->load
            ->view('cash_book');
    }
     public function cash_book_report()
    {
        $this
            ->load
            ->view('cash_book_report');
    }
    public function general_ledger()
    {
        $this
            ->load
            ->view('general_ledger');
    }
    public function trial_balance()
    {
        $this
            ->load
            ->view('trial_balance');
    }
    public function inc_exp()
    {
        $this
            ->load
            ->view('inc_exp');
    }
    public function balance_sheet()
    {
        $this
            ->load
            ->view('balance_sheet');
    }
    public function pending_loan_list()
    {
        $this
            ->load
            ->view('pending_loan_list');
    }
    public function pending_return_list()
    {
        $this
            ->load
            ->view('pending_return_list');
    }
    public function pending_ssp_return_list()
    {
        $this
            ->load
            ->view('pending_ssp_return_list');
    }

    //=======================================================================================
    public function student()
    {
        $data['results'] = $this
            ->admin_model
            ->student_info();
        $this
            ->load
            ->view('admin/student', $data);
    }

    public function student_add()
    {
        $data['courses'] = $this
            ->admin_model
            ->course_info();
        $this
            ->load
            ->view('admin/student_add', $data);
    }

    public function student_submit()
    {
        if ($this
            ->input
            ->post('name', true) != '')
        {

            $this
                ->form_validation
                ->set_rules('name', 'Name', 'required');
            if ($this
                ->form_validation
                ->run())
            {
                $data = array(

                    'name' => $this
                        ->input
                        ->post('name', true) ,
                    'student_id' => $this
                        ->input
                        ->post('sid', true) ,
                    'mobile' => $this
                        ->input
                        ->post('mobile', true) ,
                    'email' => $this
                        ->input
                        ->post('email', true) ,
                    'pass' => $pass = $this
                        ->input
                        ->post('password', true) ,
                    'password' => md5($pass) ,
                    'sts' => 1
                );
                $this
                    ->db
                    ->insert('student', $data);
                $data['msg'] = '<font color=green>Added Successfull.</font>';
                $data['results'] = $this
                    ->admin_model
                    ->student_info();
                $this
                    ->load
                    ->view('admin/student', $data);
            }
        }
        else
        {
            $data['msg'] = '<font color=red>Insert Currect Data.</font>';
            $data['results'] = $this
                ->admin_model
                ->student_info();
            $this
                ->load
                ->view('admin/student', $data);
        }
    }

    public function student_edit()
    {
        $this
            ->load
            ->view('admin/student_edit');
    }
     
     
     
     //database old data delete oparation
    
    public function db_delete()
    {
        $data['results'] = $this
            ->admin_model
            ->all_employee_list();
        $this
            ->load
            ->view('db_delete', $data);
        
        
    }

     public function member_list_emp_wise()
    {
        $this
            ->load
            ->view('member_list_emp_wise');
    }
    
    public function old_data_delete_confirm()
    {
        
        if (!empty($this->input->post('checkbox')))
        {
            $emp = $this->input->post('emp');
            $a = implode(",", $this
                ->input
                ->post('checkbox'));
           
                
                
            $sql = "DELETE FROM saving_collection WHERE ac_no IN ($a)";
            $this
                ->db
                ->query($sql);
            
            $sql = "DELETE FROM account_loan WHERE ac_no IN ($a)";
            $this
                ->db
                ->query($sql);
            
            $sql = "DELETE FROM account WHERE id IN ($a)";
            $this
                ->db
                ->query($sql);
            
            
            redirect(base_url('admin/member_list_emp_wise?employee_id='.$emp));
        } elseif(!empty($this->input->post('checkboxl'))){
             
             $emp = $this->input->post('emp');
             $al = implode(",", $this
                ->input
                ->post('checkboxl'));
            
            $sql = "DELETE FROM loan_collection WHERE loan_id IN ($al)";
            $this
                ->db
                ->query($sql);
                
        } elseif(!empty($this->input->post('checkbox')) && !empty($this->input->post('checkboxl')))
        {
            $emp = $this->input->post('emp');
            $a = implode(",", $this
                ->input
                ->post('checkbox'));
            $al = implode(",", $this
                ->input
                ->post('checkboxl'));
                
                
            $sql = "DELETE FROM saving_collection WHERE ac_no IN ($a)";
            $this
                ->db
                ->query($sql);
            $sql = "DELETE FROM loan_collection WHERE loan_id IN ($al)";
            $this
                ->db
                ->query($sql);
            $sql = "DELETE FROM account_loan WHERE ac_no IN ($a)";
            $this
                ->db
                ->query($sql);
            
            $sql = "DELETE FROM account WHERE id IN ($a)";
            $this
                ->db
                ->query($sql);
            
            
            redirect(base_url('admin/member_list_emp_wise?employee_id='.$emp));
        }
    }
    
    public function qr_print($employee_id)
    {
        $this->load->helper('url');
        require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');
    
        $perPage = $this->input->get('per_page') ?? 10; // Default to 10 if not set
    
        $accounts = $this->db->select('id, name')
                             ->from('account')
                             ->where('sts', 1)
                             ->where('employee_id', $employee_id)
                             ->order_by('pdate', 'asc')
                             ->get()
                             ->result();
    
        $members = [];
    
        foreach ($accounts as $acc) {
            $tempDir = sys_get_temp_dir();
            $filename = $tempDir . "/qr_{$acc->id}.png";
            QRcode::png($acc->id, $filename, QR_ECLEVEL_L, 5);
            $qrBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($filename));
    
            $members[] = [
                'qr' => $qrBase64,
                'name' => $acc->name
            ];
        }
    
        $data['members'] = $members;
        $data['per_page'] = $perPage; // Pass to view
        $this->load->view('qr_print', $data);
    }
    
    public function qr_single($member_id)
    {
        $this->load->helper('url');
        require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');
    
        $member = $this->db->select('id, name')
                           ->from('account')
                           ->where('sts', 1)
                           ->where('id', $member_id)
                           ->get()
                           ->row();
    
        if (!$member) {
            show_error("Member not found");
        }
    
        // Generate QR
        $tempDir = sys_get_temp_dir();
        $filename = $tempDir . "/qr_{$member->id}.png";
        QRcode::png($member->id, $filename, QR_ECLEVEL_L, 5);
        $qrBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($filename));
    
        $data = [
            'qr' => $qrBase64,
            'name' => $member->name,
            'id' => $member->id
        ];
    
        $this->load->view('qr_single', $data);
    }


}

