<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExpenseCategoryModel;

class ExpenseCategory extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new ExpenseCategoryModel();
        helper(['url', 'form']);
    }

    public function index()
    {
        $pager = \Config\Services::pager();
        $perPage = 10;
        
        $total = $this->categoryModel->countAll();
        $categories = $this->categoryModel->paginate($perPage, 'default');

        $data = [
            'categories' => $categories,
            'pager' => $this->categoryModel->pager,
        ];

        return view('admin/expense_category/index', $data);
    }

    public function create()
    {
        return view('admin/expense_category/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]|is_unique[expense_category.name]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        if ($this->categoryModel->save($data)) {
            return redirect()->to('/admin/expense-category')->with('success', 'Category created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create category!');
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/expense-category')->with('error', 'Category not found!');
        }

        $data = [
            'category' => $category,
        ];

        return view('admin/expense_category/edit', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/expense-category')->with('error', 'Category not found!');
        }

        $rules = [
            'name' => "required|min_length[2]|max_length[255]|is_unique[expense_category.name,id,$id]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/expense-category')->with('success', 'Category updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update category!');
        }
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/expense-category')->with('error', 'Category not found!');
        }

        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/expense-category')->with('success', 'Category deleted successfully!');
        } else {
            return redirect()->to('/admin/expense-category')->with('error', 'Failed to delete category!');
        }
    }
}