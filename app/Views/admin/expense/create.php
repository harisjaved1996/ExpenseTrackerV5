<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/expense">Expenses</a></li>
                <li class="breadcrumb-item active">Add New Expense</li>
            </ol>
        </nav>
        <h2><i class="fas fa-plus me-2"></i>Add New Expense</h2>
        <p class="text-muted">Fill in the details to add a new expense</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Expense Details</h5>
            </div>
            <div class="card-body">
                <form action="/admin/expense/store" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="<?= old('date', date('Y-m-d')) ?>" required>
                            <?php if (isset($errors['date'])): ?>
                                <div class="text-danger small mt-1"><?= $errors['date'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" name="amount" 
                                       step="0.01" min="0.01" value="<?= old('amount') ?>" required>
                            </div>
                            <?php if (isset($errors['amount'])): ?>
                                <div class="text-danger small mt-1"><?= $errors['amount'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="expense_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" id="expense_category_id" name="expense_category_id" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" 
                                        <?= (old('expense_category_id') == $category['id']) ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['expense_category_id'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['expense_category_id'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" 
                                  placeholder="Enter expense description..." required><?= old('description') ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['description'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Expense
                        </button>
                        <a href="/admin/expense" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use descriptive names for easy tracking
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Select the correct date of expense
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Choose appropriate category
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Enter exact amount spent
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tags me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/admin/expense" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-2"></i>View All Expenses
                    </a>
                    <a href="/admin/expense-category" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-tags me-2"></i>Manage Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Auto-focus on description field
    $('#description').focus();
    
    // Format amount input
    $('#amount').on('input', function() {
        let value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });
});
</script>
<?= $this->endSection() ?>