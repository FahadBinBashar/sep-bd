<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->database(); 
	    $this->load->model('admin_model'); 
	    $this->load->library('form_validation');
	    $this->load->helper( 'utility' );
	    $this->load->helper('url');
	    date_default_timezone_set("Asia/Dhaka");
	    //$today = date('Y-m-d');
	} 

	public function daily_collection()
	{
		echo $this->input->post('acid', true);
		//echo "<font color=red>Collected</font>";

		if (!empty($this->input->post('installments', true)) && $this->input->post('installment', true)>0) {                  

            $qnt    = $this->input->post('qnt', true);
            $asol   = $this->input->post('asol', true);
            $profit = $this->input->post('profit', true);

            $loan_id = $this->input->post('loan_id', true);
            $employee_id = get_name_by_auto_id('account_loan', $loan_id, 'employee_id');

            $data = array(
                'loan_id'        => $loan_id,
                'amount_receive' => $this->input->post('installment', true),
                'asol'           => $qnt*$asol,
                'profit'         => $qnt*$profit,
                'sts'            => 1,
                'employee_id'    => $employee_id,
                'uid'            => $_SESSION['user_id'],
                'pdate'          => date('Y-m-d'),
                'ptime'          => date('H:i:s'),
                'qnt'            => $this->input->post('qnt', true)
            );
            $query1 = $this->db->insert('loan_collection', $data);                          
        } 

        if ($this->input->post('saving', true)!='' && $this->input->post('saving', true)>0) {                 

            $ac_id = $this->input->post('ac_id', true);
            $employee_id = get_name_by_auto_id('account', $ac_id, 'employee_id');

            $data = array(
                'ac_id'          => $ac_id,
                'ac_no'          => $ac_id,
                'amount_receive' => $this->input->post('saving', true),
                'amount_return'  => 0,
                'sts'            => 1,
                'employee_id'    => $employee_id,
                'uid'            => $_SESSION['user_id'],
                'pdate'          => date('Y-m-d'),
                'ptime'          => date('H:i:s')
            );
            $query2 = $this->db->insert('saving_collection', $data);                           
        }

		
	}

	public function login()
	{

		$this->load->view('login');
	}

	public function admin_login()
	{

		if(($this->input->post('username', true)!='') && ($this->input->post('password', true)!='')){
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()){
				$username = $this->input->post('username', true);
				$password = $this->input->post('password', true);
				$results = $this->admin_model->admin_login_info($username, $password);

				if($results) {
					foreach ($results as $key => $result) {
						$_SESSION['user_id'] = $result->id;
						$_SESSION['name'] = $result->name;
						$_SESSION['mobile'] = $result->mobile;
						$_SESSION['pass'] = $result->pass;
						$_SESSION['status'] = $result->status;

						redirect(base_url('admin/dashboard'));
					}
					
				} else {
					$this->session->set_flashdata('error', 'Username or Password is incorrect.');
					$this->login();
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Type username & password.');
			$this->login();
		}
		
	}

	public function logout()
	{
		session_destroy();
		//$this->session->sess_destroy();
		$this->session->unset_userdata("username", "ppp");
		$this->session->set_flashdata('error', 'Logout Successfull.');
		$this->login();
	}

	public function forget_password()
	{
		echo "Please Contact with Software Developer. <a href='admin'>Go Login Page</a>";
		//$this->load->view('admin/forget_password');
	}

	public function dashboard()
	{
		$data['zone_list'] = $this->admin_model->zone_list();
		$data['employee_list'] = $this->admin_model->employee_list();
		$data['account_list'] = $this->admin_model->account_list();
		$this->load->view('dashboard', $data);
	}

	public function change_password()
	{
		$this->load->view('change_password');
	}

	public function employee_list()
	{
		$data['results'] = $this->admin_model->employee_list();
		$this->load->view('employee_list', $data);
	}
	public function transfer_member()
	{
		$data['results'] = $this->admin_model->employee_list();
		$this->load->view('transfer_member', $data);
	}

	public function employee_add()
	{
		$data['zone_list'] = $this->admin_model->zone_list();
		$this->load->view('employee_add', $data);
	}

	public function employee_edit()
	{
		$this->load->view('employee_edit');
	}

	public function zone_list()
	{
		$data['results'] = $this->admin_model->zone_list();
		$this->load->view('zone_list', $data);
	}

	public function zone_store()
	{
		if (!empty($this->input->post('name', true))) {                                                           
            $data = array(
                'name'    => $this->input->post('name', true),
                'sts'     => 1
            );
            $this->db->insert('zone', $data);
            if ( $this->db->affected_rows() ) {
                $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                redirect(base_url('admin/zone_list'));
            } else {
                $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                redirect($_SERVER['HTTP_REFERER']);
            }                  
        }   
    }

    public function account_list()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->account_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_account_list($employee_id);
		}
		
		$this->load->view('account_list', $data);
	}
	public function account_close($id,$emp_id)
        	{ 
        		$data = array( 
        			'sts' => 0
        		);
        		$this->db->update('account', $data, ['id' => $id]);
        		$this->session->set_flashdata('msg', '<font color=green>Closed!</font>');
        		redirect(base_url('admin/account_employee?employee_id='.$emp_id));
        
        
        	}
  public function account_list_transfar()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->account_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_account_list($employee_id);
		}
		
		$this->load->view('account_list_transfar', $data);
	}
  
  
	public function account_add()
	{
		$data['zone_list'] = $this->admin_model->zone_list();
		$data['employee_list'] = $this->admin_model->employee_list();
		$this->load->view('account_add', $data);
	}

	public function account_edit()
	{
		$data['zone_list'] = $this->admin_model->zone_list();
		$data['employee_list'] = $this->admin_model->employee_list();
		$this->load->view('account_edit', $data);
	}

	public function account_sl()
	{
		$employee_id = $_SESSION['user_id'];
		$data['results'] = $this->admin_model->employee_account_list($employee_id);
		$this->load->view('account_sl', $data);
	}

	public function account_sl_update()
	{

		foreach ($this->input->post('ss[]', true) as $key => $reports) {			
			$id = $this->input->post('id[]', true)[$key];
			$sl = $this->input->post('sl[]', true)[$key]; 
			
			$data = array( 
				'sl' => $sl
			);
			$this->db->update('account', $data, ['id' => $id]);
		}
		$this->session->set_flashdata('msg', '<font color=green>Update Success!</font>');
        redirect(base_url('admin/account_list'));

	}

	public function loan_list()
	{

		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->loan_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_loan_list($employee_id);
		}		
		$this->load->view('loan_list', $data);
	}

	public function loan_add()
	{
		$this->load->view('loan_add');
	}

	public function loan_add_old()
	{
		$this->load->view('loan_add_old');
	}

	public function loan_collection()
	{
		$data['loan_id'] = $_GET['loan_id'];
		$this->load->view('loan_collection', $data);
	}

	public function loan_collection_details()
	{
		$loan_id = $_GET['loan_id'];
		$account_id = get_name_by_auto_id('account_loan', $loan_id, 'account_id');
		$account_name = get_name_by_auto_id('account', $account_id, 'name');

		$data['loan_id'] = $loan_id;
		$data['account_name'] = $account_name;
		$this->load->view('loan_collection_details', $data);
	}

  	 public function loan_close($id)
        	{
        		$data = array( 
        			'sts' => 0
        		);
        		$this->db->update('account_loan', $data, ['id' => $id]);
        		$this->session->set_flashdata('msg', '<font color=green>Closed!</font>');
        		redirect(base_url('admin/loan_list'));
        
        
        	}
  
		public function date_add()
	{
		$this->load->view('date_add');
	}

	public function date_list()
	{
	
			$data['results'] = $this->admin_model->date_list();
	

		$this->load->view('date_list', $data);
	}

    public function ledger_add()
	{
		$this->load->view('ledger_add');
	}

	public function ledger_list()
	{
	
			$data['results'] = $this->admin_model->ledger_list();
	

		$this->load->view('ledger_list', $data);
	}
