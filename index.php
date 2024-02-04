<?php
session_start();
include 'functions.php';
error_reporting(E_ERROR | E_PARSE);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>User</h1>
                <?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?>
                <?php
                if ($_GET['action'] == 'edit_user') {
                    $userInfo = userInfo($_GET['id']);
                    $formParam = '?id=' . $userInfo['id'];
                    $buttonClass = 'warning';
                    $buttonName = 'Edit';
                    $buttonActionName = 'edit';
                } else {
                    $buttonClass = 'success';
                    $buttonName = 'Add';
                    $buttonActionName = 'add';
                }
                ?>
                <form action="user_act.php<?php echo $formParam; ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" type="text" name="name" value="<?php echo $userInfo['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="text" name="email" value="<?php echo $userInfo['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input id="age" class="form-control" type="text" name="age" value="<?php echo $userInfo['age']; ?>">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="<?php echo $buttonActionName; ?>" class="btn btn-md btn-<?php echo $buttonClass; ?>" value="1"><?php echo $buttonName; ?></button>
                        <a href="index.php" class="btn btn-md btn-primary">New User</a>
                    </div>

                </form>
            </div>
            <div class="col-md-6">
                <h1>Salaries</h1>
                <?php echo $_SESSION['msg_salary'];
                unset($_SESSION['msg_salary']); ?>
                <form action="salaries_act.php" method="post">
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">- Select -</option>
                            <?php foreach (getUsers() as $user) : ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input id="amount" class="form-control" type="text" name="amount">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="month">Month</label>
                            <select name="month" id="month" class="form-control">
                                <?php foreach (getMonths() as $key => $month) : ?>
                                    <option value="<?php echo $key; ?>"><?php echo $month; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="year">Year</label>
                            <select name="year" id="year" class="form-control">
                                <?php for ($year = date('Y'); $year <= date('Y', strtotime('+10 years')); $year++) : ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="add" class="btn btn-md btn-success" value="1">Add</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <form action="" method="get">
                        <div class="card-header">
                            <h5 class="card-title">Filter</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="keyword">Keyword</label>
                                    <input id="keyword" class="form-control" type="text" name="keyword" value="<?php echo $_GET['keyword']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="age_from">Age from</label>
                                    <input id="age_from" class="form-control" type="text" name="age_from" value="<?php echo $_GET['age_from']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="age_to">Age to</label>
                                    <input id="age_to" class="form-control" type="text" name="age_to" value="<?php echo $_GET['age_to']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-sm btn-secondary" type="submit" name="filter" value="true">Filter</button>
                            <a href="index.php" class="btn btn-sm btn-danger">Clear Filter</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <?php echo $_SESSION['msg_delete'];
                unset($_SESSION['msg_delete']); ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Salary List</th>
                            <th>Total Salary</th>
                            <th>Address List</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $filter = array();
                        if ($_GET['keyword'] != "") {
                            $filter['keyword'] = $_GET['keyword'];
                        }
                        if ($_GET['age_from'] != "" && $_GET['age_to'] != "") {
                            $filter['age_from'] =  $_GET['age_from'];
                            $filter['age_to'] =  $_GET['age_to'];
                        }
                        foreach (getUsers($filter) as $user) :
                        ?>
                            <tr>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['age']; ?></td>
                                <td>
                                    <a href="#" data-modal-href="salary_list.php?id=<?php echo $user['id']; ?>" data-toggle="modal" data-target="#salary-modal" class="trigger-modal">View Salaries (<?php echo $user['salaryCount'] ?>)</a>
                                </td>
                                <td>
                                    <?php echo $user['salarySum']; ?>
                                </td>
                                <td>
                                    <a href="#" data-modal-href="address_list.php?id=<?php echo $user['id']; ?>" data-toggle="modal" data-target="#address-modal" class="trigger-modal">View Addresses (<?php echo $user['addressCount'] ?>)</a>
                                </td>
                                <td class="text-right">
                                    <a href="index.php?id=<?php echo $user['id']; ?>&action=edit_user">Edit</a>
                                    <a href="user_act.php?id=<?php echo $user['id']; ?>&action=delete" class="text-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div id="salary-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div id="address-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $('.trigger-modal').click(function() {
            var url = $(this).data('modal-href');
            $('#salary-modal').find('.modal-content').load(url);
        });
        $('.trigger-modal').click(function() {
            var url = $(this).data('modal-href');
            $('#address-modal').find('.modal-content').load(url);
        });
    </script>
</body>

</html>