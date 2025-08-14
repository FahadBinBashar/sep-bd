<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'employee';
    protected $allowedFields = ['name', 'mobile', 'pass', 'status', 'sts'];

    public function adminLoginInfo(string $username, string $password)
    {
        return $this->db->table($this->table)
                        ->select('*')
                        ->where('mobile', $username)
                        ->where('pass', $password)
                        ->where('sts', 1)
                        ->get()
                        ->getResult();
    }

    public function employeeList()
    {
        return $this->db->table($this->table)
                        ->select('*')
                        ->where('sts', 1)
                        ->where('status', 'u')
                        ->orderBy('id', 'ASC')
                        ->get()
                        ->getResult();
    }

    public function zoneList()
    {
        return $this->db->table('zone')
                        ->select('*')
                        ->where('sts', 1)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->getResult();
    }

    public function memberCountByEmp(int $employeeId): int
    {
        $currentDate = date('Y-m-d');

        return $this->db->table('account')
                        ->where('employee_id', $employeeId)
                        ->where('pdate <=', $currentDate)
                        ->groupStart()
                            ->where('cdate >', $currentDate)
                            ->orWhere('cdate', '0000-00-00')
                        ->groupEnd()
                        ->orderBy('pdate', 'asc')
                        ->countAllResults();
    }
}
