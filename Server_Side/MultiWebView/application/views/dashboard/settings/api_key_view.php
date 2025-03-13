<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
$this->load->view('dashboard/common/header_view');
//Show relevant sidebar
if ($_SESSION['user_type'] == 1)
    $this->load->view('dashboard/common/sidebar_view');
elseif ($_SESSION['user_type'] == 2)
    $this->load->view('dashboard/common/sidebar_user_view');

$api_key = $this->encrypt->decode($apiKeyContent->api_key);
?>

    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("API Address"); ?>
                            </h2>
                        </div>
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Start API Address -->
                                    <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">

                                        <!-- Get Main Categories -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne_1">
                                                <h4 class="panel-title">
                                                    <a style="font-size: 14.5px" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">
                                                        <?php echo $this->lang->line("Get All Information"); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_1">
                                                <div class="panel-body" style="direction: ltr">
                                                    <?php echo base_url()."dashboard/Api/get_all_information/"; ?>
                                                    <br><br>
                                                    <small class="col-grey">Note: Pass the Website ID from segment four in the URL.</small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- #End# API Address -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <!-- Alert after process start -->
                    <?php
                    $msg = $this->session->flashdata('msg');
                    $msgType = $this->session->flashdata('msgType');
                    if (isset($msg))
                    {
                        ?>
                        <div class="alert alert-<?php echo $msgType; ?> alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $msg; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- ./Alert after process end -->
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("API Key"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Settings/general_settings"; ?>"><?php echo $this->lang->line("General Settings"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Settings/email_settings"; ?>"><?php echo $this->lang->line("Send Email"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="body">
                            <?php
                            $attributes = array('method' => 'post');
                            echo form_open(base_url()."dashboard/Settings/api_key/", $attributes);
                            ?>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input style="direction: ltr" type="text" name="api_key" class="form-control" value="<?php echo $api_key; ?>" required>
                                    <label class="form-label"><?php echo $this->lang->line("API Key"); ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-line">
                                    <?php
                                    $api_status_selected = "";
                                    if($apiKeyContent->api_status == 1) $api_status_selected = "checked";
                                    ?>
                                    <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="api_status" name="api_status" <?php echo $api_status_selected; ?>>
                                    <label for="api_status"><?php echo $this->lang->line("Enable access to API."); ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Save Key"); ?></button>
                                </div>
                            </div>

                            </form>

                        </div>
                    </div>

                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Guide"); ?>
                            </h2>
                        </div>

                        <div class="body">
                            <p class="text-justify"><?php echo $this->lang->line("api-help-text"); ?></p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

<?php
$this->load->view('dashboard/common/footer_view');
?>
<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<!--<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>-->
<script>
    $(document).ready(function () {
        $('#slidersList').DataTable({
            "oSearch"     : {'sSearch': '<?php if (isset($_GET['s'])) echo $_GET['s']; else echo ""; ?>'},
            "ordering"    : true,
            "order": [[0,'desc']],
            "columnDefs": [
                { "targets": 0, "name": "order", 'searchable':false, 'orderable':true},
                { "targets": 1, "name": "title", 'searchable':true, 'orderable':true},
                { "targets": 2, "name": "parent", 'searchable':true, 'orderable':true},
                { "targets": 3, "name": "image", 'searchable':false, 'orderable':true},
                { "targets": 4, "name": "status", 'searchable':false, 'orderable':false},
                { "targets": 5, "name": "action", 'searchable':false, 'orderable':false},
            ],
            "language": {
                paginate: {
                    next: '<?php echo $this->lang->line("Next"); ?>', // or '→' '&#8594;'
                    previous: '<?php echo $this->lang->line("Previous"); ?>', // or '←' ' &#8592;'
                    first:      '<?php echo $this->lang->line("First"); ?>',
                    last:       '<?php echo $this->lang->line("Last"); ?>',
                },
                "aria": {
                    sortAscending:  ': activate to sort column ascending',
                    sortDescending: ': activate to sort column descendin',
                },
                "zeroRecords": '<?php echo $this->lang->line("No Data Found"); ?>',
                "sLengthMenu": '<?php echo $this->lang->line("Display"); ?> _MENU_ <?php echo $this->lang->line("records"); ?>',
                "search": '<?php echo $this->lang->line("Search"); ?>',
                "infoFiltered": '(<?php echo $this->lang->line("filtered from"); ?> _MAX_ <?php echo $this->lang->line("total records"); ?>)',
                "info": '<?php echo $this->lang->line("Showing"); ?> _START_ <?php echo $this->lang->line("to"); ?> _END_ <?php echo $this->lang->line("of"); ?> _TOTAL_ <?php echo $this->lang->line("entries"); ?>',
                "infoEmpty": '<?php echo $this->lang->line("Showing"); ?> _START_ <?php echo $this->lang->line("to"); ?> _END_ <?php echo $this->lang->line("of"); ?> _TOTAL_ <?php echo $this->lang->line("entries"); ?>',
                "loadingRecords": '<?php echo $this->lang->line("Loading..."); ?>',
                "processing":     '<?php echo $this->lang->line("Processing..."); ?>',
                "emptyTable":     '<?php echo $this->lang->line("No data available in table"); ?>',
            }
        });
    });
</script>

<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #category_id").val(my_id_value);
        })
    });
</script>