<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
        <p class="text-muted">Welcome to your expense tracking dashboard</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Total Expenses</h6>
                        <h3 class="mb-0">$<?= number_format($total_expenses, 2) ?></h3>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50"><?= $current_month ?></h6>
                        <h3 class="mb-0">$<?= number_format($monthly_expenses, 2) ?></h3>
                    </div>
                    <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Avg. Monthly</h6>
                        <h3 class="mb-0">$<?= number_format($average_monthly, 2) ?></h3>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Filter -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>Category Analysis
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="categoryFilter" class="form-label">Select Category</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div id="categoryResults" style="display: none;">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="mb-2">Total Expenses</h6>
                                <h4 class="text-primary" id="categoryTotal">$0.00</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <h6 class="mb-2" id="categoryMonthLabel">This Month</h6>
                                <h4 class="text-success" id="categoryMonthly">$0.00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/admin/expense/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Expense
                    </a>
                    <a href="/admin/expense" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>View All Expenses
                    </a>
                    <a href="/admin/expense-category" class="btn btn-outline-secondary">
                        <i class="fas fa-tags me-2"></i>Manage Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Expenses -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>Recent Activity
                </h5>
                <a href="/admin/expense" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <p>Recent expenses will appear here once you start adding them.</p>
                    <a href="/admin/expense/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Your First Expense
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
    $('#categoryFilter').change(function() {
        const categoryId = $(this).val();
        
        if (!categoryId) {
            $('#categoryResults').hide();
            return;
        }
        
        $.ajax({
            url: '/admin/dashboard/category-expenses',
            method: 'POST',
            data: { category_id: categoryId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#categoryTotal').text('$' + response.data.total_expenses);
                    $('#categoryMonthly').text('$' + response.data.monthly_expenses);
                    $('#categoryMonthLabel').text(response.data.current_month);
                    $('#categoryResults').show();
                } else {
                    alert('Error loading category data');
                }
            },
            error: function() {
                alert('Error loading category data');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>