<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Admin_model'); // Load your admin model here
        $this->load->library('form_validation');
        header('Content-Type: application/json');
    }
    public function login(){
    $username = $this->input->post('username', true);
    $password = $this->input->post('password', true);

    if (empty($username) || empty($password)) {
        $response = [
            'status' => 'error',
            'message' => 'Type username & password.'
        ];
    } else {
        $results = $this->Admin_model->admin_login_info($username, $password);
        
        if ($results) {
            $response = [
                'status' => 'success',
                'data' => [
                    'user_id' => $results[0]->id,
                    'name' => $results[0]->name,
                    'mobile' => $results[0]->mobile,
                    'status' => $results[0]->status
                ],
                'message' => 'Login successful.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Username or Password is incorrect.'
            ];
        }
    }

    echo json_encode($response);
}
    public function logout(){
        // Here, you can handle session destruction or token invalidation for your API
        // For example, if you're using JWT, you would invalidate the token.
        $response = [
            'status' => 'success',
            'message' => 'Logout successful.'
        ];

        echo json_encode($response);
    }
    public function add_account(){
        // Check if request method is POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $response = array('status' => 'error', 'message' => 'Invalid request method');
            echo json_encode($response);
            return;
        }

        // Set form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('monthly_amount', 'Monthly Saving Amount', 'required|numeric');
        
        // Other validation rules for each field

        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $response = array('status' => 'error', 'message' => validation_errors());
            echo json_encode($response);
            return;
        }

        // Handle file upload
        $pic = 'pic.png'; // Default picture
        if (!empty($_FILES['pic']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = date("Y_m_d") . "_" . time() . "_" . rand(111, 999) . $_FILES['pic']['name'];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('pic')) {
                $pic_data = $this->upload->data();
                $pic = 'uploads/' . $pic_data['file_name'];
            } else {
                $response = array('status' => 'error', 'message' => $this->upload->display_errors());
                echo json_encode($response);
                return;
            }
        }

        // Prepare data array
        $data = array(
            'name'               => $this->input->post('name'),
            'father'             => $this->input->post('father'),
            'mother'             => $this->input->post('mother'),
            'mobile'             => $this->input->post('mobile'),
            'address'            => $this->input->post('address'),
            'pic'                => $pic,
            'monthly_amount'     => $this->input->post('monthly_amount'),
            'employee_id'        => $this->input->post('employee_id'),
            'zone_id'            => $this->input->post('zone_id'),
            'business_address'   => $this->input->post('business_address'),
            'nominee_name_a'     => $this->input->post('nominee_name_a'),
            'nominee_co_a'       => $this->input->post('nominee_co_a'),
            'nominee_age_a'      => $this->input->post('nominee_age_a'),
            'nominee_relation_a' => $this->input->post('nominee_relation_a'),
            'nominee_value_a'    => $this->input->post('nominee_value_a'),
            'nominee_name_b'     => $this->input->post('nominee_name_b'),
            'nominee_co_b'       => $this->input->post('nominee_co_b'),
            'nominee_age_b'      => $this->input->post('nominee_age_b'),
            'nominee_relation_b' => $this->input->post('nominee_relation_b'),
            'nominee_value_b'    => $this->input->post('nominee_value_b'),
            'sts'                => 1,
            'uid'                => $this->input->post('uid'),
            'pdate'              => $this->input->post('pdate'),
            'sl'                 => $this->input->post('sl')
        );

        // Insert data into database
        $insert_id = $this->Admin_model->add_account($data);

        if ($insert_id) {
            $response = array('status' => 'success', 'message' => 'Account added successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to add account');
        }

        // Send response
        echo json_encode($response);
    }
    
    public function get_accounts_by_employee_id() {
    // Check if user is authenticated (using session or JWT)
    
    // Get the employee_id from the request (either from post or get data)
    $employee_id = $this->input->get('employee_id', true);

    if (empty($employee_id)) {
        $response = [
            'status' => 'error',
            'message' => 'Employee ID is required.'
        ];
        echo json_encode($response);
        return;
    }

    // Fetch accounts for the given employee_id
    $accounts = $this->Admin_model->get_accounts_by_employee_id($employee_id);

    if ($accounts) {
        $response = [
            'status' => 'success',
            'data' => $accounts
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No accounts found for this employee.'
        ];
    }

    echo json_encode($response);
    }
    public function get_members_by_employee_id() {
    // Check if user is authenticated (using session or JWT)
    
    // Get the employee_id from the request (either from post or get data)
    $employee_id = $this->input->get('employee_id', true);

    if (empty($employee_id)) {
        $response = [
            'status' => 'error',
            'message' => 'Employee ID is required.'
        ];
        echo json_encode($response);
        return;
    }

    // Fetch accounts for the given employee_id
    $accounts = $this->Admin_model->get_members_by_employee_id($employee_id);

    if ($accounts) {
        $response = [
            'status' => 'success',
            'data' => $accounts
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No accounts found for this employee.'
        ];
    }

    echo json_encode($response);
    }
    public function addLoan(){
    // Check if the request method is POST
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        $this->load->helper('security');
        
        // Sanitize input
        $postData = $this->security->xss_clean($this->input->post());

        // Validate required fields
        $requiredFields = ['ac_no', 'loan_amount', 'loan_date', 'interest', 'interest_amount', 'total', 'installment_qnt', 'installment_amount','installment_asol','installment_profit', 'loan_time', 'employee_id','employee_name', 'uid','unpaid_ssp_profit', 'share_hisab', 'risk_fund','admission_fee','loan_apply_fee','kalyan_tahabil'];
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
                return;
            }
        }
        
        // Check if there is any unclosed loan for this user (sts = 1)
        $existingLoan = $this->Admin_model->getUnclosedLoan($postData['ac_no']);
        if ($existingLoan) {
            echo json_encode(['status' => 'error', 'message' => 'You have an existing unclosed loan. Please close it before applying for a new loan.']);
            return;
        }


        $time = time() + 60 * 60;

        // Prepare the loan data
        $loanData = array(
            'account_id' => $postData['ac_no'],
            'ac_no' => $postData['ac_no'],
            'loan_amount' => $postData['loan_amount'],
            'loan_date' => $postData['loan_date'],
            'interest' => $postData['interest'],
            'interest_amount' => $postData['interest_amount'],
            'total' => $postData['total'],
            'installment_qnt' => $postData['installment_qnt'],
            'installment_amount' => $postData['installment_amount'],
            'installment_asol' => $postData['installment_asol'],
            'installment_profit' => $postData['installment_profit'],
            'saving_amount' => "00",
            'loan_time' => $postData['loan_time'],
            'last_date' => date('Y-m-d', strtotime("+{$postData['installment_qnt']} days", strtotime($postData['loan_date']))),
            'gr1_name' => $postData['gr1_name'],
            'gr1_mobile' => $postData['gr1_mobile'],
            'gr1_address' => $postData['gr1_address'],
            'gr1_nid' => $postData['gr1_nid'],
            'gr2_name' => $postData['gr2_name'],
            'gr2_mobile' => $postData['gr2_mobile'],
            'gr2_address' => $postData['gr2_address'],
            'gr2_nid' => $postData['gr2_nid'],
            'sts' => 2,
            'uid' => $postData['uid'],
            'pdate' => $postData['loan_date'],
            'employee_id' => $postData['employee_id'],
            'Vno' => $time,
        );

        // Insert the loan data and get the ID
        $loanId = $this->Admin_model->insertLoan($loanData);

        // If loan inserted, add transactions
        if ($loanId) {
            $transactions = [
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "Admit Fee--{$postData['employee_name']}",
                        'Debit' => $postData['admission_fee'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 32,
                        'Narration' => "Admission Fee--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['admission_fee'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "Loan Fee--{$postData['employee_name']}",
                        'Debit' => $postData['loan_apply_fee'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 40,
                        'Narration' => "Loan Fee--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['loan_apply_fee'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "Kallan tahabil--{$postData['employee_name']}",
                        'Debit' => $postData['kalyan_tahabil'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 56,
                        'Narration' => "Kallan tahabil--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['kalyan_tahabil'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "Share Hisab--{$postData['employee_name']}",
                        'Debit' => $postData['share_hisab'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 57,
                        'Narration' => "Share Hisab--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['share_hisab'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "SSP Munafa--{$postData['employee_name']}",
                        'Debit' => $postData['unpaid_ssp_profit'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 55,
                        'Narration' => "SSP Munafa--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['unpaid_ssp_profit'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "Risk Tahabil--{$postData['employee_name']}",
                        'Debit' => $postData['risk_fund'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 46,
                        'Narration' => "Risk Tahabil--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['risk_fund'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 1, // Adjust as per your DB
                        'Narration' => "Asol Hisab--{$postData['employee_name']}",
                        'Debit' => $postData['loan_amount'],
                        'Credit' => 0,
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    [
                        'VNo' => $time,
                        'Vtype' => 'AutoCr',
                        'VDate' => $postData['loan_date'],
                        'ledger_id' => 53,
                        'Narration' => "Asol Hisab--{$postData['employee_name']}",
                        'Debit' => 0,
                        'Credit' => $postData['loan_amount'],
                        'IsPosted' => $loanId,
                        'CreateBy' => $postData['employee_id'],
                        'CreateDate' => date('Y-m-d H:i:s'),
                        'IsAppove' => 2,
                    ],
                    
                    // Add more transaction rows here based on your requirements
                ];

            // Insert transactions
            foreach ($transactions as $transaction) {
                $this->Admin_model->insertTransaction($transaction);
            }

            // Send success response
            $response = [
                'status' => 'success',
                'message' => 'Loan added successfully.',
                'loan_id' => $loanId,
            ];
        } else {
            // Send error response
            $response = [
                'status' => 'error',
                'message' => 'Failed to add loan.',
            ];
        }

        echo json_encode($response);
    } else {
        show_404();
    }
}
    public function getAllLoansByEmployee(){
        // Check if the request method is GET
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            // Load security helper for input sanitization
            $this->load->helper('security');
            
            // Get the employee_id from query parameters
            $employeeId = $this->security->xss_clean($this->input->get('employee_id'));
    
            // Validate that employee_id is provided and is a number
            if (empty($employeeId) || !is_numeric($employeeId)) {
                echo json_encode(['status' => 'error', 'message' => 'Missing or invalid employee_id']);
                return;
            }
    
            // Fetch all loans by the provided employee_id
            $loans = $this->Admin_model->getLoansByEmployeeId($employeeId);
    
            if ($loans) {
                // Loan records found, return them
                $response = [
                    'status' => 'success',
                    'loan_details' => $loans,
                ];
            } else {
                // No loan records found
                $response = [
                    'status' => 'error',
                    'message' => 'No loans found for this employee.',
                ];
            }
    
            // Return the response as JSON
            echo json_encode($response);
        } else {
            // If request method is not GET, show 404 error
            show_404();
        }
    }
    public function savingReturn(){
    // Check if the request method is POST
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        // Load helper for security
        $this->load->helper('security');
        
        // Sanitize input
        $postData = $this->security->xss_clean($this->input->post());
    
        // Validate required fields
        $requiredFields = ['ac_no', 'amount_return', 'pdate', 'c_type', 'employee_id', 'employee_name'];
    
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
                return;
            }
        }
        
        // Get the post date and format it as Y-m-d
        $postDate = date('Y-m-d', strtotime($postData['pdate']));
        
        // ✅ Check if srd in settings is set to 0 (Allow backdated entry)
        $this->db->where('srd', 0);
        $query = $this->db->get('setting');
        
        if ($query->num_rows() > 0) {
            // Fetch the setting value
            $setting = $query->row();
            
            // Debugging log for the fetched setting value
            log_message('debug', 'srd value: ' . $setting->srd);
            
            // If srd is 0, backdated entries should be blocked
            if ($setting->srd == 0) {
                $currentDate = date('Y-m-d');
                
                // Check if the post date is before the current date (backdated entry)
                if ($postDate < $currentDate) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $postDate . ' Backdated saving return is not allowed when the system is configured to block it.'
                    ]);
                } else {
                    
                    
                    // Get the current timestamp and create Vno
                    $time = time() + 60 * 60;
                    $vNo = $time . $postData['ac_no'];  // Create unique transaction number
            
                    // Prepare the data for saving_collection table
                    $savingData = array(
                        'ac_id'          => $postData['ac_no'],
                        'ac_no'          => $postData['ac_no'],
                        'amount_receive' => 0,
                        'amount_return'  => $postData['amount_return'],
                        'sts'            => 2,
                        'employee_id'    => $postData['employee_id'],
                        'uid'            => $postData['employee_id'],
                        'pdate'          => $postData['pdate'],
                        'ptime'          => date("H:i:s"),
                        'Vno'            => $vNo,
                        'ctype'          => $postData['c_type']
                    );
            
                    // Insert into saving_collection table
                    $this->db->insert('saving_collection', $savingData);
                    
                    // Prepare saving return debit transaction
                    $savingReturnDebit = array(
                        'VNo'            => $vNo,
                        'Vtype'          => 'AutoSRDr',
                        'VDate'          => $postData['pdate'],
                        'ledger_id'      => 1,  // Adjust ledger_id as needed
                        'Narration'      => "সঞ্চয় ফেরত হিসাব--" . $postData['employee_name'],
                        'Debit'          => 0,
                        'Credit'         => $postData['amount_return'],
                        'IsPosted'       => $postData['ac_no'],
                        'CreateBy'       => $postData['employee_id'],
                        'CreateDate'     => date('Y-m-d H:i:s'),
                        'IsAppove'       => 2
                    );
            
                    // Insert into acc_transaction table
                    $this->db->insert('acc_transaction', $savingReturnDebit);
                    
                    // Prepare saving return credit transaction
                    $savingReturnCredit = array(
                        'VNo'            => $vNo,
                        'Vtype'          => 'AutoSRDr',
                        'VDate'          => $postData['pdate'],
                        'ledger_id'      => 26,  // Adjust ledger_id as needed
                        'Narration'      => "সঞ্চয় ফেরত হিসাব--" .$postData['employee_name'],
                        'Debit'          => $postData['amount_return'],
                        'Credit'         => 0,
                        'IsPosted'       => $postData['ac_no'],
                        'CreateBy'       => $postData['employee_id'],
                        'CreateDate'     => date('Y-m-d H:i:s'),
                        'IsAppove'       => 2
                    );
            
                    // Insert into acc_transaction table
                    $this->db->insert('acc_transaction', $savingReturnCredit);
            
                    // Check if the transactions were successful
                    if ($this->db->affected_rows() > 0) {
                        // Send a success response
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Saving return processed successfully.'
                        ]);
                    } else {
                        // Send a failure response
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Failed to process saving return.'
                        ]);
                    }
                    
                }
            } else {
                // If srd is not 0, allow backdated entries
                echo json_encode([
                    'status' => 'error',
                    'message' => 'System is not configured to allow backdated entries.'
                ]);
            }
        } else {
            // If no settings are found with srd = 0
            
                    
                    // Get the current timestamp and create Vno
                    $time = time() + 60 * 60;
                    $vNo = $time . $postData['ac_no'];  // Create unique transaction number
            
                    // Prepare the data for saving_collection table
                    $savingData = array(
                        'ac_id'          => $postData['ac_no'],
                        'ac_no'          => $postData['ac_no'],
                        'amount_receive' => 0,
                        'amount_return'  => $postData['amount_return'],
                        'sts'            => 2,
                        'employee_id'    => $postData['employee_id'],
                        'uid'            => $postData['employee_id'],
                        'pdate'          => $postData['pdate'],
                        'ptime'          => date("H:i:s"),
                        'Vno'            => $vNo,
                        'ctype'          => $postData['c_type']
                    );
            
                    // Insert into saving_collection table
                    $this->db->insert('saving_collection', $savingData);
                    
                    // Prepare saving return debit transaction
                    $savingReturnDebit = array(
                        'VNo'            => $vNo,
                        'Vtype'          => 'AutoSRDr',
                        'VDate'          => $postData['pdate'],
                        'ledger_id'      => 1,  // Adjust ledger_id as needed
                        'Narration'      => "সঞ্চয় ফেরত হিসাব--" . $postData['employee_name'],
                        'Debit'          => 0,
                        'Credit'         => $postData['amount_return'],
                        'IsPosted'       => $postData['ac_no'],
                        'CreateBy'       => $postData['employee_id'],
                        'CreateDate'     => date('Y-m-d H:i:s'),
                        'IsAppove'       => 2
                    );
            
                    // Insert into acc_transaction table
                    $this->db->insert('acc_transaction', $savingReturnDebit);
                    
                    // Prepare saving return credit transaction
                    $savingReturnCredit = array(
                        'VNo'            => $vNo,
                        'Vtype'          => 'AutoSRDr',
                        'VDate'          => $postData['pdate'],
                        'ledger_id'      => 26,  // Adjust ledger_id as needed
                        'Narration'      => "সঞ্চয় ফেরত হিসাব--" .$postData['employee_name'],
                        'Debit'          => $postData['amount_return'],
                        'Credit'         => 0,
                        'IsPosted'       => $postData['ac_no'],
                        'CreateBy'       => $postData['employee_id'],
                        'CreateDate'     => date('Y-m-d H:i:s'),
                        'IsAppove'       => 2
                    );
            
                    // Insert into acc_transaction table
                    $this->db->insert('acc_transaction', $savingReturnCredit);
            
                    // Check if the transactions were successful
                    if ($this->db->affected_rows() > 0) {
                        // Send a success response
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Saving return processed successfully.'
                        ]);
                    } else {
                        // Send a failure response
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Failed to process saving return.'
                        ]);
                    }
                    
        }
    } else {
        // If the request method is not POST, show a 404 error
        show_404();
    }
}
    public function getAllPendingSavingReturnByEmployeeId(){
        // Check if the request method is GET
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            // Sanitize input
            $employeeId = $this->input->get('employee_id', true); // Get the employee_id from the request
    
            // Validate if employee_id is not empty and is numeric
            if (empty($employeeId) || !is_numeric($employeeId)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid or missing employee_id']);
                return;
            }
    
            // Query to get saving return records along with account holder's name
            $this->db->select('sc.ac_no, sc.amount_return, sc.pdate, sc.ctype, sc.Vno, a.name as member_name'); // Ensure 'name' is correct field in 'account' table
            $this->db->from('saving_collection sc');
            $this->db->join('account a', 'sc.ac_no = a.id', 'left');  // Assuming 'ac_no' is the matching field, change if necessary
            $this->db->where('sc.employee_id', $employeeId);
            $this->db->where('sc.sts', 2);
            $this->db->order_by('sc.pdate', 'DESC'); // Optional: sort by date
    
            // Execute the query
            $query = $this->db->get();
    
            // Check if the query returns any results
            if ($query->num_rows() > 0) {
                // Fetch results
                $results = $query->result_array();
                // Return success response with data
                echo json_encode([
                    'status' => 'success',
                    'data'   => $results,
                ]);
            } else {
                // No data found for the given employee_id
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No saving return records found for this employee.',
                ]);
            }
        } else {
            // If the request method is not GET, show 404
            show_404();
        }
    }
    public function getAllApprovedSavingReturnByEmployeeId() {         
    // Check if the request method is GET
    if ($this->input->server('REQUEST_METHOD') == 'GET') {         
        // Sanitize input
        $employeeId = $this->input->get('employee_id', true); 
        
        // Validate input
        if (empty($employeeId) || !is_numeric($employeeId)) {             
            echo json_encode(['status' => 'error', 'message' => 'Invalid or missing employee_id']);             
            return;         
        }

        // Date one month ago
        $firstDayOfCurrentMonth = date('Y-m-01');
        $lastDayOfCurrentMonth = date('Y-m-t');

        // Query
        $this->db->select('sc.ac_no, sc.amount_return, sc.pdate, sc.ctype, sc.Vno, a.name as member_name');
        $this->db->from('saving_collection sc');
        $this->db->join('account a', 'sc.ac_no = a.id', 'left');
        $this->db->where('sc.employee_id', $employeeId);
        $this->db->where('sc.sts', 1);
        $this->db->where('sc.pdate >=', $firstDayOfCurrentMonth);
        $this->db->where('sc.pdate <=', $lastDayOfCurrentMonth); 
        $this->db->where('sc.amount_return >', 0); // ✅ Exclude zero return amounts
        $this->db->order_by('sc.pdate', 'DESC');
        
        // Run query
        $query = $this->db->get();

        // Response
        if ($query->num_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'data'   => $query->result_array(),
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No saving return records found for this employee in the last month with amount_return > 0.',
            ]);
        }
    } else {
        show_404();
    }
}
    public function addSSPAccount(){
    // Check if the request method is POST
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
        
        // Load helper for security
        $this->load->helper('security');
        
        // Sanitize input
        $postData = $this->security->xss_clean($this->input->post());
        
        // Validate required fields
        $requiredFields = ['name', 'mobile', 'address', 'monthly_amount', 'start_date', 'end_date', 'sts', 'employee_id'];
        
        foreach ($requiredFields as $field) {
            if (empty($postData[$field])) {
                echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
                return;
            }
        }
        
        // Prepare the data for inserting into 'account_diposit' table
        $data = array(
            'name'             => $postData['name'],
            'mobile'           => $postData['mobile'],
            'address'          => $postData['address'],
            'monthly_amount'   => $postData['monthly_amount'],
            'start_date'       => $postData['start_date'],
            'end_date'         => $postData['end_date'],
            'sts'              => 1,
            'uid'              => $postData['employee_id'],  // Assuming session stores the user ID
            'pdate'            => date("Y-m-d"),
            'employee_id'      => $postData['employee_id']
        );
        
        // Insert the data into 'account_diposit' table
        $this->db->insert('account_diposit', $data);
        
        // Check if the insert was successful
        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'SSP account added successfully.'
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to add deposit account.'
            ]);
        }
        
    } else {
        // If the request method is not POST, show 404
        show_404();
    }
}
    public function getSSPAccountByEmployeeId()
     {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $employeeId = $this->input->get('employee_id', true);
    
            if (empty($employeeId)) {
                echo json_encode(['status' => 'error', 'message' => 'Missing employee_id']);
                return;
            }
    
            // Build the query
            $this->db->select('
                ad.id,
                ad.name,
                ad.monthly_amount,
                ad.start_date,
                ad.end_date,
                IFNULL(SUM(dc.amount_receive), 0) AS total_deposit,
                IFNULL(SUM(dc.amount_return), 0) AS total_return,
                (IFNULL(SUM(dc.amount_receive), 0) - IFNULL(SUM(dc.amount_return), 0)) AS balance
            ');
            $this->db->from('account_diposit ad');
            $this->db->join('diposit_collection dc', 'dc.ac_id = ad.id AND dc.sts = 1', 'left');
            $this->db->where('ad.employee_id', $employeeId);
            $this->db->where('ad.sts', 1);
            $this->db->group_by('ad.id');
    
            $query = $this->db->get();
    
            if ($query->num_rows() > 0) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $query->result_array()
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No deposit account found for this employee.'
                ]);
            }
        } else {
            show_404();
        }
    }

    
    public function addSSPCollection()
    {
        // Check if the request method is POST
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            
            // Load helper for security
            $this->load->helper('security');
            
            // Sanitize input
            $postData = $this->security->xss_clean($this->input->post());
            
            // Validate required fields
            $requiredFields = ['ac_id', 'amount_receive', 'pdate','employee_id'];
            
            foreach ($requiredFields as $field) {
                if (empty($postData[$field])) {
                    echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
                    return;
                }
            }
            
            // Get the current timestamp and create Vno
            $time = time() + 60 * 60;
            $vNo = $time . $postData['ac_id'];  // Create unique transaction number
            
            // Prepare the data for the diposit_collection table
            $depositData = array(
                'ac_id'          => $postData['ac_id'],
                'amount_receive' => $postData['amount_receive'],
                'amount_return'  => 0,
                'sts'            => 1,  // Status (1 for active, you can adjust)
                'employee_id'    => $postData['employee_id'],
                'uid'            => $postData['employee_id'],
                'pdate'          => $postData['pdate'],
                'ptime'          => date("H:i:s"),
                'Vno'            => $vNo,
            );
    
            // Insert into diposit_collection table
            $this->db->insert('diposit_collection', $depositData);
            
            // Prepare SSP Debit entry in the acc_transaction table
            $SSPDCash = array(
                'VNo'            => $vNo,
                'Vtype'          => 'AutoSSPDC',
                'VDate'          => $postData['pdate'],
                'ledger_id'      => 1,  // Adjust ledger_id as needed
                'Narration'      => "এসএসপি হিসাব আদায়--" . $postData['employee_id'],
                'Debit'          => $postData['amount_receive'],
                'Credit'         => 0,
                'IsPosted'       => $postData['ac_id'],
                'CreateBy'       => $postData['employee_id'],
                'CreateDate'     => date('Y-m-d H:i:s'),
                'IsAppove'       => 1
            );
            
            // Insert debit entry in the acc_transaction table
            $this->db->insert('acc_transaction', $SSPDCash);
            
            // Prepare SSP Credit entry in the acc_transaction table
            $SSPD = array(
                'VNo'            => $vNo,
                'Vtype'          => 'AutoSSPDC',
                'VDate'          => $postData['pdate'],
                'ledger_id'      => 45,  // Adjust ledger_id as needed
                'Narration'      => "এসএসপি হিসাব আদায়--" . $postData['employee_id'],
                'Debit'          => 0,
                'Credit'         => $postData['amount_receive'],
                'IsPosted'       => $postData['ac_id'],
                'CreateBy'       => $postData['employee_id'],
                'CreateDate'     => date('Y-m-d H:i:s'),
                'IsAppove'       => 1
            );
            
            // Insert credit entry in the acc_transaction table
            $this->db->insert('acc_transaction', $SSPD);
            
            // Check if the transactions were successful
            if ($this->db->affected_rows() > 0) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'SSP collection added successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to add deposit collection.'
                ]);
            }
            
        } else {
            // If the request method is not POST, show 404
            show_404();
        }
    }
    
    public function getSSPCollectionByEmployeeId()
    {
        // Check if the request method is GET
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            
            // Get employee_id from GET parameters
            $employeeId = $this->input->get('employee_id', true); // Sanitize input
            
            // Validate if employee_id is provided
            if (empty($employeeId)) {
                echo json_encode(['status' => 'error', 'message' => 'Missing employee_id']);
                return;
            }
            
            // Query to fetch deposit collection data for the given employee_id
            $this->db->select('dc.ac_id, dc.amount_receive, dc.amount_return, dc.sts, dc.pdate, dc.Vno, a.name as member_name');
            $this->db->from('diposit_collection dc');
            $this->db->join('account_diposit a', 'dc.ac_id = a.id', 'left');  // Left join to get account holder's name
            $this->db->where('dc.employee_id', $employeeId);  // Filter by employee_id
            $query = $this->db->get();
            
            // Check if the query returns any results
            if ($query->num_rows() > 0) {
                // Fetch results
                $depositCollections = $query->result_array();
                
                // Return success response with data
                echo json_encode([
                    'status' => 'success',
                    'data'   => $depositCollections
                ]);
            } else {
                // No records found
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No deposit collection records found for this employee.'
                ]);
            }
        } else {
            // If the request method is not GET, show 404
            show_404();
        }
    }
    
    public function addSSPReturnCollection()
    {
        // Check if the request method is POST
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            
            // Load helper for security
            $this->load->helper('security');
            
            // Sanitize input
            $postData = $this->security->xss_clean($this->input->post());
            
            // Validate required fields
            $requiredFields = ['ac_id', 'amount_return', 'pdate', 'c_type','employee_id'];
            
            foreach ($requiredFields as $field) {
                if (empty($postData[$field])) {
                    echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
                    return;
                }
            }
            
            // Get the post date and format it as Y-m-d
            $postDate = date('Y-m-d', strtotime($postData['pdate']));
            
            // ✅ Check if srd in settings is set to 0 (Allow backdated entry)
            $this->db->where('ssprd', 0);
            $query = $this->db->get('setting');
            
            if ($query->num_rows() > 0) {
                // Fetch the setting value
                $setting = $query->row();
                
             
                // If srd is 0, backdated entries should be blocked
                if ($setting->ssprd == 0) {
                    $currentDate = date('Y-m-d');
                    
                    // Check if the post date is before the current date (backdated entry)
                    if ($postDate < $currentDate) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => $postDate . ' Backdated SSP return is not allowed when the system is configured to block it.'
                        ]);
                    } else {
                      // Get the current timestamp and create Vno
                        $time = time() + 60 * 60;
                        $vNo = $time . $postData['ac_id'];  // Create unique transaction number
                        
                        // Prepare the data for the diposit_collection table
                        $depositData = array(
                            'ac_id'          => $postData['ac_id'],
                            'amount_receive' => 0,
                            'amount_return'  => $postData['amount_return'],
                            'sts'            => 2,  // Status (2 for return)
                            'employee_id'    => $postData['employee_id'],
                            'uid'            => $postData['employee_id'],
                            'pdate'          => $postData['pdate'],
                            'ptime'          => date("H:i:s"),
                            'Vno'            => $vNo,
                            'ctype'          => $postData['c_type'],
                        );
                        
                        // Insert into diposit_collection table
                        $this->db->insert('diposit_collection', $depositData);
                        
                        // Prepare SSP Return Debit entry in the acc_transaction table
                        $sspReturnDebit = array(
                            'VNo'            => $vNo,
                            'Vtype'          => 'AutoSSPRDr',
                            'VDate'          => $postData['pdate'],
                            'ledger_id'      => 1,  // Adjust ledger_id as needed
                            'Narration'      => "এসএসপি ফেরত হিসাব--" . $postData['employee_id'], 
                            'Debit'          => 0,
                            'Credit'         => $postData['amount_return'],
                            'IsPosted'       => $postData['ac_id'],
                            'CreateBy'       => $postData['employee_id'],
                            'CreateDate'     => date('Y-m-d H:i:s'),
                            'IsAppove'       => 2
                        );
                        
                        // Insert debit entry in the acc_transaction table
                        $this->db->insert('acc_transaction', $sspReturnDebit);
                        
                        // Prepare SSP Return Credit entry in the acc_transaction table
                        $sspReturnCredit = array(
                            'VNo'            => $vNo,
                            'Vtype'          => 'AutoSRDr',
                            'VDate'          => $postData['pdate'],
                            'ledger_id'      => 45,  // Adjust ledger_id as needed
                            'Narration'      => "এসএসপি ফেরত হিসাব--" . $postData['employee_id'],
                            'Debit'          => $postData['amount_return'],
                            'Credit'         => 0,
                            'IsPosted'       => $postData['ac_id'],
                            'CreateBy'       => $postData['employee_id'],
                            'CreateDate'     => date('Y-m-d H:i:s'),
                            'IsAppove'       => 2
                        );
                        
                        // Insert credit entry in the acc_transaction table
                        $this->db->insert('acc_transaction', $sspReturnCredit);
                        
                        // Check if the transactions were successful
                        if ($this->db->affected_rows() > 0) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'SSP Return Collection added successfully.'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Failed to add SSP Return Collection.'
                            ]);
                        }
                          
                    }
                } else {
                    // If srd is not 0, allow backdated entries
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'System is not configured to allow backdated entries.'
                    ]);
                }
            } else {
                // If no settings are found with srd = 0
                $time = time() + 60 * 60;
                        $vNo = $time . $postData['ac_id'];  // Create unique transaction number
                        
                        // Prepare the data for the diposit_collection table
                        $depositData = array(
                            'ac_id'          => $postData['ac_id'],
                            'amount_receive' => 0,
                            'amount_return'  => $postData['amount_return'],
                            'sts'            => 2,  // Status (2 for return)
                            'employee_id'    => $postData['employee_id'],
                            'uid'            => $postData['employee_id'],
                            'pdate'          => $postData['pdate'],
                            'ptime'          => date("H:i:s"),
                            'Vno'            => $vNo,
                            'ctype'          => $postData['c_type'],
                        );
                        
                        // Insert into diposit_collection table
                        $this->db->insert('diposit_collection', $depositData);
                        
                        // Prepare SSP Return Debit entry in the acc_transaction table
                        $sspReturnDebit = array(
                            'VNo'            => $vNo,
                            'Vtype'          => 'AutoSSPRDr',
                            'VDate'          => $postData['pdate'],
                            'ledger_id'      => 1,  // Adjust ledger_id as needed
                            'Narration'      => "এসএসপি ফেরত হিসাব--" . $postData['employee_id'], 
                            'Debit'          => 0,
                            'Credit'         => $postData['amount_return'],
                            'IsPosted'       => $postData['ac_id'],
                            'CreateBy'       => $postData['employee_id'],
                            'CreateDate'     => date('Y-m-d H:i:s'),
                            'IsAppove'       => 2
                        );
                        
                        // Insert debit entry in the acc_transaction table
                        $this->db->insert('acc_transaction', $sspReturnDebit);
                        
                        // Prepare SSP Return Credit entry in the acc_transaction table
                        $sspReturnCredit = array(
                            'VNo'            => $vNo,
                            'Vtype'          => 'AutoSRDr',
                            'VDate'          => $postData['pdate'],
                            'ledger_id'      => 45,  // Adjust ledger_id as needed
                            'Narration'      => "এসএসপি ফেরত হিসাব--" . $postData['employee_id'],
                            'Debit'          => $postData['amount_return'],
                            'Credit'         => 0,
                            'IsPosted'       => $postData['ac_id'],
                            'CreateBy'       => $postData['employee_id'],
                            'CreateDate'     => date('Y-m-d H:i:s'),
                            'IsAppove'       => 2
                        );
                        
                        // Insert credit entry in the acc_transaction table
                        $this->db->insert('acc_transaction', $sspReturnCredit);
                        
                        // Check if the transactions were successful
                        if ($this->db->affected_rows() > 0) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'SSP Return Collection added successfully.'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Failed to add SSP Return Collection.'
                            ]);
                        }
            }
        } else {
            // If the request method is not POST, show a 404 error
            show_404();
        }
    }
    
    public function getSSPReturnCollectionsByEmployeeId()
    {
        // Check if the request method is GET
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
    
            // Sanitize input for employee_id (mandatory in this case)
            $employeeId = $this->input->get('employee_id', true); // Get employee_id from the request
            
            if (empty($employeeId)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing employee_id parameter.'
                ]);
                return;
            }
    
            // Query to get SSP return collections with status 2 and filtered by employee_id
            $this->db->select('dc.ac_id, dc.amount_return, dc.pdate, dc.Vno, dc.ctype, a.name as member_name');
            $this->db->from('diposit_collection dc');
            $this->db->join('account_diposit a', 'dc.ac_id = a.id', 'left');  // Join to get account holder details
            $this->db->where('dc.sts', 2);  // Filter by sts = 2 (SSP return status)
            $this->db->where('dc.employee_id', $employeeId);  // Filter by employee_id
    
            // Optional: You can also filter by date range if necessary
            $startDate = $this->input->get('start_date', true);  // Optional: start date filter
            $endDate = $this->input->get('end_date', true);      // Optional: end date filter
    
            if (!empty($startDate)) {
                $this->db->where('dc.pdate >=', $startDate);  // Filter by start_date if provided
            }
            if (!empty($endDate)) {
                $this->db->where('dc.pdate <=', $endDate);    // Filter by end_date if provided
            }
    
            $this->db->order_by('dc.pdate', 'DESC');  // Optional: Sort by date descending
            
            // Execute the query
            $query = $this->db->get();
    
            // Check if the query returns any results
            if ($query->num_rows() > 0) {
                // Fetch results
                $results = $query->result_array();
                // Return success response with data
                echo json_encode([
                    'status' => 'success',
                    'data'   => $results
                ]);
            } else {
                // No data found for the given employee_id and sts = 2
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No SSP return collections found for the provided employee_id with status 2.'
                ]);
            }
    
        } else {
            // If the request method is not GET, show 404
            show_404();
        }
    }
     public function getSSPApprovedReturnCollectionsByEmployeeId()
        {
            // Check if the request method is GET
            if ($this->input->server('REQUEST_METHOD') == 'GET') {
        
                // Sanitize input for employee_id (mandatory in this case)
                $employeeId = $this->input->get('employee_id', true); // Get employee_id from the request
                
                if (empty($employeeId)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Missing employee_id parameter.'
                    ]);
                    return;
                }
        
                // Get the current date and subtract one month
                $firstDayOfCurrentMonth = date('Y-m-01');
                $lastDayOfCurrentMonth = date('Y-m-t');
        
                // Query to get SSP return collections with status 1 and filtered by employee_id
                $this->db->select('dc.ac_id, dc.amount_return, dc.pdate, dc.Vno, dc.ctype, a.name as member_name');
                $this->db->from('diposit_collection dc');
                $this->db->join('account_diposit a', 'dc.ac_id = a.id', 'left');  // Join to get account holder details
                $this->db->where('dc.sts', 1);  // Filter by sts = 1 (approved status)
                $this->db->where('dc.employee_id', $employeeId);  // Filter by employee_id
        
                // Apply date range filter for the last month
                // $this->db->where('dc.pdate >=', $oneMonthAgo);  // Only include records from the last month
                $this->db->where('dc.pdate >=', $firstDayOfCurrentMonth);
                $this->db->where('dc.pdate <=', $lastDayOfCurrentMonth); 
        
                // Exclude records where amount_return is 0
                $this->db->where('dc.amount_return >', 0); // Only include records where amount_return is greater than 0
        
                // Optional: You can also filter by date range if necessary
                $startDate = $this->input->get('start_date', true);  // Optional: start date filter
                $endDate = $this->input->get('end_date', true);      // Optional: end date filter
        
                if (!empty($startDate)) {
                    $this->db->where('dc.pdate >=', $startDate);  // Filter by start_date if provided
                }
                if (!empty($endDate)) {
                    $this->db->where('dc.pdate <=', $endDate);    // Filter by end_date if provided
                }
        
                $this->db->order_by('dc.pdate', 'DESC');  // Optional: Sort by date descending
                
                // Execute the query
                $query = $this->db->get();
        
                // Check if the query returns any results
                if ($query->num_rows() > 0) {
                    // Fetch results
                    $results = $query->result_array();
                    // Return success response with data
                    echo json_encode([
                        'status' => 'success',
                        'data'   => $results
                    ]);
                } else {
                    // No data found for the given employee_id and sts = 1
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'No SSP return collections found for the provided employee_id in the last month, with amount_return > 0.'
                    ]);
                }
        
            } else {
                // If the request method is not GET, show 404
                show_404();
            }
        }
    


    public function getAccountAndLoanDetails(){
    // Check if the request method is GET
    if ($this->input->server('REQUEST_METHOD') == 'GET') {
        // Load security helper for input sanitization
        $this->load->helper('security');
        
        // Get the member_id and employee_id from query parameters
        $memberId = $this->security->xss_clean($this->input->get('member_id'));
        $employeeId = $this->security->xss_clean($this->input->get('employee_id'));

        // Validate that member_id and employee_id are provided and are numbers
        if (empty($memberId) || !is_numeric($memberId)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing or invalid member_id']);
            return;
        }

        if (empty($employeeId) || !is_numeric($employeeId)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing or invalid employee_id']);
            return;
        }

        // Fetch account details using member_id and employee_id
        $accountDetails = $this->Admin_model->getAccountDetails($memberId, $employeeId);

        // Fetch loan details using employee_id
        $loanDetails = $this->Admin_model->getLoansByMemberId($memberId);
        
        //Fetch if daily collection already exists
        // === Get Loan Collection ===
        $this->db->select('loan_collection.*, account_loan.account_id');
        $this->db->from('loan_collection');
        $this->db->join('account_loan', 'loan_collection.loan_id = account_loan.id', 'left');
        $this->db->where('account_loan.account_id', $memberId);
        $this->db->where('loan_collection.pdate', date('y-m-d'));
        $loan_result = $this->db->get()->result_array();
    
        // === Get Saving Collection ===
        $this->db->where('ac_id', $memberId);
        $this->db->where('pdate', date('y-m-d'));
        $this->db->where('amount_return', 0);
        $saving_result = $this->db->get('saving_collection')->result_array();
    
        // Check if loan collections or saving collections are empty
        $loanStatus = !empty($loan_result);
        $savingStatus = !empty($saving_result);
        
        if ($accountDetails || $loanDetails) {
            // If account and loan records are found, return them
            $response = [
                'status' => 'success',
                'account_details' => $accountDetails,
                'loan_details' => $loanDetails,
                'loan_collections' => $loan_result,
                'saving_collections' => $saving_result,
                'loan_collections_status' => $loanStatus ? 'true' : 'false',
                'saving_collections_status' => $savingStatus ? 'true' : 'false',
            ];
        } else {
            // If either account or loan records are not found
            $response = [
                'status' => 'error',
                'message' => 'No account or loan details found for this member and employee.',
            ];
        }

        // Return the response as JSON
        echo json_encode($response);
    } else {
        // If request method is not GET, show 404 error
        show_404();
    }
}
    public function getAccountAndLoanDetailsByDate(){
    // Check if the request method is GET
    if ($this->input->server('REQUEST_METHOD') == 'GET') {
        // Load security helper for input sanitization
        $this->load->helper('security');
        
        // Get the member_id and employee_id from query parameters
        $memberId = $this->security->xss_clean($this->input->get('member_id'));
        $employeeId = $this->security->xss_clean($this->input->get('employee_id'));
        $previous_date = $this->security->xss_clean($this->input->get('previous_date'));

        // Validate that member_id and employee_id are provided and are numbers
        if (empty($memberId) || !is_numeric($memberId)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing or invalid member_id']);
            return;
        }

        if (empty($employeeId) || !is_numeric($employeeId)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing or invalid employee_id']);
            return;
        }
        
        if (empty($previous_date)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing or invalid previous_date']);
            return;
        }

        // Fetch account details using member_id and employee_id
        $accountDetails = $this->Admin_model->getAccountDetails($memberId, $employeeId);

        // Fetch loan details using employee_id
        $loanDetails = $this->Admin_model->getLoansByMemberId($memberId);
        
        //Fetch if daily collection already exists
        // === Get Loan Collection ===
        $this->db->select('loan_collection.*, account_loan.account_id');
        $this->db->from('loan_collection');
        $this->db->join('account_loan', 'loan_collection.loan_id = account_loan.id', 'left');
        $this->db->where('account_loan.account_id', $memberId);
        $this->db->where('loan_collection.pdate', $previous_date);
        $loan_result = $this->db->get()->result_array();
    
        // === Get Saving Collection ===
        $this->db->where('ac_id', $memberId);
        $this->db->where('pdate', $previous_date);
        $saving_result = $this->db->get('saving_collection')->result_array();
    
        // Check if loan collections or saving collections are empty
        $loanStatus = !empty($loan_result);
        $savingStatus = !empty($saving_result);
        
        if ($accountDetails || $loanDetails) {
            // If account and loan records are found, return them
            $response = [
                'status' => 'success',
                'account_details' => $accountDetails,
                'loan_details' => $loanDetails,
                'loan_collections' => $loan_result,
                'saving_collections' => $saving_result,
                'loan_collections_status' => $loanStatus ? 'true' : 'false',
                'saving_collections_status' => $savingStatus ? 'true' : 'false',
            ];
        } else {
            // If either account or loan records are not found
            $response = [
                'status' => 'error',
                'message' => 'No account or loan details found for this member and employee.',
            ];
        }

        // Return the response as JSON
        echo json_encode($response);
    } else {
        // If request method is not GET, show 404 error
        show_404();
    }
}

