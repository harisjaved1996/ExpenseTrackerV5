<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Expenses Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-date {
            font-size: 12px;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .filters h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        .filter-label {
            font-weight: bold;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #667eea;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .amount {
            font-weight: bold;
            color: #28a745;
        }
        .summary {
            margin-top: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-label {
            font-weight: bold;
            color: #555;
        }
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
        }
        .footer {
            position: fixed;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Expense Tracker</div>
        <div class="report-title">Expenses Report</div>
        <div class="report-date">Generated on <?= date('F d, Y - H:i:s') ?></div>
    </div>

    <?php if (!empty($filters)): ?>
    <div class="filters">
        <h4>Applied Filters:</h4>
        <?php if (isset($filters['category_id'])): ?>
            <?php 
                $categoryName = 'Unknown';
                foreach ($categories as $cat) {
                    if ($cat['id'] == $filters['category_id']) {
                        $categoryName = $cat['name'];
                        break;
                    }
                }
            ?>
            <div class="filter-item">
                <span class="filter-label">Category:</span> <?= esc($categoryName) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($filters['description'])): ?>
            <div class="filter-item">
                <span class="filter-label">Description:</span> "<?= esc($filters['description']) ?>"
            </div>
        <?php endif; ?>
        
        <?php if (isset($filters['date_from'])): ?>
            <div class="filter-item">
                <span class="filter-label">From Date:</span> <?= date('M d, Y', strtotime($filters['date_from'])) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($filters['date_to'])): ?>
            <div class="filter-item">
                <span class="filter-label">To Date:</span> <?= date('M d, Y', strtotime($filters['date_to'])) ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($expenses)): ?>
        <div class="no-data">
            <h3>No expenses found</h3>
            <p>No expenses match the specified criteria.</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                $counter = 1;
                foreach ($expenses as $expense): 
                    $total += $expense['amount'];
                ?>
                    <tr>
                        <td class="text-center"><?= $counter++ ?></td>
                        <td><?= date('M d, Y', strtotime($expense['date'])) ?></td>
                        <td><?= esc($expense['description']) ?></td>
                        <td><?= esc($expense['category_name']) ?></td>
                        <td class="text-right amount">$<?= number_format($expense['amount'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-item">
                <span class="summary-label">Total Expenses:</span>
                <span class="summary-value">$<?= number_format($total, 2) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Number of Entries:</span>
                <span class="summary-value"><?= count($expenses) ?></span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Average Amount:</span>
                <span class="summary-value">$<?= number_format($total / count($expenses), 2) ?></span>
            </div>
        </div>
    <?php endif; ?>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Expense Tracker - Generated automatically on <?= date('F d, Y') ?></p>
    </div>
</body>
</html>