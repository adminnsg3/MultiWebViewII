<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
$this->load->view('dashboard/common/header_view');
//Show relevant sidebar
if ($_SESSION['user_type'] == 1)
    $this->load->view('dashboard/common/sidebar_view');
elseif ($_SESSION['user_type'] == 2)
    $this->load->view('dashboard/common/sidebar_user_view');
?>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                            <?php echo $this->lang->line("Edit Slider"); ?>
                        </h2>
                    </div>
                    <div class="body">

                        <?php
                        $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                        echo form_open_multipart(base_url()."dashboard/slider/edit_slider/", $attributes);
                        ?>
                        <div class="form-group">
                            <label for="slider_title" class="col-sm-3 control-label"><?php echo $this->lang->line("Slider Title"); ?> *</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="slider_title" placeholder="<?php echo $this->lang->line("Slider Title"); ?>" value="<?php echo $sliderContent->slider_title; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_description" class="col-sm-3 control-label"><?php echo $this->lang->line("Slider Title"); ?> *</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <textarea class="form-control" rows="2" name="slider_description" placeholder="<?php echo $this->lang->line("Slider Description"); ?>" required><?php echo $sliderContent->slider_description; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_url" class="col-sm-3 control-label"><?php echo $this->lang->line("Website"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="slider_url" style="direction: ltr" placeholder="<?php echo $this->lang->line("Slider Title"); ?>" value="<?php echo $sliderContent->slider_url; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_image" class="col-sm-3 control-label"><?php echo $this->lang->line("Image"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="file" name="slider_image" multiple>
                                </div>
                                <small class="col-pink"><?php echo $this->lang->line("Best image ratio is 1280 * 480 pixel."); ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_status" class="col-sm-3 control-label"><?php echo $this->lang->line("Status"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <?php
                                    $slider_status_checked = "";
                                    if($sliderContent->slider_status == 1)
                                        $slider_status_checked = "checked";
                                    ?>
                                    <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="slider_status" name="slider_status" <?php echo $slider_status_checked; ?>>
                                    <label for="slider_status"><?php echo $this->lang->line("Enable this slider."); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="hidden" readonly="readonly" name="slider_id" value="<?php echo $sliderContent->slider_id; ?>" required>
                                <input type="hidden" readonly="readonly" name="old_slider_image" value="<?php echo $sliderContent->slider_image; ?>" required>
                                <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Examples -->
    </div>
</section>

<?php
$this->load->view('dashboard/common/footer_view');
?>
<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #user_role_id").val(my_id_value);
        })
    });
</script>