public function bs_ledger_add()
	{
		$this->load->view('bs_ledger_add');
	}

	public function bs_ledger_list()
	{
	
			$data['results'] = $this->admin_model->bs_ledger_list();
	

		$this->load->view('bs_ledger_list', $data);
	}



	
	public function diposit_list()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->diposit_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_diposit_list($employee_id);
		}

		$this->load->view('diposit_list', $data);
	}

	public function diposit_add()
	{
		$this->load->view('diposit_add');
	}

	public function diposit_collection()
	{
		
		$this->load->view('diposit_collection');
	}
	public function office_employee()
	{
		
		$this->load->view('office_employee');
	}
	
	public function dr_voucher()
	{
		
		$this->load->view('dr_voucher');
	}
	
	public function cr_voucher()
	{
		
		$this->load->view('cr_voucher');
	}

	public function diposit_return()
	{
		$this->load->view('diposit_return');
	}

public function investment_list()
	{
	
			$data['results'] = $this->admin_model->investment_list();
		

		$this->load->view('investment_list', $data);
	}

	public function investment_add()
	{
		$this->load->view('investment_add');
	}

	public function investment_collection()
	{
		
		$this->load->view('investment_collection');
	}

	public function investment_return()
	{
		$this->load->view('investment_return');
	}



	public function expense_cat()
	{
		$data['results'] = $this->admin_model->expense_cat();
		$this->load->view('expense_cat', $data);
	}

	public function expense_new()
	{
		$data['category_list'] = $this->admin_model->category_list();
		$data['expense_info'] = $this->admin_model->expense_info();
		$this->load->view('expense_new', $data);
	}

	public function expense_report()
	{
		$this->load->view('expense_report');
	}

	public function salary_pay()
	{
		$data['employee_list'] = $this->admin_model->employee_list();
		$data['salary_info'] = $this->admin_model->salary_info();
		$this->load->view('salary_pay', $data);
	}

	public function salary_editxxxxxx($salary_id)
	{
		$data['salary_id'] = $salary_id;
		$data['single_salary'] = $this->admin_model->single_salary($salary_id);
		$this->load->view('fishing/salary_edit', $data);
	}

	public function salary_detailsxxxxxxx($employee_id)
	{
		$data['employee_id'] = $employee_id;
		$data['employee_salary'] = $this->admin_model->employee_salary($employee_id);
		$this->load->view('fishing/salary_details', $data);
	}

	public function salary_report()
	{
		$this->load->view('salary_report');
	}

	public function saving_collection()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->account_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_account_list($employee_id);
		}

		$this->load->view('saving_collection', $data);
	}

	public function collection()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->account_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_account_list($employee_id);
		}

		$this->load->view('collection', $data);
	}
	
	public function pre_collection()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->account_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_account_list($employee_id);
		}

		$this->load->view('pre_collection', $data);
	}


	public function collection_report_user()
	{
		$this->load->view('collection_report_user');
	}

	public function collection_report_employee()
	{
		$this->load->view('collection_report_employee');
	}

	public function old_collection()
	{
		if ($_SESSION['status']=='a') {
			$data['results'] = $this->admin_model->account_list();
		} elseif ($_SESSION['status']=='u') {
			$employee_id = $_SESSION['user_id'];
			$data['results'] = $this->admin_model->employee_account_list($employee_id);
		}

		$this->load->view('old_collection', $data);
	}

	public function saving_return()
	{
		$this->load->view('saving_return');
	}

	public function return_approved()
	{
		$this->load->view('return_approved');
	}

	public function returned_list()
	{
		$this->load->view('returned_list');
	}

	public function saving_return_confirm($id,$Vno)
	{
		$data = array( 
			'sts' => 1
		);
		$this->db->update('saving_collection', $data, ['id' => $id]);
		
		$vdata = array( 
			'IsAppove' => 1
		);
		$this->db->update('acc_transaction', $vdata, ['Vno' => $Vno]);
		$this->session->set_flashdata('msg', '<font color=green>Approved!</font>');
		redirect(base_url('admin/pending_return_list'));


	}
	public function saving_return_reject($id)
        	{
        		$data = array( 
        			'sts' => 3
        		);
        		$this->db->update('saving_collection', $data, ['id' => $id]);
        		$this->session->set_flashdata('msg', '<font color=green>Approved!</font>');
        		redirect(base_url('admin/pending_return_list'));
        
        
        	}
        	
    public function date_confirm($id)
	{
		$data = array( 
			'sts' => 1
		);
		$this->db->update('admin_selected_date', $data, ['id' => $id]);
		$this->session->set_flashdata('msg', '<font color=green>Active!</font>');
		redirect(base_url('admin/date_list'));


	}
	
	public function date_reject($id)
        	{
        		$data = array( 
        			'sts' => 0
        		);
        		$this->db->update('admin_selected_date', $data, ['id' => $id]);
        		$this->session->set_flashdata('msg', '<font color=red>disable!</font>');
        		redirect(base_url('admin/date_list'));
        
        
        	}              
		
    
    public function transfer_confirm()
        	{
        	    $emp    = 15;
        	    if (!empty($this->input->post('checkbox'))) {
       
             $a=implode(",",$this->input->post('checkbox'));
             
             $sql = "UPDATE account SET employee_id=$emp WHERE id IN ($a)";
             $this->db->query($sql);
             redirect(base_url('admin/transfer_member'));
         }
    }

	public function account_employee()
	{
		$this->load->view('account_employee');
	}
    public function transfermember_list_emp()
	{
		$this->load->view('transfermember_list_emp');
	}

	public function collection_confirm()
	{                
		foreach ($this->input->post('xx[]', true) as $key => $reports) {			
			
			$installment = $this->input->post('installment[]', true)[$key];			
			if (!empty($installment) && $installment>0) {                  
                $qnt    = $this->input->post('qnt[]', true)[$key];
                $asol   = $this->input->post('asol[]', true)[$key];
                $profit = $this->input->post('profit[]', true)[$key];
                $loan_id = $this->input->post('loan_id[]', true)[$key];
                $time=time() + 60*60;
                
                $data = array(
                    'loan_id'        => $loan_id,
                    'amount_receive' => $installment,
                    'asol'           => $qnt*$asol,
                    'profit'         => $qnt*$profit,
                    'sts'            => 1,
                    'employee_id'    => $_SESSION['user_id'],
                    'uid'            => $_SESSION['user_id'],
                    'pdate'          => date('Y-m-d'),
                    'ptime'          => date('H:i:s'),
                    'qnt'            => $qnt
                );
                $query1 = $this->db->insert('loan_collection', $data); 
                $loan_asolCash = array(
                    
                          'VNo'            =>  $time,
                          'Vtype'          => 'AutoLoanACr',
                          'VDate'          => date('Y-m-d'),
                          'ledger_id'      =>  1,
                          'Narration'      =>  "Cash received of Loan Asol Purpose by".$_SESSION['name'],
                          'Debit'          =>  $qnt*$asol,
                          'Credit'         =>  0,
                          'IsPosted'       =>  $loan_id,
                          'CreateBy'       =>  $_SESSION['user_id'],
                          'CreateDate'     =>  date('Y-m-d H:i:s'),
                          'IsAppove'       =>  1
                        ); 
                        $query =$this->db->insert('acc_transaction',$loan_asolCash); 
                        $loan_asol = array(
                          'VNo'            =>  $time,
                          'Vtype'          => 'AutoLoanACr',
                          'VDate'          => date('Y-m-d'),
                          'ledger_id'      =>  53,
                          'Narration'      =>  "Cash received of Loan Asol Purpose by".$_SESSION['name'],
                          'Debit'          =>  0,
                          'Credit'         =>  $qnt*$asol,
                          'IsPosted'       =>  $loan_id,
                          'CreateBy'       =>  $_SESSION['user_id'],
                          'CreateDate'     =>  date('Y-m-d H:i:s'),
                          'IsAppove'       =>  1
                        ); 
                        $query =$this->db->insert('acc_transaction',$loan_asol);
                        
                        $loan_profitCash = array(
                    
                          'VNo'            =>  $time,
                          'Vtype'          => 'AutoLoanPCr',
                          'VDate'          => date('Y-m-d'),
                          'ledger_id'      =>  1,
                          'Narration'      =>  "Cash received of Loan Profit Purpose by".$_SESSION['name'],
                          'Debit'          =>  $qnt*$profit,
                          'Credit'         =>  0,
                          'IsPosted'       =>  $loan_id,
                          'CreateBy'       =>  $_SESSION['user_id'],
                          'CreateDate'     =>  date('Y-m-d H:i:s'),
                          'IsAppove'       =>  1
                        ); 
                        $query =$this->db->insert('acc_transaction',$loan_profitCash); 
                        $loan_profit = array(
                          'VNo'            =>  $time,
                          'Vtype'          => 'AutoLoanPCr',
                          'VDate'          => date('Y-m-d'),
                          'ledger_id'      =>  31,
                          'Narration'      =>  "Cash received of Loan Profit Purpose by".$_SESSION['name'],
                          'Debit'          =>  0,
                          'Credit'         =>  $qnt*$profit,
                          'IsPosted'       =>  $loan_id,
                          'CreateBy'       =>  $_SESSION['user_id'],
                          'CreateDate'     =>  date('Y-m-d H:i:s'),
                          'IsAppove'       =>  1
                        ); 
                        $query =$this->db->insert('acc_transaction',$loan_profit);
            } 
        }

        foreach ($this->input->post('zz[]', true) as $key => $reports) {
            $saving = $this->input->post('saving[]', true)[$key];
            if (!empty($saving) && $saving>0) {               
                $ac_id = $this->input->post('ac_id[]', true)[$key];
                 $time=time() + 60*60;
                     
                $data = array(
                    'ac_id'          => $ac_id,
                    'ac_no'          => $ac_id,
                    'amount_receive' => $saving,
                    'amount_return'  => 0,
                    'sts'            => 1,
                    'employee_id'    => $_SESSION['user_id'],
                    'uid'            => $_SESSION['user_id'],
                    'pdate'          => date('Y-m-d'),
                    'ptime'          => date('H:i:s')
                );
                $query2 = $this->db->insert('saving_collection', $data);
                
                $savingDCash = array(
                    
                          'VNo'            =>  $time,
                          'Vtype'          => 'AutoLoanPCr',
                          'VDate'          => date('Y-m-d'),
                          'ledger_id'      =>  1,
                          'Narration'      =>  "Cash received of Saving Deposit Purpose by".$_SESSION['name'],
                          'Debit'          =>  $saving,
                          'Credit'         =>  0,
                          'IsPosted'       =>  $ac_id,
                          'CreateBy'       =>  $_SESSION['user_id'],
                          'CreateDate'     =>  date('Y-m-d H:i:s'),
                          'IsAppove'       =>  1
                        ); 
                        $query =$this->db->insert('acc_transaction',$savingDCash); 
                        $savingD = array(
                          'VNo'            =>  $time,
                          'Vtype'          => 'AutoLoanPCr',
                          'VDate'          => date('Y-m-d'),
                          'ledger_id'      =>  26,
                          'Narration'      =>  "Cash received of Saving Deposit Purpose by".$_SESSION['name'],
                          'Debit'          =>  0,
                          'Credit'         =>  $saving,
                          'IsPosted'       =>  $ac_id,
                          'CreateBy'       =>  $_SESSION['user_id'],
                          'CreateDate'     =>  date('Y-m-d H:i:s'),
                          'IsAppove'       =>  1
                        ); 
                        $query =$this->db->insert('acc_transaction',$savingD);
            } 	
		}
		$this->session->set_flashdata('msg', '<font color=green>Update Success!</font>');
        redirect(base_url('admin/collection'));

		//$this->load->view('account_employee');
	}

	public function pre_collection_confirm()
	{
      $pre_date=0;
      $querycc = $this
                                                     ->db
                                                     ->select('*')
                                                     ->from('admin_selected_date')
                                                     ->where('sts', 1)
                                                     ->get();
                                             
                                                 foreach ($querycc->result() as $keycc => $valuecc)
                                                 {
                                                   
                                                    $pre_date=$valuecc->date;
                                                    $employee_id=$valuecc->employee_id;
                                                   
                                                 }
      
      if($pre_date==$this->input->post('date', true) && $_SESSION['user_id']==$employee_id){
      
      
      
      if($this->input->post('date', false)){

      
      
		foreach ($this->input->post('xx[]', true) as $key => $reports) {			
			
			$installment = $this->input->post('installment[]', true)[$key];			
			if (!empty($installment) && $installment>0) {  
                $date = $this->input->post('date', true);
                $qnt    = $this->input->post('qnt[]', true)[$key];
                $asol   = $this->input->post('asol[]', true)[$key];
                $profit = $this->input->post('profit[]', true)[$key];
                $loan_id = $this->input->post('loan_id[]', true)[$key];
                $data = array(
                    'loan_id'        => $loan_id,
                    'amount_receive' => $installment,
                    'asol'           => $qnt*$asol,
                    'profit'         => $qnt*$profit,
                    'sts'            => 1,
                    'employee_id'    => $_SESSION['user_id'],
                    'uid'            => $_SESSION['user_id'],
                    'pdate'          => $date,
                    'ptime'          => '16:26:47',
                    'qnt'            => $qnt
                );
                $query1 = $this->db->insert('loan_collection', $data);                          
            } 
        }

        foreach ($this->input->post('zz[]', true) as $key => $reports) {
            $saving = $this->input->post('saving[]', true)[$key];
            if (!empty($saving) && $saving>0) {               
                $ac_id = $this->input->post('ac_id[]', true)[$key];
                $date = $this->input->post('date', true);
                $data = array(
                    'ac_id'          => $ac_id,
                    'ac_no'          => $ac_id,
                    'amount_receive' => $saving,
                    'amount_return'  => 0,
                    'sts'            => 1,
                    'employee_id'    => $_SESSION['user_id'],
                    'uid'            => $_SESSION['user_id'],
                    'pdate'          => $date,
                    'ptime'          => '16:26:47'
                );
                $query2 = $this->db->insert('saving_collection', $data);                           
            } 	
		}
		$this->session->set_flashdata('msg', '<font color=green>Update Success!</font>');
        redirect(base_url('admin/pre_collection'));
		}
		$this->session->set_flashdata('msg', '<font color=red>Please contact with your admin!</font>');
        redirect(base_url('admin/pre_collection'));
        }
      $this->session->set_flashdata('msg', '<font color=red>Please Do not try again!</font>');
        redirect(base_url('admin/pre_collection'));
	}



	public function account_details($id)
	{
		$data['id'] = $id;
		$this->load->view('account_details', $data);
	}

	public function total_collection_report()
	{
		$this->load->view('total_collection_report');
	}
		public function emp_total_collection_report()
	{
		$this->load->view('emp_total_collection_report');
	}
	public function cash_book()
	{
		$this->load->view('cash_book');
	}
	public function general_ledger()
	{
		$this->load->view('general_ledger');
	}
		public function trial_balance()
	{
		$this->load->view('trial_balance');
	}
		public function inc_exp()
	{
		$this->load->view('inc_exp');
	}
	public function balance_sheet()
	{
		$this->load->view('balance_sheet');
	}
	public function pending_return_list()
	{
		$this->load->view('pending_return_list');
	}
	



