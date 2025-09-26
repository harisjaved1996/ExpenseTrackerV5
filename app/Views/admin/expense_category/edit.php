<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/expense-category">Categories</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </nav>
        <h2><i class="fas fa-edit me-2"></i>Edit Category</h2>
        <p class="text-muted">Update the category details</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Category Details</h5>
            </div>
            <div class="card-body">
                <form action="/admin/expense-category/update/<?= $category['id'] ?>" method="POST">
                    <div class="mb-4">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name', $category['name']) ?>" placeholder="Enter category name" required>
                        <?php if (isset($errors['name'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                        <div class="form-text">Enter a descriptive name for this expense category.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Category
                        </button>
                        <a href="/admin/expense-category" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="button" class="btn btn-danger ms-auto" 
                                onclick="deleteCategory(<?= $category['id'] ?>, '<?= esc($category['name']) ?>')">
                            <i class="fas fa-trash me-2"></i>Delete Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Category Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <small class="text-muted">Category ID:</small>
                        <div class="fw-medium">#<?= $category['id'] ?></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Created:</small>
                        <div class="fw-medium"><?= date('M d, Y', strtotime($category['created_at'])) ?></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Updated:</small>
                        <div class="fw-medium"><?= date('M d, Y', strtotime($category['updated_at'])) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Important Notes</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning mb-0">
                    <small>
                        <strong>Warning:</strong> Deleting this category will also delete all expenses associated with it. 
                        This action cannot be undone. Please make sure you want to proceed before deleting.
                    </small>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tags me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/admin/expense-category" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-2"></i>View All Categories
                    </a>
                    <a href="/admin/expense-category/create" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus me-2"></i>Add New Category
                    </a>
                    <a href="/admin/expense" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-money-bill-wave me-2"></i>View Expenses
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
    $('#name').focus();
});

function deleteCategory(id, name) {
    if (confirm('Are you sure you want to delete the category "' + name + '"?\n\nWARNING: This will also delete all expenses in this category. This action cannot be undone.')) {
        window.location.href = '/admin/expense-category/delete/' + id;
    }
}
</script>
<?= $this->endSection() ?>