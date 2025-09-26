<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExpenseModel;
use App\Models\ExpenseCategoryModel;

class Dashboard extends BaseController
{
    protected $expenseModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->expenseModel = new ExpenseModel();
        $this->categoryModel = new ExpenseCategoryModel();
        helper('url');
    }

    public function index()
    {
        // Get dashboard metrics
        $data = [
            'total_expenses' => $this->expenseModel->getTotalExpenses(),
            'monthly_expenses' => $this->expenseModel->getMonthlyExpenses(),
            'average_monthly' => $this->expenseModel->getAverageMonthlyExpense(),
            'categories' => $this->categoryModel->findAll(),
            'current_month' => date('F Y'),
        ];

        return view('admin/dashboard', $data);
    }

    public function getCategoryExpenses()
    {
        $categoryId = $this->request->getPost('category_id');
        
        if (!$categoryId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Category ID is required'
            ]);
        }

        $totalExpenses = $this->expenseModel->getCategoryExpenses($categoryId);
        $monthlyExpenses = $this->expenseModel->getCategoryMonthlyExpenses($categoryId);
        $currentMonth = date('F Y');

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'total_expenses' => number_format($totalExpenses, 2),
                'monthly_expenses' => number_format($monthlyExpenses, 2),
                'current_month' => $currentMonth
            ]
        ]);
    }
}