<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table            = 'expense';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['date', 'description', 'amount', 'expense_category_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'date'                 => 'required|valid_date',
        'description'          => 'required|min_length[3]|max_length[500]',
        'amount'               => 'required|decimal|greater_than[0]',
        'expense_category_id'  => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    public function getExpensesWithCategory($limit = null, $offset = null, $filters = [])
    {
        $builder = $this->select('expense.*, expense_category.name as category_name')
                        ->join('expense_category', 'expense_category.id = expense.expense_category_id')
                        ->orderBy('expense.date', 'DESC');

        // Apply filters
        if (!empty($filters['category_id'])) {
            $builder->where('expense.expense_category_id', $filters['category_id']);
        }

        if (!empty($filters['description'])) {
            $builder->like('expense.description', $filters['description']);
        }

        if (!empty($filters['date_from'])) {
            $builder->where('expense.date >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $builder->where('expense.date <=', $filters['date_to']);
        }

        if ($limit) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    public function getTotalExpenses()
    {
        return $this->selectSum('amount')->get()->getRow()->amount ?? 0;
    }

    public function getMonthlyExpenses($year = null, $month = null)
    {
        if (!$year) $year = date('Y');
        if (!$month) $month = date('m');

        return $this->selectSum('amount')
                    ->where('YEAR(date)', $year)
                    ->where('MONTH(date)', $month)
                    ->get()->getRow()->amount ?? 0;
    }

    public function getAverageMonthlyExpense()
    {
        $result = $this->select('AVG(monthly_total) as avg_expense')
                       ->from('(SELECT SUM(amount) as monthly_total FROM expense GROUP BY YEAR(date), MONTH(date)) as monthly_expenses')
                       ->get()->getRow();

        return $result ? round($result->avg_expense, 2) : 0;
    }

    public function getCategoryExpenses($categoryId)
    {
        return $this->selectSum('amount')
                    ->where('expense_category_id', $categoryId)
                    ->get()->getRow()->amount ?? 0;
    }

    public function getCategoryMonthlyExpenses($categoryId, $year = null, $month = null)
    {
        if (!$year) $year = date('Y');
        if (!$month) $month = date('m');

        return $this->selectSum('amount')
                    ->where('expense_category_id', $categoryId)
                    ->where('YEAR(date)', $year)
                    ->where('MONTH(date)', $month)
                    ->get()->getRow()->amount ?? 0;
    }

    public function getFilteredExpensesCount($filters = [])
    {
        $builder = $this->join('expense_category', 'expense_category.id = expense.expense_category_id');

        // Apply filters
        if (!empty($filters['category_id'])) {
            $builder->where('expense.expense_category_id', $filters['category_id']);
        }

        if (!empty($filters['description'])) {
            $builder->like('expense.description', $filters['description']);
        }

        if (!empty($filters['date_from'])) {
            $builder->where('expense.date >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $builder->where('expense.date <=', $filters['date_to']);
        }

        return $builder->countAllResults();
    }
}