//     public function collection_confirm_single()
// {
//     // Only accept POST requests
//     if ($this->input->server('REQUEST_METHOD') != 'POST') {
//         echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
//         return;
//     }

//     // Get the required POST data for loan collection
//     $loanId = $this->input->post('loan_id', true);
//     $installment = $this->input->post('installment', true);
//     $asol = $this->input->post('asol', true);
//     $profit = $this->input->post('profit', true);
//     $acId = $this->input->post('ac_id', true);
//     $acName = $this->input->post('ac_name', true);
//     $qnt = $this->input->post('qnt', true);
//     $vno = $this->input->post('Vno', true);

//     // Get the required POST data for saving collection
//     $saving = $this->input->post('saving', true);
//     $savingVno = $this->input->post('VSno', true);
//     $employee_id = $this->input->post('employee_id', true);
//     $employee_name = $this->input->post('employee_name', true);

//     // Calculate the amounts
//     $totalAsol = $asol;
//     $totalProfit = $profit;

//     // Current date and time
//     $date = date('Y-m-d');
//     $time = date('H:i:s');

//     // Handle Loan Collection if Asol > 0
//     if ($totalAsol > 0) {
//         // Insert Loan Collection Data
//         $data = [
//             'loan_id' => $loanId,
//             'amount_receive' => $installment,
//             'asol' => $totalAsol,
//             'profit' => $totalProfit,
//             'sts' => 1,
//             'employee_id' => $employee_id,
//             'uid' => $employee_id,
//             'pdate' => $date,
//             'ptime' => $time,
//             'qnt' => $qnt,
//             'Vno' => $vno
//         ];
//         $this->db->insert('loan_collection', $data);

