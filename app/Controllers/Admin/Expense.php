<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExpenseModel;
use App\Models\ExpenseCategoryModel;
// PDF functionality will be handled differently

class Expense extends BaseController
{
    protected $expenseModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->expenseModel = new ExpenseModel();
        $this->categoryModel = new ExpenseCategoryModel();
        helper(['url', 'form']);
    }

    public function index()
    {
        $pager = \Config\Services::pager();
        $perPage = 10;
        
        // Get filters from request
        $filters = [
            'category_id' => $this->request->getGet('category_id'),
            'description' => $this->request->getGet('description'),
            'date_from'   => $this->request->getGet('date_from'),
            'date_to'     => $this->request->getGet('date_to'),
        ];

        // Remove empty filters
        $filters = array_filter($filters);

        $total = $this->expenseModel->getFilteredExpensesCount($filters);
        $expenses = $this->expenseModel->getExpensesWithCategory($perPage, $pager->getCurrentPage() * $perPage - $perPage, $filters);

        $data = [
            'expenses' => $expenses,
            'categories' => $this->categoryModel->findAll(),
            'pager' => $pager->makeLinks($pager->getCurrentPage(), $perPage, $total, 'default_full'),
            'filters' => $filters,
        ];

        return view('admin/expense/index', $data);
    }

    public function create()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('admin/expense/create', $data);
    }

    public function store()
    {
        $rules = [
            'date'                => 'required|valid_date',
            'description'         => 'required|min_length[3]|max_length[500]',
            'amount'              => 'required|decimal|greater_than[0]',
            'expense_category_id' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'date'                => $this->request->getPost('date'),
            'description'         => $this->request->getPost('description'),
            'amount'              => $this->request->getPost('amount'),
            'expense_category_id' => $this->request->getPost('expense_category_id'),
        ];

        if ($this->expenseModel->save($data)) {
            return redirect()->to('/admin/expense')->with('success', 'Expense created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create expense!');
        }
    }

    public function edit($id)
    {
        $expense = $this->expenseModel->find($id);
        
        if (!$expense) {
            return redirect()->to('/admin/expense')->with('error', 'Expense not found!');
        }

        $data = [
            'expense' => $expense,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('admin/expense/edit', $data);
    }

    public function update($id)
    {
        $expense = $this->expenseModel->find($id);
        
        if (!$expense) {
            return redirect()->to('/admin/expense')->with('error', 'Expense not found!');
        }

        $rules = [
            'date'                => 'required|valid_date',
            'description'         => 'required|min_length[3]|max_length[500]',
            'amount'              => 'required|decimal|greater_than[0]',
            'expense_category_id' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'date'                => $this->request->getPost('date'),
            'description'         => $this->request->getPost('description'),
            'amount'              => $this->request->getPost('amount'),
            'expense_category_id' => $this->request->getPost('expense_category_id'),
        ];

        if ($this->expenseModel->update($id, $data)) {
            return redirect()->to('/admin/expense')->with('success', 'Expense updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update expense!');
        }
    }

    public function delete($id)
    {
        $expense = $this->expenseModel->find($id);
        
        if (!$expense) {
            return redirect()->to('/admin/expense')->with('error', 'Expense not found!');
        }

        if ($this->expenseModel->delete($id)) {
            return redirect()->to('/admin/expense')->with('success', 'Expense deleted successfully!');
        } else {
            return redirect()->to('/admin/expense')->with('error', 'Failed to delete expense!');
        }
    }

    public function exportPdf()
    {
        // Get filters from request
        $filters = [
            'category_id' => $this->request->getGet('category_id'),
            'description' => $this->request->getGet('description'),
            'date_from'   => $this->request->getGet('date_from'),
            'date_to'     => $this->request->getGet('date_to'),
        ];

        // Remove empty filters
        $filters = array_filter($filters);

        $expenses = $this->expenseModel->getExpensesWithCategory(null, null, $filters);
        $categories = $this->categoryModel->findAll();

        // Create PDF content
        $html = view('admin/expense/pdf', [
            'expenses' => $expenses,
            'categories' => $categories,
            'filters' => $filters,
        ]);

        // Generate filename
        $filename = 'expenses_report_' . date('Y-m-d_H-i-s') . '.html';

        // Set headers for download
        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($html);
    }
}