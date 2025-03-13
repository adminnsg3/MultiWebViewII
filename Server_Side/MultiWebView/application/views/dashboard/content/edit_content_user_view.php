<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
$this->load->view('dashboard/common/header_view');
//Show relevant sidebar
if ($_SESSION['user_type'] == 1)
    $this->load->view('dashboard/common/sidebar_view');
elseif ($_SESSION['user_type'] == 2)
    $this->load->view('dashboard/common/sidebar_user_view');

//Inactive content, can't access
if($_SESSION['user_type'] != 1 AND $contentContent->content_status != 1)
{
    $msg = $this->lang->line("This content is inactive. Please wait to activate it via admin or contact us.");
    $this->session->set_flashdata('msg',$msg);
    $this->session->set_flashdata('msgType','warning');
    redirect(base_url().'dashboard/Content/content_list');
}
?>

    <section class="content">
        <div class="container-fluid">
            <!--<div class="block-header">
                <h2>
                    <?php echo $this->lang->line("Edit Content"); ?>
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
                                <?php echo $this->lang->line("Edit Content"); ?>
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
                            echo form_open_multipart(base_url()."dashboard/Content/edit_content/", $attributes);
                            //form_open_multipart//For Upload
                            ?>

                                <div class="form-group">
                                    <label for="content_title" class="col-sm-2 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_title" value="<?php echo $contentContent->content_title; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_sub_title" class="col-sm-2 control-label"><?php echo $this->lang->line("Sub Title"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_sub_title" placeholder="<?php echo $this->lang->line("Sub Title"); ?>" value="<?php echo $contentContent->content_sub_title; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url" class="col-sm-2 control-label"><?php echo $this->lang->line("Main URL"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url" placeholder="http://www.YourDomain.com" value="<?php echo $contentContent->content_url; ?>" required>
                                        </div>
                                        <small class="col-pink">Website home page. Start with http:// or https://</small>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label for="content_email" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="content_email" placeholder="<?php echo $this->lang->line("Email"); ?>" value="<?php echo $contentContent->content_email; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_orientation" class="col-sm-2 control-label"><?php echo $this->lang->line("Orientation"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="content_orientation" name="content_orientation" required>
                                            <?php
                                            $content_orientation_selected1 = $content_orientation_selected2 = $content_orientation_selected3 = "";
                                            if($contentContent->content_orientation == 1) $content_orientation_selected1 = "selected='selected'";
                                            if($contentContent->content_orientation == 2) $content_orientation_selected2 = "selected='selected'";
                                            if($contentContent->content_orientation == 3) $content_orientation_selected3 = "selected='selected'";
                                            ?>
                                            <option <?php echo $content_orientation_selected1; ?> value="1"><?php echo $this->lang->line("It does not matter"); ?></option>
                                            <option <?php echo $content_orientation_selected2; ?> data-subtext="(Portrait)" value="2"><?php echo $this->lang->line("Portrait"); ?></option>
                                            <option <?php echo $content_orientation_selected3; ?> data-subtext="(Landscape)" value="3"><?php echo $this->lang->line("Landscape"); ?></option>
                                        </select>
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Suitable for display on a mobile phone vertically or horizontally."); ?></small>
                                </div>
                            </div>
							
							
							<div class="form-group">
                                <label for="content_loader" class="col-sm-2 control-label"><?php echo $this->lang->line("Loader"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="content_loader" name="content_loader" required>
										<?php
                                            $content_loader_selected1 = $content_loader_selected2 = $content_loader_selected3 = "";
                                            if($contentContent->content_loader == "pull") $content_loader_selected1 = "selected='selected'";
                                            if($contentContent->content_loader == "dialog") $content_loader_selected2 = "selected='selected'";
                                            if($contentContent->content_loader == "hide") $content_loader_selected3 = "selected='selected'";
                                            ?>
                                            <option <?php echo $content_loader_selected1; ?> value="pull"><?php echo $this->lang->line("Pull"); ?></option>
                                            <option <?php echo $content_loader_selected2; ?> value="dialog"><?php echo $this->lang->line("Dialog"); ?></option>
                                            <option <?php echo $content_loader_selected3; ?> value="hide"><?php echo $this->lang->line("Hide"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr><span class="col-grey"><?php echo $this->lang->line("Navigation Menu"); ?></span><hr>
                                <div class="form-group">
                                    <label for="content_url1_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 1"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url1_text" placeholder="Example: Our Products" value="<?php echo $contentContent->content_url1_text; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url1" placeholder="Example: http://www.YourDomain.com/Our Products" value="<?php echo $contentContent->content_url1; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url2_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 2"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="content_url2_text" placeholder="Example: About Us" value="<?php echo $contentContent->content_url2_text; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url2" placeholder="Example: http://www.YourDomain.com/AboutUs" value="<?php echo $contentContent->content_url2; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url3_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 3"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url3_text" placeholder="Example: Privacy Policy" value="<?php echo $contentContent->content_url3_text; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url3" placeholder="Example: http://www.YourDomain.com/PrivacyPolicy" value="<?php echo $contentContent->content_url3; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url4_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 4"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url4_text" placeholder="Example: Contact Us" value="<?php echo $contentContent->content_url4_text; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url4" placeholder="Example: http://www.YourDomain.com/ContactUs" value="<?php echo $contentContent->content_url4; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_url5_text" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom URL 5"); ?></label>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_url5_text" placeholder="Example: Test Page" value="<?php echo $contentContent->content_url5_text; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-line">
                                            <input type="url" style="direction: ltr" class="form-control" name="content_url5" placeholder="Example: http://www.YourDomain.com/TestPage" value="<?php echo $contentContent->content_url5; ?>">
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label for="content_menu" class="col-sm-2 control-label"><?php echo $this->lang->line("Menu"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <?php
                                        $content_menu_checked = "";
                                        if($contentContent->content_menu == 1) $content_menu_checked = "checked";
                                        ?>
                                        <input type="checkbox" <?php echo $content_menu_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_menu" name="content_menu">
                                        <label class="" for="content_menu"><?php echo $this->lang->line("Enable navigation menu."); ?></label>
                                    </div>
                                </div>
                            </div>


                                <!--<div class="form-group">
                                    <label for="content_access" class="col-sm-2 control-label"><?php echo $this->lang->line("Access to content"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="content_access" name="content_access" required>
                                                <?php
                                                $content_access_selected1 = $content_access_selected2 = "";
                                                if($contentContent->content_access == 1) $content_access_selected1 = "selected='selected'";
                                                if($contentContent->content_access == 2) $content_access_selected2 = "selected='selected'";
                                                ?>
                                                <option <?php echo $content_access_selected1; ?> value="1"><?php echo $this->lang->line("Indirect Access"); ?></option>
                                                <option <?php echo $content_access_selected2; ?> value="2"><?php echo $this->lang->line("Direct Access"); ?></option>
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
                                                    $content_user_role_id_selected = "";
                                                    if($key->user_role_id == $contentContent->content_user_role_id) $content_user_role_id_selected = "selected='selected'";
                                                    ?>
                                                    <option <?php echo $content_user_role_id_selected; ?> value="<?php echo $key->user_role_id; ?>"><?php echo $key->user_role_title ?></option>
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
                                            <input id="mycolor1" type="text" class="form-control" name="content_primary_color" value="<?php echo $contentContent->content_primary_color; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_dark_color" class="col-sm-2 control-label"><?php echo $this->lang->line("Dark Color"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input id="mycolor2" type="text" class="form-control" name="content_dark_color" value="<?php echo $contentContent->content_dark_color; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_accent_color" class="col-sm-2 control-label"><?php echo $this->lang->line("Accent Color"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input id="mycolor3" type="text" class="form-control" name="content_accent_color" value="<?php echo $contentContent->content_accent_color; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <hr><span class="col-grey"><?php echo $this->lang->line("AdMob Configuration"); ?></span><hr>
                                <div class="form-group">
                                    <label for="content_admob_app_id" class="col-sm-2 control-label"><?php echo $this->lang->line("App ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_admob_app_id" placeholder="<?php echo $this->lang->line("AdMob App ID"); ?>" value="<?php echo $contentContent->content_admob_app_id; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_admob_banner_unit_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Banner ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_admob_banner_unit_id" placeholder="<?php echo $this->lang->line("AdMob Banner Unit ID"); ?>" value="<?php echo $contentContent->content_admob_banner_unit_id; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_admob_interstitial_unit_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Interstitial ID"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="content_admob_interstitial_unit_id" placeholder="<?php echo $this->lang->line("AdMob Interstitial Unit ID"); ?>" value="<?php echo $contentContent->content_admob_interstitial_unit_id; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_banner_ads" class="col-sm-2 control-label"><?php echo $this->lang->line("Banner Ads"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <?php
                                            $content_banner_ads_checked = "";
                                            if($contentContent->content_banner_ads == 1) $content_banner_ads_checked = "checked";
                                            ?>
                                            <input type="checkbox" <?php echo $content_banner_ads_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_banner_ads" name="content_banner_ads">
                                            <label class="" for="content_banner_ads"><?php echo $this->lang->line("Enable banner ads."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_interstitial_ads" class="col-sm-2 control-label"><?php echo $this->lang->line("Interstitial Ads"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <?php
                                            $content_interstitial_ads_checked = "";
                                            if($contentContent->content_interstitial_ads == 1) $content_interstitial_ads_checked = "checked";
                                            ?>
                                            <input type="checkbox" <?php echo $content_interstitial_ads_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_interstitial_ads" name="content_interstitial_ads">
                                            <label class="" for="content_interstitial_ads"><?php echo $this->lang->line("Enable interstitial ads."); ?></label>
                                        </div>
                                    </div>
                                </div>

                            <hr><span class="col-grey"><?php echo $this->lang->line("OneSignal Configuration"); ?></span><hr>
                            <div class="form-group">
                                <label for="content_onesignal_app_id" class="col-sm-2 control-label"><?php echo $this->lang->line("App ID"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="content_onesignal_app_id" value="<?php echo $this->encrypt->decode($contentContent->content_onesignal_app_id); ?>" placeholder="<?php echo $this->lang->line("OneSignal APP ID"); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_onesignal_rest_api_key" class="col-sm-2 control-label"><?php echo $this->lang->line("REST API Key"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="content_onesignal_rest_api_key" value="<?php echo $this->encrypt->decode($contentContent->content_onesignal_rest_api_key); ?>" placeholder="<?php echo $this->lang->line("OneSignal REST API Key"); ?>">
                                    </div>
                                </div>
                            </div>

                            <hr><span class="col-grey"><?php echo $this->lang->line("Other Configuration"); ?></span><hr>

                                <div class="form-group">
                                    <label for="content_rtl" class="col-sm-2 control-label"><?php echo $this->lang->line("RTL Mode"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <?php
                                            $content_rtl_checked = "";
                                            if($contentContent->content_rtl == 1) $content_rtl_checked = "checked";
                                            ?>
                                            <input type="checkbox" <?php echo $content_rtl_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_rtl" name="content_rtl">
                                            <label class="" for="content_rtl"><?php echo $this->lang->line("This website is RTL (Right to Left)."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_fullscreen" class="col-sm-2 control-label"><?php echo $this->lang->line("Fullscreen"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <?php
                                            $content_fullscreen_checked = "";
                                            if($contentContent->content_fullscreen == 1) $content_fullscreen_checked = "checked";
                                            ?>
                                            <input type="checkbox" <?php echo $content_fullscreen_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_fullscreen" name="content_fullscreen">
                                            <label class="" for="content_fullscreen"><?php echo $this->lang->line("Enable fullscreen mode."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_toolbar" class="col-sm-2 control-label"><?php echo $this->lang->line("Toolbar"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <?php
                                            $content_toolbar_checked = "";
                                            if($contentContent->content_toolbar == 1) $content_toolbar_checked = "checked";
                                            ?>
                                            <input type="checkbox" <?php echo $content_toolbar_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_toolbar" name="content_toolbar">
                                            <label class="" for="content_toolbar"><?php echo $this->lang->line("Show the toolbar."); ?></label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="content_status" class="col-sm-2 control-label"><?php echo $this->lang->line("Status"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <?php
                                            $content_status_checked = "";
                                            if($contentContent->content_status == 1) $content_status_checked = "checked";
                                            ?>
                                            <input type="checkbox" <?php echo $content_status_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_status" name="content_status">
                                            <label class="" for="content_status"><?php echo $this->lang->line("Enable this content."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="content_image" class="col-sm-2 control-label"><?php echo $this->lang->line("Logo"); ?></label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <input type="file" name="content_image" multiple>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="hidden" class="form-control" name="content_access" value="1" readonly>
                                        <input type="hidden" name="content_id" value="<?php echo $contentContent->content_id; ?>" readonly="readonly" required>
                                        <input type="hidden" name="content_old_image" value="<?php echo $contentContent->content_image; ?>" readonly="readonly" required>
                                        <input type="hidden" name="content_user_id" value="<?php echo $contentContent->content_user_id; ?>" readonly="readonly" required>
                                        <button <?php if($_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Edit Content"); ?></button>

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