//         // Ledger Entries - Asol Cash
//         $loanAsolCash = [
//             'VNo' => $vno,
//             'Vtype' => 'AsolCash',
//             'VDate' => $date,
//             'ledger_id' => 1,
//             'Narration' => $acName . "-আসল ঋণ হিসাব আদায়--" . $employee_name,
//             'Debit' => $totalAsol,
//             'Credit' => 0,
//             'IsPosted' => $employee_id,
//             'CreateBy' => $employee_id,
//             'CreateDate' => date('Y-m-d H:i:s'),
//             'IsAppove' => 1
//         ];
//         $this->db->insert('acc_transaction', $loanAsolCash);

//         // Ledger Entries - Asol Hisab
//         $loanAsol = [
//             'VNo' => $vno,
//             'Vtype' => 'AsolHisab',
//             'VDate' => $date,
//             'ledger_id' => 53,
//             'Narration' => $acName . "-আসল ঋণ হিসাব আদায়--" . $employee_name,
//             'Debit' => 0,
//             'Credit' => $totalAsol,
//             'IsPosted' => $employee_id,
//             'CreateBy' => $employee_id,
//             'CreateDate' => date('Y-m-d H:i:s'),
//             'IsAppove' => 1
//         ];
//         $this->db->insert('acc_transaction', $loanAsol);

