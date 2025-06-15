<?php
include 'db_connect.php';

// Validate GET parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];
$qry = $conn->query("SELECT * FROM documents WHERE md5(id) = '$id'");

// Check if document exists
if ($qry->num_rows > 0) {
    $row = $qry->fetch_array();
    foreach ($row as $k => $v) {
        if ($k == 'title') $k = 'ftitle';
        $$k = $v;
    }
} else {
    die("No document found.");
}
?>
<div class="col-lg-12">
    <?php if(isset($_SESSION['login_id'])): ?>
    <div class="row">
        <div class="col-md-12 mb-2">
            <button class="btn bg-light border float-right" type="button" id="share">
                <i class="fa fa-share"></i> Share This Document
            </button>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-7">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <div class="card-tools">
                        <small class="text-muted">
                            Date Uploaded: <?php echo isset($date_created) ? date("M d, Y", strtotime($date_created)) : 'N/A'; ?>
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="callout callout-info">
                        <dl>
                            <dt>Title</dt>
                            <dd><?php echo isset($ftitle) ? $ftitle : 'N/A'; ?></dd>
                        </dl>
                    </div>
                    <div class="callout callout-info">
                        <dl>
                            <dt>Description</dt>
                            <dd><?php echo isset($description) ? html_entity_decode($description) : 'No description available.'; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3><b>File/s</b></h3>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="alert alert-info px-2 py-1">
                            <i class="fa fa-info-circle"></i> Click the file to download.
                        </div>
                        <div class="row">
                            <?php
                            if (isset($file_json) && !empty($file_json)) {
                                $files = json_decode($file_json, true); // Ensure it's an array
                                if (!empty($files) && is_array($files)) {
                                    foreach ($files as $v) {
                                        if (is_file('assets/uploads/'.$v)) {
                                            $dname = explode('_', $v);
                            ?>
                            <div class="col-sm-3">
                                <a href="download.php?f=<?php echo $v ?>" target="_blank" class="text-white border-rounded file-item p-1">
                                    <span class="img-fluid bg-dark border-rounded px-2 py-2 d-flex justify-content-center align-items-center" style="width: 100px;height: 100px">
                                        <h3 class="bg-dark"><i class="fa fa-download"></i></h3>
                                    </span>
                                    <span class="text-dark"><?php echo isset($dname[1]) ? $dname[1] : 'File'; ?></span>
                                </a>
                            </div>
                            <?php
                                        }
                                    }
                                }
                            } else {
                                echo "<p class='text-muted'>No files available.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.file-item').hover(function(){
        $(this).addClass("active");
    });

    $('.file-item').mouseout(function(){
        $(this).removeClass("active");
    });

    $('.file-item').click(function(e){
        e.preventDefault();
        _conf("Are you sure you want to download this file?", "dl", ['"'+$(this).attr('href')+'"']);
    });

    function dl($link){
        start_load();
        window.open($link, "_blank");
        end_load();
    }

    $('#share').click(function(){
        uni_modal("<i class='fa fa-share'></i> Share this document using the link.", "modal_share_link.php?did=<?php echo md5($id) ?>");
    });
</script>
