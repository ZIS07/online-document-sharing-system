<?php include('db_connect.php'); ?>
<!-- Info boxes -->
<?php if ($_SESSION['login_type'] == 1): ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM users WHERE type = 2")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-folder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Documents</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM documents WHERE user_id = {$_SESSION['login_id']}")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php 
                    // Check if name is stored as "Last, First Middle" and correct the order
                    $login_name = $_SESSION['login_name'];
                    if (strpos($login_name, ',') !== false) {
                        $name_parts = explode(", ", $login_name);
                        $formatted_name = $name_parts[1] . " " . $name_parts[0]; // Rearranged Name
                    } else {
                        $formatted_name = $login_name; // Use as is if format is different
                    }
                ?>
                Welcome <?php echo $formatted_name; ?>!
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-folder"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Documents</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM documents WHERE user_id = {$_SESSION['login_id']}")->num_rows; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