//         // Handle Profit if > 0
//         if ($totalProfit > 0) {
//             // Ledger Entries - Profit Cash
//             $loanProfitCash = [
//                 'VNo' => $vno,
//                 'Vtype' => 'ProfitCash',
//                 'VDate' => $date,
//                 'ledger_id' => 1,
//                 'Narration' => $acName . "-ঋণ মুনাফা আদায়--" . $employee_name,
//                 'Debit' => $totalProfit,
//                 'Credit' => 0,
//                 'IsPosted' => $employee_id,
//                 'CreateBy' => $employee_id,
//                 'CreateDate' => date('Y-m-d H:i:s'),
//                 'IsAppove' => 1
//             ];
//             $this->db->insert('acc_transaction', $loanProfitCash);

//             // Ledger Entries - Profit Hisab
//             $loanProfit = [
//                 'VNo' => $vno,
//                 'Vtype' => 'ProfitHisab',
//                 'VDate' => $date,
//                 'ledger_id' => 31,
//                 'Narration' => $acName . "-ঋণ মুনাফা আদায়--" . $employee_name,
//                 'Debit' => 0,
//                 'Credit' => $totalProfit,
//                 'IsPosted' => $employee_id,
//                 'CreateBy' => $employee_id,
//                 'CreateDate' => date('Y-m-d H:i:s'),
//                 'IsAppove' => 1
//             ];
//             $this->db->insert('acc_transaction', $loanProfit);
//         }
//     }

