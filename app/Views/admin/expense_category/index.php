<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fas fa-tags me-2"></i>Expense Categories</h2>
        <p class="text-muted">Manage your expense categories</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="/admin/expense-category/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Category
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($categories)): ?>
            <div class="text-center py-4">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No categories found</h5>
                <p class="text-muted">Start by creating your first expense category.</p>
                <a href="/admin/expense-category/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">#</th>
                            <th>Category Name</th>
                            <th width="150">Created</th>
                            <th width="150">Updated</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $index => $category): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?= $category['id'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        <div>
                                            <div class="fw-medium"><?= esc($category['name']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M d, Y', strtotime($category['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M d, Y', strtotime($category['updated_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="/admin/expense-category/edit/<?= $category['id'] ?>" 
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" 
                                                onclick="deleteCategory(<?= $category['id'] ?>, '<?= esc($category['name']) ?>')" 
                                                title="Delete">
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
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function deleteCategory(id, name) {
    if (confirm('Are you sure you want to delete the category "' + name + '"?\n\nWARNING: This will also delete all expenses in this category. This action cannot be undone.')) {
        window.location.href = '/admin/expense-category/delete/' + id;
    }
}
</script>
<?= $this->endSection() ?>