<?php include 'functions.php'; ?>

<div class="modal-header">
    <?php echo userInfo($_GET['id'])['name']; ?>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Month</th>
                <th>Year</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $total = 0;
                foreach (getUserSalary($_GET['id']) as $salary): 
                    $total += $salary['amount'];
            ?>
                <tr>
                    <td><?php echo getMonths()[$salary['month']]; ?></td>
                    <td><?php echo $salary['year']; ?></td>
                    <td class="text-right"><?php echo number_format($salary['amount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">
                    <?php echo number_format($total, 2); ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>