//     // Handle Saving Collection if amount > 0
//     if ($saving > 0) {
//         // Insert Saving Collection Data
//         $savingData = [
//             'ac_id' => $acId,
//             'ac_no' => $acId,
//             'amount_receive' => $saving,
//             'amount_return' => 0,
//             'sts' => 1,
//             'employee_id' => $employee_id,
//             'uid' => $employee_id,
//             'pdate' => $date,
//             'ptime' => $time,
//             'VNo' => $savingVno
//         ];
//         $this->db->insert('saving_collection', $savingData);

//         // Ledger Entries - Saving Cash
//         $savingDCash = [
//             'VNo' => $savingVno,
//             'Vtype' => 'SavingCash',
//             'VDate' => $date,
//             'ledger_id' => 1,
//             'Narration' => $acName . "-সঞ্চয় হিসাব আদায়--" . $employee_name,
//             'Debit' => $saving,
//             'Credit' => 0,
//             'IsPosted' => $employee_id,
//             'CreateBy' => $employee_id,
//             'CreateDate' => date('Y-m-d H:i:s'),
//             'IsAppove' => 1
//         ];
//         $this->db->insert('acc_transaction', $savingDCash);

//         // Ledger Entries - Saving Hisab
//         $savingD = [
//             'VNo' => $savingVno,
//             'Vtype' => 'SavingHisab',
//             'VDate' => $date,
//             'ledger_id' => 26,
//             'Narration' => $acName . "-সঞ্চয় হিসাব আদায়--" . $employee_name,
//             'Debit' => 0,
//             'Credit' => $saving,
//             'IsPosted' => $employee_id,
//             'CreateBy' => $employee_id,
//             'CreateDate' => date('Y-m-d H:i:s'),
//             'IsAppove' => 1
//         ];
//         $this->db->insert('acc_transaction', $savingD);
//     }

