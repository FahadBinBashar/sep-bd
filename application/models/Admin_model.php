<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function admin_login_info($username, $password)
    {
        $query = $this
            ->db
            ->select('*')
            ->from('employee')
            ->where('mobile', $username)->where('pass', $password)->where('sts', 1)
            ->get();
        return $query->result();
    }

    public function employee_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('employee')
            ->where('sts', 1)
            ->where('status', 'u')
            ->order_by('id', 'ASC')
            ->get();
        return $query->result();
    }

    public function zone_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('zone')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function expense_cat()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('expense_cat')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function category_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('expense_cat')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function expense_info()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('expense')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function salary_info()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('salary')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function account_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account')
            ->where('sts', 1)
            ->order_by('sl','asc')
            ->get();
        return $query->result();
    }

    public function employee_account_list($employee_id)
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account')
            ->where('sts', 1)
            ->where('employee_id', $employee_id)
            ->order_by('sl','asc')
            ->get();
        return $query->result();
    }

    public function loan_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account_loan')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function member_countByemp($id)
    {
        $currect_date = date('Y-m-d');
        $query = $this
            ->db
            ->query("select * from account where employee_id = '$id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00') order by pdate asc 			");
        return $query->num_rows();
    }
    
    public function setting_disable_date()
    {
        $this->db->where('id', '1');
        $q = $this->db->get('setting');
        /* if u r fetching one row use row_array instead of result_array*/
         return $row = $q->row_array();
    }

    public function member_listByemp($id)
    {
        $currect_date = date('Y-m-d');
        $query = $this
            ->db
            ->query("select * from account where employee_id = '$id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00') order by pdate asc 			");
        return $query->result();
    }

    public function member_loanlistByemp($id)
    {
        $currect_date = date('Y-m-d');
        $query = $this
            ->db
            ->query("select * from account_loan where account_id = '$id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00')");
        return $query->result();
    }

    public function member_loanrowsByemp($id)
    {
        $currect_date = date('Y-m-d');
        $query = $this
            ->db
            ->query("select * from account_loan where account_id = '$id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00')");
        return $query->num_rows();
    }

    public function memberComplete_qnt($id)
    {

        $this
            ->db
            ->select_sum('qnt')
            ->where('loan_id', $id)->where('sts', 1);
        $result = $this
            ->db
            ->get('loan_collection')
            ->row();
        return $result->qnt;

    }
    public function saving_balance($id)
    {
        $this
            ->db
            ->select_sum('amount_receive')
            ->where('ac_id', $id)->where('sts', 1);
        $resultrc = $this
            ->db
            ->get('saving_collection')
            ->row();
        $resultrc->amount_receive;

        $this
            ->db
            ->select_sum('amount_return')
            ->where('ac_id', $id)->where('sts', 1);
        $resultrt = $this
            ->db
            ->get('saving_collection')
            ->row();
        $resultrt->amount_return;

        return $resultrc->amount_receive - $resultrt->amount_return;
    }

    public function sum_saving_received($id)
    {

        $this
            ->db
            ->select_sum('amount_receive')
            ->where('ac_id', $id)->where('sts', 1);
        $result = $this
            ->db
            ->get('saving_collection')
            ->row();
        return $result->amount_receive;
    }

    public function sum_saving_return($id)
    {
        $this
            ->db
            ->select_sum('amount_return')
            ->where('ac_id', $id)->where('sts', 1);
        $result = $this
            ->db
            ->get('saving_collection')
            ->row();
        return $result->amount_return;
    }

    function allposts_count()
    {
        $query = $this
            ->db
            ->where('sts', 1)
            ->get('account_loan');

        return $query->num_rows();

    }

    function allpostsemp_count($employee_id)
    {
        $query = $this
            ->db
            ->where_in('sts', ['1', '2'])
            ->where('employee_id', $employee_id)->order_by('sts', 'DESC')
            ->get('account_loan');

        return $query->num_rows();

    }
    public function allpostsemp($limit, $start, $col, $dir, $employee_id)
    {
        $query = $this
            ->db
            ->where_in('sts', ['1', '2'])
            ->where('employee_id', $employee_id)->limit($limit, $start)->order_by('sts', 'DESC')
            ->get('account_loan');

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }
    }

    function allposts($limit, $start, $col, $dir)
    {
        $query = $this
            ->db
            ->where('sts', 1)
            ->limit($limit, $start)->order_by($col, $dir)->get('account_loan');

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }

    }

    function posts_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->join('account', 'account.id=account_loan.account_id')
            ->like('account_loan.id', $search)->or_like('account.id', $search)->or_like('account.name', $search)->where('account.sts', 1)
            ->where('account_loan.sts', 1)
            ->get('account_loan');

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }
    }

    function posts_search_count($search)
    {
        $query = $this
            ->db
            ->join('account', 'account.id=account_loan.account_id')
            ->like('account_loan.id', $search)->or_like('account.id', $search)->or_like('account.name', $search)->where('account.sts', 1)
            ->where('account_loan.sts', 1)
            ->get('account_loan');

        return $query->num_rows();
    }

    public function complete_qnt($id)
    {

        $cnt = 0;
        $query = $this
            ->db
            ->select('*')
            ->from('loan_collection')
            ->where('sts', 1)
            ->where('loan_id', $id)->get();
        foreach ($query->result() as $valuec)
        {
            $cnt = $cnt + $valuec->qnt;

        };
        return $cnt;
    }

    public function collected_amt($id)
    {

        $collected = 0;
        $query = $this
            ->db
            ->select('*')
            ->from('loan_collection')
            ->where('sts', 1)
            ->where('loan_id', $id)->get();
        foreach ($query->result() as $valuec)
        {
            $collected = $collected + $valuec->amount_receive;
        };
        return $collected;
    }

    public function employee_loan_list($employee_id)
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account_loan')
            ->where('sts', 1)
            ->where('employee_id', $employee_id)->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function date_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('admin_selected_date')
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function ledger_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('ledger_list')
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }
    public function bs_ledger_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('bs_ledger_list')
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function diposit_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account_diposit')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }
    public function investment_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account_investment')
            ->where('sts', 1)
            ->order_by('id', 'desc')
            ->get();
        return $query->result();
    }
    public function employee_diposit_list($employee_id)
    {
        $query = $this
            ->db
            ->select('*')
            ->from('account_diposit')
            ->where('sts', 1)
            ->where('employee_id', $employee_id)->order_by('id', 'desc')
            ->get();
        return $query->result();
    }

    public function dashboard_emp_total_saving_collection($id)
    {
        $query = $this
            ->db
            ->select('SUM(saving_collection.amount_receive) as total_saving_collection')
            ->from('account')
            ->join('saving_collection', 'account.id=saving_collection.ac_id')
            ->where('account.employee_id', $id)->where('account.sts', 1)
            ->where('saving_collection.sts', 1)
            ->get();
        return $query->row()->total_saving_collection;
    }

    public function dashboard_emp_total_saving_return($id)
    {
        $query = $this
            ->db
            ->select('SUM(saving_collection.amount_return) as total_saving_return')
            ->from('account')
            ->join('saving_collection', 'account.id=saving_collection.ac_id')
            ->where('account.employee_id', $id)->where('account.sts', 1)
            ->where('saving_collection.sts', 1)
            ->get();
        return $query->row()->total_saving_return;
    }

    public function active_member($id)
    {
        
        $query = $this
            ->db
            ->where('employee_id', $id)->where('sts', 1)
            ->get('account');

        return $query->num_rows();
    }
    
    public function printb_emp_total_saving($id)
    {
        
        $query = $this
            ->db
            ->select('SUM(saving_collection.amount_receive) as total_saving_collection, SUM(saving_collection.amount_return) as total_saving_return ')

            ->from('account')
            ->join('saving_collection', 'account.id=saving_collection.ac_id')
            ->where('account.employee_id', $id)->where('account.sts', 1)
            ->where('saving_collection.sts', 1)
            ->get();
        return ["collection" => $query->row()->total_saving_collection, "sreturn" => $query->row()->total_saving_return];
    }
    // public function printb_emp_total_loan($id)
    // {
    //     $due_profit = 0;
    //     $due_asol = 0;
    //     $totala = 0;
    //     $totalp = 0;
    //     $toady = date('Y-m-d');

    //     $query = $this
    //         ->db
    //         ->query("select id from account where employee_id = '$id' and sts = 1 order by pdate asc");
    //     foreach ($query->result() as $valuec)
    //     {

    //         $queryl = $this
    //             ->db
    //             ->query("select * from account_loan where account_id = '$valuec->id' and pdate <= '$toady' AND (cdate>'$toady' OR cdate='0000-00-00')");
    //         $total_row = $queryl->num_rows();
    //         if ($total_row > 0)
    //         {

    //             //loan Total
    //             $queryll = $this
    //                 ->db
    //                 ->query("select id, total, installment_qnt, installment_asol, installment_profit  from account_loan where account_id = '$valuec->id' and pdate <= '$toady' AND (cdate>'$toady' OR cdate='0000-00-00')");
    //             foreach ($queryll->result() as $values)
    //             {
    //                 $total_loan = $values->total;
    //                 $total_qnt = $values->installment_qnt;
    //                 $loan_id = $values->id;
    //                 $loan_asol = $values->installment_asol;
    //                 $loan_profit = $values->installment_profit;
    //             }

    //             //loan qty
    //             $cnt = 0;
    //             $queryc = $this
    //                 ->db
    //                 ->select('qnt')
    //                 ->from('loan_collection')
    //                 ->where('loan_id', $loan_id)->where('sts', 1)
    //                 ->get();
    //             foreach ($queryc->result() as $valuecc)
    //             {
    //                 $cnt = $cnt + $valuecc->qnt;
    //             }
    //             $cnt;
    //             $due_qnt = $total_qnt - $cnt;
    //             $due_asol = $due_qnt * $loan_asol;
    //             $totala = $totala + $due_asol;
    //             $due_asol = 0;
    //             $due_profit = $due_qnt * $loan_profit;
    //             $totalp = $totalp + $due_profit;
    //             $due_profit = 0;

    //         }

    //     };

    //     return ["asol" => $totala, "profit" => $totalp];

    // }
        public function printb_emp_total_loan($id)
        {
            $toady = date('Y-m-d');
        
            // Main query: Join account -> account_loan -> loan_collection
            $query = $this->db->query("
                SELECT 
                    al.id AS loan_id,
                    al.installment_qnt,
                    al.installment_asol,
                    al.installment_profit,
                    IFNULL(SUM(lc.qnt), 0) AS paid_qnt
                FROM account a
                JOIN account_loan al ON al.account_id = a.id
                LEFT JOIN loan_collection lc ON lc.loan_id = al.id AND lc.sts = 1
                WHERE a.employee_id = ?
                  AND a.sts = 1
                  AND al.pdate <= ?
                  AND (al.cdate > ? OR al.cdate = '0000-00-00')
                GROUP BY al.id, al.installment_qnt, al.installment_asol, al.installment_profit
            ", [$id, $toady, $toady]);
        
            $total_asol = 0;
            $total_profit = 0;
        
            foreach ($query->result() as $row) {
                $due_qnt = $row->installment_qnt - $row->paid_qnt;
                if ($due_qnt > 0) {
                    $total_asol += $due_qnt * $row->installment_asol;
                    $total_profit += $due_qnt * $row->installment_profit;
                }
            }
        
            return ["asol" => $total_asol, "profit" => $total_profit];
        }
    
    public function loan_details($id)
    {   
        $toady = date('Y-m-d');
        $query = $this->db->query("select id, loan_date, last_date, installment_qnt, installment_asol, installment_profit, loan_amount from account_loan where account_id = '$id' and pdate <= '$toady' AND (cdate>'$toady' OR cdate='0000-00-00')");
        if($query->row()->id != null){
            
        $loan_start_date = date("d/m/Y", strtotime($query->row()->loan_date));  
        $loan_end_date = date("d/m/Y", strtotime($query->row()->last_date)); 
        
        $cntquery = $this->db->select('SUM(qnt) as cnt')->from('loan_collection')->where('loan_id', $query->row()->id)->where('sts', 1)->get();
        
        $total_qty= $query->row()->installment_qnt;
        $due_qty=$total_qty-$cntquery->row()->cnt;
        
        $Asol=$due_qty*$query->row()->installment_asol;
        $Profit=$due_qty*$query->row()->installment_profit;
        $total_due=$Asol+$Profit;
        
        
        
        return [
                    "id"=>$query->row()->id,
                    "loan_start_date"=>$loan_start_date,
                    "loan_end_date"=>$loan_end_date,
                    "loan_amount"=>$query->row()->loan_amount,
                    "installment_qnt"=>$query->row()->installment_qnt,
                    "asol"=>$Asol,
                    "profit"=>$Profit,
                    "due_total"=>$total_due,
                    "cnt"=>$cntquery->row()->cnt,
                    "br"=>'/'
               ];
        
            
            
            
        }else{
           return '';
        }
    }
    
     public function saving_details($id)
    {   
        $query = $this->db->select('SUM(amount_receive) as amount_receive, SUM(amount_return) as amount_return')->from('saving_collection')->where('ac_id', $id)->where('sts', 1)->get();
        if($query->row()->amount_receive != null){
         $Amount_Receive    =$query->row()->amount_receive;
         $Amount_Return     =$query->row()->amount_return;   
         $Balance            =$Amount_Receive-$Amount_Return;
        return [
                    "sreceive"=>$query->row()->amount_receive,
                    "sreturn"=>$query->row()->amount_return,
                    "sbalance"=>$Balance
               ];
        
         }else{
           return '';
        }
    }
    //Start For custom date Print balance
    public function custom_active_member($id,$sdate)
    {
        
        $query = $this->db->query("select * from account where employee_id = '$id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00') order by pdate asc");
        return $query->num_rows();
    }
    public function custom_printb_emp_total_saving($id,$sdate)
    {
        $where = "(account.cdate>'$sdate' OR account.cdate='0000-00-00')";
        
        $query = $this
            ->db
            ->select('SUM(saving_collection.amount_receive) as total_saving_collection, SUM(saving_collection.amount_return) as total_saving_return ')

            ->from('account')
            ->join('saving_collection', 'account.id=saving_collection.ac_id')
            ->where('account.employee_id', $id)->where('account.pdate <=', $sdate)
            ->where($where)
            ->where('saving_collection.sts', 1)
            ->get();
        return ["collection" => $query->row()->total_saving_collection, "sreturn" => $query->row()->total_saving_return];
    }
    
    public function custom_printb_emp_total_loan($id,$sdate)
    {
        $due_profit = 0;
        $due_asol = 0;
        $totala = 0;
        $totalp = 0;
        

        $query = $this
            ->db
            ->query("select id from account where employee_id = '$id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00') order by pdate asc");
        foreach ($query->result() as $valuec)
        {

            $queryl = $this
                ->db
                ->query("select * from account_loan where account_id = '$valuec->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
            $total_row = $queryl->num_rows();
            if ($total_row > 0)
            {

                //loan Total
                $queryll = $this
                    ->db
                    ->query("select id, total, installment_qnt, installment_asol, installment_profit from account_loan where account_id = '$valuec->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                foreach ($queryll->result() as $values)
                {
                    $total_loan = $values->total;
                    $total_qnt = $values->installment_qnt;
                    $loan_id = $values->id;
                    $loan_asol = $values->installment_asol;
                    $loan_profit = $values->installment_profit;
                }

                //loan qty
                $cnt = 0;
                $queryc = $this
                    ->db
                    ->select('*')
                    ->from('loan_collection')
                    ->where('loan_id', $loan_id)->where('sts', 1)
                    ->get();
                foreach ($queryc->result() as $valuecc)
                {
                    $cnt = $cnt + $valuecc->qnt;
                }
                $cnt;
                $due_qnt = $total_qnt - $cnt;
                $due_asol = $due_qnt * $loan_asol;
                $totala = $totala + $due_asol;
                $due_asol = 0;
                $due_profit = $due_qnt * $loan_profit;
                $totalp = $totalp + $due_profit;
                $due_profit = 0;

            }

        };

        return ["asol" => $totala, "profit" => $totalp];

    

    }
    public function custom_employee_account_list($id,$sdate)
    {
        $where = "(account.cdate>'$sdate' OR account.cdate='0000-00-00')";
        $query = $this
            ->db
            ->select('*')
            ->from('account')
            ->where('account.employee_id', $id)->where('account.pdate <=', $sdate)
            ->where($where)
            ->order_by('sl', 'ASC')
            ->get();
        return $query->result();
    }
    
    public function custom_loan_details($id,$qqdate)
    {   
        $query = $this->db->query("select id, loan_date, last_date, installment_qnt, installment_asol, installment_profit, loan_amount from account_loan where account_id = '$id' and pdate <= '$qqdate' AND (cdate>'$qqdate' OR cdate='0000-00-00')");
        if($query->row()->id != null){
            
        $loan_start_date = date("d/m/Y", strtotime($query->row()->loan_date));  
        $loan_end_date = date("d/m/Y", strtotime($query->row()->last_date)); 
        $loan_id = $query->row()->id;
        $cntquery = $this->db->query("select SUM(qnt) as cnt from loan_collection where loan_id = '$loan_id' and pdate <= '$qqdate'");
        // $cntquery = $this->db
        //             ->select('SUM(qnt) as cnt')
        //             ->from('loan_collection')
        //             ->where('loan_id', $query->row()->id)
        //             ->where('sts', 1)->get();
        
        $total_qty= $query->row()->installment_qnt;
        $due_qty=$total_qty-$cntquery->row()->cnt;
        
        $Asol=$due_qty*$query->row()->installment_asol;
        $Profit=$due_qty*$query->row()->installment_profit;
        $total_due=$Asol+$Profit;
        
        
        
        return [
                    "id"=>$query->row()->id,
                    "loan_start_date"=>$loan_start_date,
                    "loan_end_date"=>$loan_end_date,
                    "loan_amount"=>$query->row()->loan_amount,
                    "installment_qnt"=>$query->row()->installment_qnt,
                    "asol"=>$Asol,
                    "profit"=>$Profit,
                    "due_total"=>$total_due,
                    "cnt"=>$cntquery->row()->cnt,
                    "br"=>'/'
               ];
        
            
            
            
        }else{
           return '';
        }
    }
    public function custom_saving_details($id,$qqdate)
    {   
        $query = $this->db->select('SUM(amount_receive) as amount_receive, SUM(amount_return) as amount_return')->from('saving_collection')->where('ac_id', $id)->where('pdate <=', $qqdate)->where('sts', 1)->get();
        if($query->row()->amount_receive != null){
         $Amount_Receive    =$query->row()->amount_receive;
         $Amount_Return     =$query->row()->amount_return;   
         $Balance            =$Amount_Receive-$Amount_Return;
        return [
                    "sreceive"=>$query->row()->amount_receive,
                    "sreturn"=>$query->row()->amount_return,
                    "sbalance"=>$Balance
               ];
        
         }else{
           return '';
        }
    }
    //End For custom date Print balance
    
    

    public function dashboard_emp_total_loan($id)
    {   $due_profit = 0;
        $totalp = 0;
        $due_asol = 0;
        $totala = 0;
        $toady = date('Y-m-d');
        
        $query = $this
            ->db
            ->query("select * from account where employee_id = '$id' and sts = 1 order by pdate asc");
        
        foreach ($query->result() as $valuec)
        {

            $queryl = $this
                ->db
                ->query("select * from account_loan where account_id = '$valuec->id' and pdate <= '$toady' AND (cdate>'$toady' OR cdate='0000-00-00')");
            $total_row = $queryl->num_rows();
            if ($total_row > 0)
            {

                //loan Total
                $queryll = $this
                    ->db
                    ->query("select * from account_loan where account_id = '$valuec->id' and pdate <= '$toady' AND (cdate>'$toady' OR cdate='0000-00-00')");
                foreach ($queryll->result() as $values)
                {
                    $total_loan = $values->total;
                    $total_qnt = $values->installment_qnt;
                    $loan_id = $values->id;
                    $loan_asol = $values->installment_asol;
                    $loan_profit = $values->installment_profit;
                }

                //loan qty
                $cnt = 0;
                $queryc = $this
                    ->db
                    ->select('*')
                    ->from('loan_collection')
                    ->where('loan_id', $loan_id)->where('sts', 1)
                    ->get();
                foreach ($queryc->result() as $valuecc)
                {
                    $cnt = $cnt + $valuecc->qnt;
                }
                $cnt;
                $due_qnt = $total_qnt - $cnt;
                $due_asol = $due_qnt * $loan_asol;

                $totala = $totala + $due_asol;
                $due_asol = 0;
                $due_profit = $due_qnt * $loan_profit;
                $totalp = $totalp + $due_profit;
                $due_profit = 0;
            }

        };
        return ["totala"=> $totala,"totalp"=> $totalp];

    }
    
     //Database Old Data Delete Oparation
    
    public function all_employee_list()
    {
        $query = $this
            ->db
            ->select('*')
            ->from('employee')
            ->where('status', 'u')
            ->order_by('id', 'ASC')
            ->get();
        return $query->result();
    }
    
    
//for APPs
    public function add_account($data){
        $this->db->insert('account', $data);
        return $this->db->insert_id(); // Return insert ID for confirmation
    }
    public function get_accounts_by_employee_id($employee_id) {
        $this->db->select('id,name'); // Select all fields or specify the fields you need
        $this->db->from('account'); // The table where accounts are stored
        $this->db->where('employee_id', $employee_id); // Filter by employee_id
        $this->db->where('sts',1);
        $query = $this->db->get();
    
            // Check if results are found
            if ($query->num_rows() > 0) {
            return $query->result(); // Return the results as an array of objects
            } else {
                return null; // No accounts found for the employee_id
            }
    }
    public function get_members_by_employee_id($employee_id) {
    // Get accounts with total saving and return aggregated
    $this->db->select('
        a.id,
        a.name,
        IFNULL(SUM(sc.amount_receive), 0) AS total_saving,
        IFNULL(SUM(sc.amount_return), 0) AS total_return,
        (IFNULL(SUM(sc.amount_receive), 0) - IFNULL(SUM(sc.amount_return), 0)) AS balance
    ');
        $this->db->from('account a');
        $this->db->join('saving_collection sc', 'sc.ac_id = a.id AND sc.sts = 1', 'left');
        $this->db->where('a.employee_id', $employee_id);
        $this->db->where('a.sts', 1);
        $this->db->group_by('a.id');
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    
    
    public function getUnclosedLoan($ac_no) {
    $this->db->where('account_id', $ac_no);
    $this->db->where('sts', 1);  // Check if the loan status is 'unclosed'
    $query = $this->db->get('account_loan');  // Assuming 'loans' is your loan table
    return $query->row();  // Return the loan if found
    }
    
    public function insertLoan($loanData){
        $this->db->insert('account_loan', $loanData);
        return $this->db->insert_id();
    }
    public function insertTransaction($transactionData){
        $this->db->insert('acc_transaction', $transactionData);
    }
    public function getLoansByEmployeeId($employeeId){
        // Start the query to get loans by employee_id
        $this->db->select('account_loan.*, account.name as member_name');
        $this->db->from('account_loan');
        $this->db->join('account', 'account.id = account_loan.account_id', 'left');  // Use left join to ensure we get loans even if there's no matching account
        $this->db->where('account_loan.employee_id', $employeeId);
        $this->db->where('account_loan.sts', 1);
    
        // Execute the query
        $query = $this->db->get();
    
        // Return the result if rows are found, otherwise return false
        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return all rows as an associative array
        } else {
            return false; // No records found
        }
    }
    
    
    public function getAccountDetails($memberId, $employeeId) {
        // Query to fetch account details based on member_id and employee_id
        $this->db->where('id', $memberId);
        $this->db->where('employee_id', $employeeId);
        $this->db->where('sts', 1);
        $query = $this->db->get('account'); // Assuming 'accounts' is the table holding account details
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function getLoansByMemberId($memberId) {
        // Query to fetch loan details based on account_id (which is the memberId in your case)
        $this->db->where('account_id', $memberId); // 'account_id' is assumed to be the field related to the member
        $this->db->where('sts', 1); // Filter by active loan status (assuming 1 means active)
        
        $query = $this->db->get('account_loan'); // 'account_loan' is assumed to be the table that stores loan details
    
        // Check if any records were found
        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return loan records as an array
        } else {
            return false; // No loan details found for this member
        }
    }





    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}


