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
            <!--<div class="block-header">
                <h2>
                    <?php echo $this->lang->line("Add Content"); ?>
                </h2>
            </div>-->
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
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
                                <?php echo $this->lang->line("Add Content"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Content/content_list"; ?>"><?php echo $this->lang->line("Content List"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open_multipart(base_url()."dashboard/Content/add_content/", $attributes);
                            //form_open_multipart//For Upload
                            ?>

                                <div class="form-group">
                                    <label for="content_user_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Owner"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="content_user_id" name="content_user_id" data-live-search="true" data-show-subtext="true" required>
                                                <option disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                                <?php
                                                foreach ($fetchUsers as $key) {
                                                    ?>
                                                    <option data-subtext="(<?php echo $key->user_id ?>)" value="<?php echo $key->user_id ?>"><?php echo $key->user_username; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <hr>

                                <div class="form-group">
                                    <label for="content_title" class="col-sm-2 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_title" placeholder="<?php echo $this->lang->line("Title"); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_sub_title" class="col-sm-2 control-label"><?php echo $this->lang->line("Sub Title"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_sub_title" placeholder="<?php echo $this->lang->line("Sub Title"); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url" class="col-sm-2 control-label"><?php echo $this->lang->line("Main URL"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url" placeholder="http://www.YourDomain.com" required>
                                        </div>
                                        <small class="col-pink">Website home page. Start with http:// or https://</small>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label for="content_email" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="content_email" placeholder="<?php echo $this->lang->line("Email"); ?>" required>
                                    </div>
                                </div>
                            </div>


                            <!--<div class="form-group">
                                    <label for="content_description" class="col-sm-2 control-label"><?php echo $this->lang->line("Description"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="">
                                            <textarea class="form-control" name="content_description" id="content_description" required><?php echo $this->lang->line("Write Something..."); ?></textarea>
                                        </div>
                                    </div>
                                </div>-->


                            <div class="form-group">
                                <label for="content_orientation" class="col-sm-2 control-label"><?php echo $this->lang->line("Orientation"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="content_orientation" name="content_orientation" required>
                                            <option selected="selected" value="1"><?php echo $this->lang->line("It does not matter"); ?></option>
                                            <option data-subtext="(Vertical)" value="2"><?php echo $this->lang->line("Portrait"); ?></option>
                                            <option data-subtext="(Horizontal)" value="3"><?php echo $this->lang->line("Landscape"); ?></option>
                                        </select>
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Display website vertically or horizontally."); ?></small>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label for="content_loader" class="col-sm-2 control-label"><?php echo $this->lang->line("Loader"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="content_loader" name="content_loader" required>
                                            <option value="pull"><?php echo $this->lang->line("Pull"); ?></option>
                                            <option value="dialog"><?php echo $this->lang->line("Dialog"); ?></option>
                                            <option value="hide"><?php echo $this->lang->line("Hide"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr><span class="col-grey"><?php echo $this->lang->line("Navigation Menu"); ?></span><hr>

                                <div class="form-group">
                                    <label for="content_url1_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 1"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url1_text" placeholder="Example: Our Products">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url1" placeholder="Example: http://www.YourDomain.com/OurProducts">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="content_url2_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 2"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url2_text" placeholder="Example: Privacy Policy">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url2" placeholder="Example: http://www.YourDomain.com/PrivacyPolicy">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url3_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 3"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="content_url3_text" placeholder="Example: About Us">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url3" placeholder="Example: http://www.YourDomain.com/AboutUs">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url4_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 4"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url4_text" placeholder="Example: Contact Us">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url4" placeholder="Example: http://www.YourDomain.com/ContactUs">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url5_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 5"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url5_text" placeholder="Example: TestPage">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url5" placeholder="Example: http://www.YourDomain.com/TestPage">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_menu" class="col-sm-2 control-label"><?php echo $this->lang->line("Menu"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" checked class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_menu" name="content_menu">
                                            <label class="" for="content_menu"><?php echo $this->lang->line("Enable navigation menu."); ?></label>
                                        </div>
                                    </div>
                                </div>



                                <!--<div class="form-group">
                                    <label for="content_access" class="col-sm-2 control-label"><?php echo $this->lang->line("Access to content"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="content_access" name="content_access" required>
                                                <option selected value="1"><?php echo $this->lang->line("Indirect Access"); ?></option>
                                                <option value="2"><?php echo $this->lang->line("Direct Access"); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>-->

                                <!--<div class="form-group">
                                    <label for="content_user_role_id" class="col-sm-2 control-label"><?php echo $this->lang->line("User Role"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="content_user_role_id" name="content_user_role_id" data-show-subtext="true" required>
                                                <?php
                                                foreach ($userRole as $key) {
                                                    ?>
                                                    <option value="<?php echo $key->user_role_id; ?>"><?php echo $key->user_role_title ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>-->

                            <hr><span class="col-grey"><?php echo $this->lang->line("Application Color"); ?></span><hr>

                                <div class="form-group">
                                    <label for="content_primary_color" class="col-sm-2 control-label"><?php echo $this->lang->line("Primary Color"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input id="mycolor1" type="text" class="form-control" name="content_primary_color" value="#4CAF50" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_dark_color" class="col-sm-2 control-label"><?php echo $this->lang->line("Dark Color"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input id="mycolor2" type="text" class="form-control" name="content_dark_color" value="#388E3C" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_accent_color" class="col-sm-2 control-label"><?php echo $this->lang->line("Accent Color"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input id="mycolor3" type="text" class="form-control" name="content_accent_color" value="#CDDC39" required>
                                        </div>
                                    </div>
                                </div>

                                <hr><span class="col-grey"><?php echo $this->lang->line("AdMob Configuration"); ?></span><hr>
                                <div class="form-group">
                                    <label for="content_admob_app_id" class="col-sm-2 control-label"><?php echo $this->lang->line("App ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_admob_app_id" placeholder="<?php echo $this->lang->line("AdMob App ID"); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_admob_banner_unit_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Banner ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_admob_banner_unit_id" placeholder="<?php echo $this->lang->line("AdMob Banner Unit ID"); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_admob_interstitial_unit_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Interstitial ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_admob_interstitial_unit_id" placeholder="<?php echo $this->lang->line("AdMob Interstitial Unit ID"); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_banner_ads" class="col-sm-2 control-label"><?php echo $this->lang->line("Banner Ads"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_banner_ads" name="content_banner_ads">
                                            <label class="" for="content_banner_ads"><?php echo $this->lang->line("Enable banner ads."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_interstitial_ads" class="col-sm-2 control-label"><?php echo $this->lang->line("Interstitial Ads"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_interstitial_ads" name="content_interstitial_ads">
                                            <label class="" for="content_interstitial_ads"><?php echo $this->lang->line("Enable interstitial ads."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <hr><span class="col-grey"><?php echo $this->lang->line("OneSignal Configuration"); ?></span><hr>
                                <div class="form-group">
                                    <label for="content_onesignal_app_id" class="col-sm-2 control-label"><?php echo $this->lang->line("App ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_onesignal_app_id" placeholder="<?php echo $this->lang->line("OneSignal APP ID"); ?>">
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label for="content_onesignal_rest_api_key" class="col-sm-2 control-label"><?php echo $this->lang->line("REST API Key"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="content_onesignal_rest_api_key" placeholder="<?php echo $this->lang->line("OneSignal REST API Key"); ?>">
                                    </div>
                                </div>
                            </div>

                            <hr><span class="col-grey"><?php echo $this->lang->line("Other Configuration"); ?></span><hr>

                                <div class="form-group">
                                    <label for="content_rtl" class="col-sm-2 control-label"><?php echo $this->lang->line("RTL Mode"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_rtl" name="content_rtl">
                                            <label class="" for="content_rtl"><?php echo $this->lang->line("This website is RTL (Right to Left)."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_fullscreen" class="col-sm-2 control-label"><?php echo $this->lang->line("Fullscreen"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_fullscreen" name="content_fullscreen">
                                            <label class="" for="content_fullscreen"><?php echo $this->lang->line("Enable fullscreen mode."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_toolbar" class="col-sm-2 control-label"><?php echo $this->lang->line("Toolbar"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" checked class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_toolbar" name="content_toolbar">
                                            <label class="" for="content_toolbar"><?php echo $this->lang->line("Show the toolbar."); ?></label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="content_status" class="col-sm-2 control-label"><?php echo $this->lang->line("Status"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="checkbox" checked class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_status" name="content_status">
                                            <label class="" for="content_status"><?php echo $this->lang->line("Enable this content."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_image" class="col-sm-2 control-label"><?php echo $this->lang->line("Logo"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="file" name="content_image" multiple required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="hidden" class="form-control" name="content_access" value="1" readonly>
                                        <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Add Content"); ?></button>

                                        <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                                            <br><br>
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <?php echo $this->lang->line("Create / Remove / Update / Delete are disable on demo."); ?>
                                            </div>
                                        <?php } ?>

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

<!-- TinyMCE -->
<script src="<?php echo base_url()."assets/dashboard/plugins/tinymce/tinymce.js"; ?>"></script>
<?php
$this->load->view('dashboard/common/footer_view');
?>
<script>
    tinymce.init({
        selector: '#content_description',
        height: 250,
        theme: 'modern',
        directionality: "<?php echo $this->lang->line('app_direction'); ?>",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste wordcount"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
        setup : function(ed)
        {
            ed.on('init', function()
            {
                this.getDoc().body.style.fontSize = '13px';
                this.getDoc().body.style.fontFamily = 'Tahoma';
            });
        },

    });
</script>

<script>
    $(function () {
        // Basic instantiation:
        $('#mycolor1').colorpicker();

        // Example using an event, to change the color of the .jumbotron background:
        $('#mycolor1').on('colorpickerChange', function(event) {
            $('.jumbotron').css('background-color', event.color.toString());
        });
    });

    $(function () {
        // Basic instantiation:
        $('#mycolor2').colorpicker();

        // Example using an event, to change the color of the .jumbotron background:
        $('#mycolor2').on('colorpickerChange', function(event) {
            $('.jumbotron').css('background-color', event.color.toString());
        });
    });

    $(function () {
        // Basic instantiation:
        $('#mycolor3').colorpicker();

        // Example using an event, to change the color of the .jumbotron background:
        $('#mycolor3').on('colorpickerChange', function(event) {
            $('.jumbotron').css('background-color', event.color.toString());
        });
    });
</script>