//     // Final Response
//     echo json_encode([
//         'status' => 'success',
//         'message' => 'Collection saved successfully for applicable loan and/or saving.'
//     ]);
// }
public function collection_confirm_single()
    {
    // Only accept POST requests
    if ($this->input->server('REQUEST_METHOD') != 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        return;
    }

    // Get the required POST data for loan collection
    $loanId = $this->input->post('loan_id', true);
    $loanAmount = $this->input->post('installment', true);
    $asol = $this->input->post('asol', true);
    $profit = $this->input->post('profit', true);
    $acId = $this->input->post('ac_id', true);
    $acName = $this->input->post('ac_name', true);
    $quantity = $this->input->post('qnt', true);
    $vno = $this->input->post('Vno', true);

    // Get the required POST data for saving collection
    $saving = $this->input->post('saving', true);
    $savingVno = $this->input->post('VSno', true);
    $employee_id = $this->input->post('employee_id', true);
    $employee_name = $this->input->post('employee_name', true);

    // Check if required fields are missing
    // if (!$loanId || !$loanAmount || !$asol || !$profit || !$acId || !$acName || !$quantity || !$vno || !$employee_id || !$employee_name) {
    //     echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    //     return;
    // }

    // Calculate the amounts
    $totalAsol = $asol;
    $totalProfit = $profit;

    // Current date and time
    $date = date('Y-m-d');
    $time = date('H:i:s');

    // Start a transaction
    $this->db->trans_start();

    // Handle Loan Collection if Asol > 0
    if ($totalAsol > 0) {
        // Check if loan collection already exists
        $loanExists = $this->db->where('loan_id', $loanId)
            ->where('Vno', $vno)
            ->where('pdate', $date)
            ->get('loan_collection')
            ->num_rows();

        if ($loanExists == 0) {
            // Insert Loan Collection Data
            $loanData = [
                'loan_id' => $loanId,
                'amount_receive' => $loanAmount,
                'asol' => $totalAsol,
                'profit' => $totalProfit,
                'sts' => 1,
                'employee_id' => $employee_id,
                'uid' => $employee_id,
                'pdate' => $date,
                'ptime' => $time,
                'qnt' => $quantity,
                'Vno' => $vno
            ];
            $this->db->insert('loan_collection', $loanData);

            // Ledger Entries for Asol Cash
            $loanAsolCash = [
                'VNo' => $vno,
                'Vtype' => 'AsolCash',
                'VDate' => $date,
                'ledger_id' => 1,
                'Narration' => $acName . "-আসল ঋণ হিসাব আদায়--" . $employee_name,
                'Debit' => $totalAsol,
                'Credit' => 0,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $loanAsolCash);

            // Ledger Entries for Asol Hisab
            $loanAsol = [
                'VNo' => $vno,
                'Vtype' => 'AsolHisab',
                'VDate' => $date,
                'ledger_id' => 53,
                'Narration' => $acName . "-আসল ঋণ হিসাব আদায়--" . $employee_name,
                'Debit' => 0,
                'Credit' => $totalAsol,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $loanAsol);
            
            // Handle Profit if > 0
        if ($totalProfit > 0) {
            // Ledger Entries for Profit Cash
            $loanProfitCash = [
                'VNo' => $vno,
                'Vtype' => 'ProfitCash',
                'VDate' => $date,
                'ledger_id' => 1,
                'Narration' => $acName . "-ঋণ মুনাফা আদায়--" . $employee_name,
                'Debit' => $totalProfit,
                'Credit' => 0,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $loanProfitCash);

            // Ledger Entries for Profit Hisab
            $loanProfit = [
                'VNo' => $vno,
                'Vtype' => 'ProfitHisab',
                'VDate' => $date,
                'ledger_id' => 31,
                'Narration' => $acName . "-ঋণ মুনাফা আদায়--" . $employee_name,
                'Debit' => 0,
                'Credit' => $totalProfit,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $loanProfit);
        }
        
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Transaction already exists.']);
            $this->db->trans_complete();
            return;
        }

        
    }

    // Handle Saving Collection if amount > 0
    if ($saving > 0) {
        // Check if saving collection already exists
        $savingExists = $this->db->where('ac_id', $acId)
            ->where('pdate', $date)
             ->where('amount_receive !=', 0)
            ->get('saving_collection')
            ->num_rows();

        if ($savingExists == 0) {
            // Insert Saving Collection Data
            $savingData = [
                'ac_id' => $acId,
                'ac_no' => $acId,
                'amount_receive' => $saving,
                'amount_return' => 0,
                'sts' => 1,
                'employee_id' => $employee_id,
                'uid' => $employee_id,
                'pdate' => $date,
                'ptime' => $time,
                'VNo' => $savingVno
            ];
            $this->db->insert('saving_collection', $savingData);

            // Ledger Entries for Saving Cash
            $savingDCash = [
                'VNo' => $savingVno,
                'Vtype' => 'SavingCash',
                'VDate' => $date,
                'ledger_id' => 1,
                'Narration' => $acName . "-সঞ্চয় হিসাব আদায়--" . $employee_name,
                'Debit' => $saving,
                'Credit' => 0,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $savingDCash);

            // Ledger Entries for Saving Hisab
            $savingD = [
                'VNo' => $savingVno,
                'Vtype' => 'SavingHisab',
                'VDate' => $date,
                'ledger_id' => 26,
                'Narration' => $acName . "-সঞ্চয় হিসাব আদায়--" . $employee_name,
                'Debit' => 0,
                'Credit' => $saving,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $savingD);
        }
    }

    // Complete the transaction
    $this->db->trans_complete();

    // Final Response
    if ($this->db->trans_status() === FALSE) {
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed.']);
    } else {
        echo json_encode([
            'status' => 'success',
            'message' => 'Collection saved successfully for applicable loan and/or saving.'
        ]);
    }
}
public function collection_confirm_previous()
{
    // Only accept POST requests
    if ($this->input->server('REQUEST_METHOD') != 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        return;
    }

    $selectedDate = $this->input->post('previous_date', true); // expected format: Y-m-d

    // Get POST data
    $loanId = $this->input->post('loan_id', true);
    $installment = $this->input->post('installment', true);
    $asol = $this->input->post('asol', true);
    $profit = $this->input->post('profit', true);
    $acId = $this->input->post('ac_id', true);
    $acName = $this->input->post('ac_name', true);
    $qnt = $this->input->post('qnt', true);
    $employee_id = $this->input->post('employee_id', true);
    $employee_name = $this->input->post('employee_name', true);
    $saving = $this->input->post('saving', true);
    
    // ✅ Check if selected date and employee ID are valid
    $this->db->where('date', $selectedDate);
    $this->db->where('employee_id', $employee_id);
    $this->db->where('sts', 1);
    $query = $this->db->get('admin_selected_date');

    if ($query->num_rows() === 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Unauthorized: Date not allowed or employee not approved for this date.'
        ]);
        return;
    }
    
    
    // Calculated values
    $totalAsol = $asol;
    $totalProfit = $profit;

    // Use selected date and current time
    $date = $selectedDate;
    $time = date('H:i:s');

    // Generate VNo values
    $vno = mt_rand(100, 999) . chr(mt_rand(65, 90)) . mt_rand(1000, 9999);
    $savingVno = mt_rand(100, 999) . chr(mt_rand(65, 90)) . mt_rand(1000, 9999);

    // Handle Loan Collection if Asol > 0
    if ($totalAsol > 0) {
        // Insert Loan Collection
        $data = [
            'loan_id' => $loanId,
            'amount_receive' => $installment,
            'asol' => $totalAsol,
            'profit' => $totalProfit,
            'sts' => 1,
            'employee_id' => $employee_id,
            'uid' => $employee_id,
            'pdate' => $date,
            'ptime' => $time,
            'qnt' => $qnt,
            'Vno' => $vno
        ];
        $this->db->insert('loan_collection', $data);

        // Ledger - Asol Cash
        $loanAsolCash = [
            'VNo' => $vno,
            'Vtype' => 'AsolCash',
            'VDate' => $date,
            'ledger_id' => 1,
            'Narration' => $acName . "-আসল ঋণ হিসাব আদায়--" . $employee_name,
            'Debit' => $totalAsol,
            'Credit' => 0,
            'IsPosted' => $employee_id,
            'CreateBy' => $employee_id,
            'CreateDate' => date('Y-m-d H:i:s'),
            'IsAppove' => 1
        ];
        $this->db->insert('acc_transaction', $loanAsolCash);

        // Ledger - Asol Hisab
        $loanAsol = [
            'VNo' => $vno,
            'Vtype' => 'AsolHisab',
            'VDate' => $date,
            'ledger_id' => 53,
            'Narration' => $acName . "-আসল ঋণ হিসাব আদায়--" . $employee_name,
            'Debit' => 0,
            'Credit' => $totalAsol,
            'IsPosted' => $employee_id,
            'CreateBy' => $employee_id,
            'CreateDate' => date('Y-m-d H:i:s'),
            'IsAppove' => 1
        ];
        $this->db->insert('acc_transaction', $loanAsol);

        // Handle Profit if > 0
        if ($totalProfit > 0) {
            $loanProfitCash = [
                'VNo' => $vno,
                'Vtype' => 'ProfitCash',
                'VDate' => $date,
                'ledger_id' => 1,
                'Narration' => $acName . "-ঋণ মুনাফা আদায়--" . $employee_name,
                'Debit' => $totalProfit,
                'Credit' => 0,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $loanProfitCash);

            $loanProfit = [
                'VNo' => $vno,
                'Vtype' => 'ProfitHisab',
                'VDate' => $date,
                'ledger_id' => 31,
                'Narration' => $acName . "-ঋণ মুনাফা আদায়--" . $employee_name,
                'Debit' => 0,
                'Credit' => $totalProfit,
                'IsPosted' => $employee_id,
                'CreateBy' => $employee_id,
                'CreateDate' => date('Y-m-d H:i:s'),
                'IsAppove' => 1
            ];
            $this->db->insert('acc_transaction', $loanProfit);
        }
    }

    // Handle Saving Collection if > 0
    if ($saving > 0) {
        $savingData = [
            'ac_id' => $acId,
            'ac_no' => $acId,
            'amount_receive' => $saving,
            'amount_return' => 0,
            'sts' => 1,
            'employee_id' => $employee_id,
            'uid' => $employee_id,
            'pdate' => $date,
            'ptime' => $time,
            'VNo' => $savingVno
        ];
        $this->db->insert('saving_collection', $savingData);

        $savingDCash = [
            'VNo' => $savingVno,
            'Vtype' => 'SavingCash',
            'VDate' => $date,
            'ledger_id' => 1,
            'Narration' => $acName . "-সঞ্চয় হিসাব আদায়--" . $employee_name,
            'Debit' => $saving,
            'Credit' => 0,
            'IsPosted' => $employee_id,
            'CreateBy' => $employee_id,
            'CreateDate' => date('Y-m-d H:i:s'),
            'IsAppove' => 1
        ];
        $this->db->insert('acc_transaction', $savingDCash);

        $savingD = [
            'VNo' => $savingVno,
            'Vtype' => 'SavingHisab',
            'VDate' => $date,
            'ledger_id' => 26,
            'Narration' => $acName . "-সঞ্চয় হিসাব আদায়--" . $employee_name,
            'Debit' => 0,
            'Credit' => $saving,
            'IsPosted' => $employee_id,
            'CreateBy' => $employee_id,
            'CreateDate' => date('Y-m-d H:i:s'),
            'IsAppove' => 1
        ];
        $this->db->insert('acc_transaction', $savingD);
    }

    // Response
    echo json_encode([
        'status' => 'success',
        'message' => 'Previous date collection saved successfully.'
    ]);
}
   public function get_collection_by_member_and_date($ac_id, $date = null)
    {
        // Validate member ID
        if (empty($ac_id) || !is_numeric($ac_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or missing member ID']);
            return;
        }
    
        // Set default date to today if not provided
        if (empty($date)) {
            $date = date('Y-m-d');
        }
    
        // === Get Loan Collection ===
        $this->db->select('loan_collection.*, account_loan.account_id');
        $this->db->from('loan_collection');
        $this->db->join('account_loan', 'loan_collection.loan_id = account_loan.id', 'left');
        $this->db->where('account_loan.account_id', $ac_id);
        $this->db->where('loan_collection.pdate', $date);
        $loan_result = $this->db->get()->result_array();
    
        // === Get Saving Collection ===
        $this->db->where('ac_id', $ac_id);
        $this->db->where('pdate', $date);
        $saving_result = $this->db->get('saving_collection')->result_array();
    
        echo json_encode([
            'status' => 'success',
            'date' => $date,
            'account_id' => $ac_id,
            'loan_collections' => $loan_result,
            'saving_collections' => $saving_result
        ]);
    }
    
    public function get_collection_summary_by_employee_and_date($employee_id = null, $date = null)
    {
        // Validate parameters
        if (empty($employee_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing employee_id']);
            return;
        }
    
        if (empty($date)) {
            $date = date('Y-m-d'); // Default to today
        }
    
        // Total Loan Asol Collection
        $this->db->select_sum('asol');
        $this->db->from('loan_collection');
        $this->db->where('employee_id', $employee_id);
        $this->db->where('pdate', $date);
        $loanAsol = $this->db->get()->row()->asol ?? 0;
    
        // Total Loan Profit Collection
        $this->db->select_sum('profit');
        $this->db->from('loan_collection');
        $this->db->where('employee_id', $employee_id);
        $this->db->where('pdate', $date);
        $loanProfit = $this->db->get()->row()->profit ?? 0;
    
        // Total Saving Collection
        $this->db->select_sum('amount_receive');
        $this->db->from('saving_collection');
        $this->db->where('employee_id', $employee_id);
        $this->db->where('pdate', $date);
        $saving = $this->db->get()->row()->amount_receive ?? 0;
    
        $total = $loanAsol + $loanProfit + $saving;
    
        echo json_encode([
            'status' => 'success',
            'date' => $date,
            'employee_id' => $employee_id,
            'loan_asol' => (float)$loanAsol,
            'loan_profit' => (float)$loanProfit,
            'saving' => (float)$saving,
            'total_collection' => (float)$total
        ]);
    }
    
    public function get_employee_report($employee_id = null, $rdate = null)
    {
        if (!$employee_id || !$rdate) {
            echo json_encode(['status' => 'error', 'message' => 'employee_id and date required']);
            return;
        }
    
        // Asol Collection
        $this->db->select_sum('asol');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $asol = $this->db->get('loan_collection')->row()->asol ?? 0;
    
        // Profit Collection
        $this->db->select_sum('profit');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $profit = $this->db->get('loan_collection')->row()->profit ?? 0;
    
        $total_loan_collection = $asol + $profit;
    
        // Saving Collection and Return
        $this->db->select_sum('amount_receive');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $saving = $this->db->get('saving_collection')->row()->amount_receive ?? 0;
    
        $this->db->select_sum('amount_return');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $saving_return = $this->db->get('saving_collection')->row()->amount_return ?? 0;
    
        // Saving Return - Hand (ctype = 1)
        $this->db->select_sum('amount_return');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1, 'ctype' => 1]);
        $saving_hand_return = $this->db->get('saving_collection')->row()->amount_return ?? 0;
    
        // SSP Collection and Return
        $this->db->select_sum('amount_receive');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $ssp = $this->db->get('diposit_collection')->row()->amount_receive ?? 0;
    
        $this->db->select_sum('amount_return');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $ssp_return = $this->db->get('diposit_collection')->row()->amount_return ?? 0;
    
        // SSP Return - Hand (ctype = 1)
        $this->db->select_sum('amount_return');
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1, 'ctype' => 1]);
        $ssp_hand_return = $this->db->get('diposit_collection')->row()->amount_return ?? 0;
    
        // Service Charge
        $service_charge = 0;
        $query = $this->db->query("SELECT SUM(Credit) as Credit FROM acc_transaction WHERE VDate = '$rdate' AND ledger_id IN (32,40,51,56,55,46,57) AND IsAppove = 1 AND CreateBy = '$employee_id'");
        if ($query->num_rows() > 0) {
            $service_charge = $query->row()->Credit ?? 0;
        }
    
        // Hand Cash Return & Totals
        $hand_cash_return = $saving_hand_return + $ssp_hand_return;
        $total_collection = $total_loan_collection + $saving + $ssp + $service_charge;
        $office_cash = $total_collection - $hand_cash_return;
    
        echo json_encode([
            'status' => 'success',
            'employee_id' => $employee_id,
            'date' => $rdate,
            'asol' => (float) $asol,
            'profit' => (float) $profit,
            'total_loan_collection' => (float) $total_loan_collection,
            'saving' => (float) $saving,
            'ssp' => (float) $ssp,
            'service_charge' => (float) $service_charge,
            'total_collection' => (float) $total_collection,
            'saving_return' => (float) $saving_return,
            'ssp_return' => (float) $ssp_return,
            'office_deposit_cash' => (float) $office_cash
        ]);
    }
    
    public function get_daily_collection_report($employee_id = null, $rdate = null)
    {
        header('Content-Type: application/json');
    
        if (!$employee_id || !$rdate) {
            echo json_encode([
                'status' => 'error',
                'message' => 'employee_id and date required'
            ]);
            return;
        }
    
        // === Summary Calculations ===
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $loan_summary = $this->db->select('SUM(asol) AS asol, SUM(profit) AS profit')
            ->get('loan_collection')->row();
    
        $asol = $loan_summary->asol ?? 0;
        $profit = $loan_summary->profit ?? 0;
        $total_loan_collection = $asol + $profit;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $saving_summary = $this->db->select('SUM(amount_receive) AS receive, SUM(amount_return) AS return_total')
            ->get('saving_collection')->row();
    
        $saving = $saving_summary->receive ?? 0;
        $saving_return = $saving_summary->return_total ?? 0;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1, 'ctype' => 1]);
        $saving_hand_return = $this->db->select_sum('amount_return')->get('saving_collection')->row()->amount_return ?? 0;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $ssp_summary = $this->db->select('SUM(amount_receive) AS receive, SUM(amount_return) AS return_total')
            ->get('diposit_collection')->row();
    
        $ssp = $ssp_summary->receive ?? 0;
        $ssp_return = $ssp_summary->return_total ?? 0;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1, 'ctype' => 1]);
        $ssp_hand_return = $this->db->select_sum('amount_return')->get('diposit_collection')->row()->amount_return ?? 0;
    
        $service_charge = $this->db->query("
            SELECT SUM(Credit) AS Credit 
            FROM acc_transaction 
            WHERE VDate = ? 
              AND ledger_id IN (32,40,51,56,55,46,57) 
              AND IsAppove = 1 
              AND CreateBy = ?
        ", [$rdate, $employee_id])->row()->Credit ?? 0;
    
        $hand_cash_return = $saving_hand_return + $ssp_hand_return;
        $total_collection = $total_loan_collection + $saving + $ssp + $service_charge;
        $office_cash = $total_collection - $hand_cash_return;
    
        // === Batch Load Data for Member-wise Aggregation ===
    
        // Step 1: Load all loans for employee
        $account_loans = $this->db->select('id AS loan_id, ac_no')
            ->where(['sts' => 1])
            ->get('account_loan')->result();
    
        $loan_ac_map = [];
        foreach ($account_loans as $loan) {
            $loan_ac_map[$loan->loan_id] = $loan->ac_no;
        }
    
        // Step 2: Load all loan collections for the date
        $loan_collections = $this->db->select('loan_id, amount_receive')
            ->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])
            ->get('loan_collection')->result();
    
        $loan_data = [];
        foreach ($loan_collections as $lc) {
            $ac_no = $loan_ac_map[$lc->loan_id] ?? null;
            if (!$ac_no) continue;
            if (!isset($loan_data[$ac_no])) $loan_data[$ac_no] = 0;
            $loan_data[$ac_no] += $lc->amount_receive;
        }
    
        // Step 3: Load all savings for the date
        $saving_collections = $this->db->select('ac_no, amount_receive')
            ->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])
            ->get('saving_collection')->result();
    
        $saving_data = [];
        foreach ($saving_collections as $sc) {
            if (!isset($saving_data[$sc->ac_no])) $saving_data[$sc->ac_no] = 0;
            $saving_data[$sc->ac_no] += $sc->amount_receive;
        }
    
        // Step 4: Union account numbers with activity
        $relevant_ac_nos = array_unique(array_merge(array_keys($loan_data), array_keys($saving_data)));
    
        // Step 5: Fetch account names
        $members = [];
        if (!empty($relevant_ac_nos)) {
            $accounts = $this->db->select('id, name')
                ->where_in('id', $relevant_ac_nos)
                ->get('account')->result();
    
            foreach ($accounts as $acc) {
                $loan_amt = $loan_data[$acc->id] ?? 0;
                $saving_amt = $saving_data[$acc->id] ?? 0;
    
                $members[] = [
                    'member_id' => $acc->id,
                    'member_name' => $acc->name,
                    'loan_collection' => (float) $loan_amt,
                    'saving_collection' => (float) $saving_amt
                ];
            }
        }
    
        // === Final JSON Response ===
    
        echo json_encode([
            'status' => 'success',
            'employee_id' => $employee_id,
            'date' => $rdate,
            'asol' => (float) $asol,
            'profit' => (float) $profit,
            'total_loan_collection' => (float) $total_loan_collection,
            'saving' => (float) $saving,
            'ssp' => (float) $ssp,
            'service_charge' => (float) $service_charge,
            'total_collection' => (float) $total_collection,
            'saving_return' => (float) $saving_return,
            'ssp_return' => (float) $ssp_return,
            'office_deposit_cash' => (float) $office_cash,
            'members' => $members
        ]);
    }

    public function get_daily_collection_report_all_members($employee_id = null, $rdate = null)
    {
        header('Content-Type: application/json');
    
        if (!$employee_id || !$rdate) {
            echo json_encode([
                'status' => 'error',
                'message' => 'employee_id and date required'
            ]);
            return;
        }
    
        // === Summary Calculations ===
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $loan_summary = $this->db->select('SUM(asol) AS asol, SUM(profit) AS profit')
            ->get('loan_collection')->row();
    
        $asol = $loan_summary->asol ?? 0;
        $profit = $loan_summary->profit ?? 0;
        $total_loan_collection = $asol + $profit;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $saving_summary = $this->db->select('SUM(amount_receive) AS receive, SUM(amount_return) AS return_total')
            ->get('saving_collection')->row();
    
        $saving = $saving_summary->receive ?? 0;
        $saving_return = $saving_summary->return_total ?? 0;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1, 'ctype' => 1]);
        $saving_hand_return = $this->db->select_sum('amount_return')->get('saving_collection')->row()->amount_return ?? 0;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1]);
        $ssp_summary = $this->db->select('SUM(amount_receive) AS receive, SUM(amount_return) AS return_total')
            ->get('diposit_collection')->row();
    
        $ssp = $ssp_summary->receive ?? 0;
        $ssp_return = $ssp_summary->return_total ?? 0;
    
        $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1, 'ctype' => 1]);
        $ssp_hand_return = $this->db->select_sum('amount_return')->get('diposit_collection')->row()->amount_return ?? 0;
    
        $service_charge = $this->db->query("
            SELECT SUM(Credit) AS Credit 
            FROM acc_transaction 
            WHERE VDate = ? 
              AND ledger_id IN (32,40,51,56,55,46,57) 
              AND IsAppove = 1 
              AND CreateBy = ?
        ", [$rdate, $employee_id])->row()->Credit ?? 0;
    
        $hand_cash_return = $saving_hand_return + $ssp_hand_return;
        $total_collection = $total_loan_collection + $saving + $ssp + $service_charge;
        $office_cash = $total_collection - $hand_cash_return;
    
        // === Load all active members under the employee ===
        $this->db->select('id, name');
        $this->db->where(['employee_id' => $employee_id, 'sts' => 1]);
        $this->db->order_by('sl', 'ASC');
        $accounts = $this->db->get('account')->result();
    
        // === Load all loans and map to ac_no ===
        $account_loans = $this->db->select('id AS loan_id, ac_no')
            ->where('sts', 1)
            ->get('account_loan')->result();
    
        $loan_ac_map = [];
        foreach ($account_loans as $loan) {
            $loan_ac_map[$loan->loan_id] = $loan->ac_no;
        }
    
        // === Load loan collections of the day ===
        $loan_collections = $this->db->select('loan_id, amount_receive')
            ->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])
            ->get('loan_collection')->result();
    
        $loan_data = [];
        foreach ($loan_collections as $lc) {
            $ac_no = $loan_ac_map[$lc->loan_id] ?? null;
            if (!$ac_no) continue;
            if (!isset($loan_data[$ac_no])) $loan_data[$ac_no] = 0;
            $loan_data[$ac_no] += $lc->amount_receive;
        }
    
        // === Load saving collections of the day ===
        $saving_collections = $this->db->select('ac_no, amount_receive')
            ->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])
            ->get('saving_collection')->result();
    
        $saving_data = [];
        foreach ($saving_collections as $sc) {
            if (!isset($saving_data[$sc->ac_no])) $saving_data[$sc->ac_no] = 0;
            $saving_data[$sc->ac_no] += $sc->amount_receive;
        }
    
        // === Prepare final member-wise report ===
        $members = [];
        foreach ($accounts as $acc) {
            $members[] = [
                'member_id' => $acc->id,
                'member_name' => $acc->name,
                'loan_collection' => (float) ($loan_data[$acc->id] ?? 0),
                'saving_collection' => (float) ($saving_data[$acc->id] ?? 0)
            ];
        }
    
        echo json_encode([
            'status' => 'success',
            'employee_id' => $employee_id,
            'date' => $rdate,
            'asol' => (float) $asol,
            'profit' => (float) $profit,
            'total_loan_collection' => (float) $total_loan_collection,
            'saving' => (float) $saving,
            'ssp' => (float) $ssp,
            'service_charge' => (float) $service_charge,
            'total_collection' => (float) $total_collection,
            'saving_return' => (float) $saving_return,
            'ssp_return' => (float) $ssp_return,
            'office_deposit_cash' => (float) $office_cash,
            'members' => $members
        ]);
    }



















}
?>
