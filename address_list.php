<?php include 'functions.php'; ?>

<div class="modal-header">
    <?php echo userInfo($_GET['id'])['name']; ?>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>City</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (getUserAddresses($_GET['id']) as $address) : ?>
                <tr>
                    <td><?php echo $address['city']; ?></td>
                    <td><?php echo $address['address']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>