//=======================================================================================

	public function student()
	{
		$data['results'] = $this->admin_model->student_info();
		$this->load->view('admin/student', $data);
	}

	public function student_add()
	{
		$data['courses'] = $this->admin_model->course_info();
		$this->load->view('admin/student_add', $data);
	}

	public function student_submit()
	{
		if($this->input->post('name', true)!='') {
			
			$this->form_validation->set_rules('name','Name','required');
			if($this->form_validation->run()){
				$data = array(
        			
        			'name'       => $this->input->post('name', true),
        			'student_id' => $this->input->post('sid', true),
        			'mobile'     => $this->input->post('mobile', true),
        			'email'      => $this->input->post('email', true),
        			'pass'       => $pass = $this->input->post('password', true),
        			'password'   => md5($pass),
			        'sts'        => 1
				);
				$this->db->insert('student', $data);
				$data['msg'] = '<font color=green>Added Successfull.</font>';
				$data['results'] = $this->admin_model->student_info();
		        $this->load->view('admin/student', $data);
			} 
		} else {
			$data['msg'] = '<font color=red>Insert Currect Data.</font>';
			$data['results'] = $this->admin_model->student_info();
		    $this->load->view('admin/student', $data);
		}
	}

	public function student_edit()
	{
		$this->load->view('admin/student_edit');
	}

	

}
