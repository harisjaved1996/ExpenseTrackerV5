<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/expense-category">Categories</a></li>
                <li class="breadcrumb-item active">Add New Category</li>
            </ol>
        </nav>
        <h2><i class="fas fa-plus me-2"></i>Add New Category</h2>
        <p class="text-muted">Create a new expense category</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Category Details</h5>
            </div>
            <div class="card-body">
                <form action="/admin/expense-category/store" method="POST">
                    <div class="mb-4">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= old('name') ?>" placeholder="Enter category name" required>
                        <?php if (isset($errors['name'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                        <div class="form-text">Enter a descriptive name for this expense category.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Category
                        </button>
                        <a href="/admin/expense-category" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Suggestions</h6>
            </div>
            <div class="card-body">
                <p class="small mb-3">Here are some common expense categories you might want to create:</p>
                
                <div class="row g-2">
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Food & Dining')">
                            <i class="fas fa-utensils me-1"></i> Food & Dining
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Transportation')">
                            <i class="fas fa-car me-1"></i> Transportation
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Shopping')">
                            <i class="fas fa-shopping-cart me-1"></i> Shopping
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Entertainment')">
                            <i class="fas fa-gamepad me-1"></i> Entertainment
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Bills & Utilities')">
                            <i class="fas fa-file-invoice me-1"></i> Bills & Utilities
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Healthcare')">
                            <i class="fas fa-medkit me-1"></i> Healthcare
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Travel')">
                            <i class="fas fa-plane me-1"></i> Travel
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="badge bg-light text-dark w-100 p-2 category-suggestion" 
                             onclick="fillCategory('Education')">
                            <i class="fas fa-graduation-cap me-1"></i> Education
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Click on any suggestion to fill the category name.
                    </small>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Use clear, descriptive names
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Keep categories broad enough to be useful
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Avoid creating too many similar categories
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Category names must be unique
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<style>
.category-suggestion {
    cursor: pointer;
    transition: all 0.2s;
}
.category-suggestion:hover {
    background-color: #e9ecef !important;
    transform: translateY(-1px);
}
</style>

<script>
$(document).ready(function() {
    $('#name').focus();
});

function fillCategory(categoryName) {
    $('#name').val(categoryName);
    $('#name').focus();
}
</script>
<?= $this->endSection() ?>