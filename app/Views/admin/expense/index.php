<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-money-bill-wave me-2"></i>Manage Expenses</h2>
        <p class="text-muted">View, search, and manage your expenses</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="/admin/expense/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Expense
        </a>
    </div>
</div>

<!-- Search Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-search me-2"></i>Search & Filter</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="/admin/expense">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= (isset($filters['category_id']) && $filters['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" 
                           value="<?= isset($filters['description']) ? $filters['description'] : '' ?>" 
                           placeholder="Search description">
                </div>
                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" name="date_from" class="form-control" 
                           value="<?= isset($filters['date_from']) ? $filters['date_from'] : '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" name="date_to" class="form-control" 
                           value="<?= isset($filters['date_to']) ? $filters['date_to'] : '' ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="/admin/expense" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Export Button -->
<?php if (!empty($expenses)): ?>
<div class="row mb-3">
    <div class="col">
        <a href="/admin/expense/export-pdf<?= !empty($filters) ? '?' . http_build_query($filters) : '' ?>" 
           class="btn btn-success" target="_blank">
            <i class="fas fa-file-pdf me-2"></i>Export to PDF
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Expenses Table -->
<div class="card">
    <div class="card-body">
        <?php if (empty($expenses)): ?>
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No expenses found</h5>
                <p class="text-muted">Start by adding your first expense or adjust your search filters.</p>
                <a href="/admin/expense/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Expense
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th class="text-end">Amount</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expenses as $expense): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?= date('M d, Y', strtotime($expense['date'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-medium"><?= esc($expense['description']) ?></div>
                                    <small class="text-muted">
                                        Added: <?= date('M d, Y', strtotime($expense['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= esc($expense['category_name']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success">
                                        $<?= number_format($expense['amount'], 2) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="/admin/expense/edit/<?= $expense['id'] ?>" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="deleteExpense(<?= $expense['id'] ?>)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pager): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function deleteExpense(id) {
    if (confirm('Are you sure you want to delete this expense? This action cannot be undone.')) {
        window.location.href = '/admin/expense/delete/' + id;
    }
}
</script>
<?= $this->endSection() ?>