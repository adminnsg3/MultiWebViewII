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

            <div class="col-xs-12 col-sm-3">
                <div class="card profile-card">
                    <div class="profile-header">&nbsp;</div>
                    <div class="profile-body">
                        <div class="image-area">
                            <img width="110" height="110" src="<?php echo base_url()."assets/upload/user/profile_img/".$userContent->user_image; ?>" alt="<?php echo $this->lang->line("Profile"); ?>" />
                        </div>
                        <div class="content-area">
                            <h3><?php echo $userContent->user_username; ?></h3>
                            <p><?php echo "$userContent->user_firstname $userContent->user_lastname"; ?></p>
                        </div>
                    </div>
                    <div class="profile-footer">
                        <ul>
                            <li>
                                <span><?php echo $this->lang->line("Account Type"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php echo $userContent->user_type_title; ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("User Role"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php echo $userContent->user_role_title; ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("Join Date"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php if ($this->lang->line("date-format-ago") == "default") echo mdate('%Y/%m/%d', $userContent->user_reg_date); elseif($this->lang->line("date-format-ago") == "jdf") echo $this->jdf->jdate('Y/m/d', $userContent->user_reg_date); else echo mdate('%Y/%m/%d', $userContent->user_reg_date); ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("Referral ID"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php if ($userContent->user_referral == 0) echo $this->lang->line("Nobody"); else echo $userContent->user_referral; ?></span>
                            </li>
                        </ul>
                        <!-- <button class="btn btn-primary btn-lg waves-effect btn-block">FOLLOW</button>-->
                    </div>
                </div>

                <div class="card card-about-me">
                    <div class="header">
                        <h2><?php echo $this->lang->line("My Notes"); ?></h2>
                    </div>
                    <div class="body">
                        <?php if (empty($userContent->user_note)) echo $this->lang->line("Nothing Found..."); else echo $userContent->user_note; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">

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
                    <div class="body">
                        <div>
                            <ul class="nav nav-tabs <?php echo $this->lang->line("tab-col-x"); ?>" role="tablist">
                                <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">contacts</i> <?php echo $this->lang->line("Personal Profile"); ?></a></li>
                                <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">lock</i> <?php echo $this->lang->line("Change Password"); ?></a></li>
                                <li role="presentation"><a href="#activity" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">access_time</i> <?php echo $this->lang->line("Activity"); ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                                    <br>
                                    <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="user_firstname" class="col-sm-2 control-label"><?php echo $this->lang->line("First Name"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_firstname" minlength="1" maxlength="30" placeholder="<?php echo $this->lang->line("First Name"); ?>" value="<?php echo $userContent->user_firstname; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_lastname" class="col-sm-2 control-label"><?php echo $this->lang->line("Last Name"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_lastname" minlength="1" maxlength="30" placeholder="<?php echo $this->lang->line("Last Name"); ?>" value="<?php echo $userContent->user_lastname; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Email" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="email" class="form-control" name="user_email" minlength="5" maxlength="60" placeholder="<?php echo $this->lang->line("Email"); ?>" value="<?php echo $userContent->user_email; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_mobile" class="col-sm-2 control-label"><?php echo $this->lang->line("Mobile"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_mobile" minlength="3" maxlength="15" placeholder="<?php echo $this->lang->line("Mobile"); ?>" value="<?php echo $userContent->user_mobile; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_phone" class="col-sm-2 control-label"><?php echo $this->lang->line("Phone"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_phone" minlength="3" maxlength="15" placeholder="<?php echo $this->lang->line("Phone"); ?>" value="<?php echo $userContent->user_phone; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_note" class="col-sm-2 control-label"><?php echo $this->lang->line("Notes"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <textarea class="form-control" name="user_note" rows="3" minlength="3" maxlength="1000" placeholder="<?php echo $this->lang->line("Notes"); ?>"><?php echo $userContent->user_note; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_image" class="col-sm-2 control-label"><?php echo $this->lang->line("User's Image"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="file" name="user_image" multiple>
                                                </div>
                                                <small class="col-pink"><?php echo $this->lang->line("Best image ratio is 150 * 150 pixel."); ?></small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="profile_settings" required="required">
                                                <input type="hidden" readonly="readonly" name="old_user_image" value="<?php echo $userContent->user_image; ?>" required="required">
                                                <button <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Edit Profile"); ?></button>

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
                                <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                    <br>
                                    <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>">
                                        <div class="form-group">
                                            <label for="old_password" class="col-sm-2 control-label"><?php echo $this->lang->line("Old Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="old_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("Old Password"); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password" class="col-sm-2 control-label"><?php echo $this->lang->line("New Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="new_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("New Password"); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password_confirm" class="col-sm-2 control-label"><?php echo $this->lang->line("New Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="new_password_confirm" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("New Password"); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="change_password_settings" required="required">
                                                <button <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>

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
                                <div role="tabpanel" class="tab-pane fade in" id="activity">
                                    <p class="text-center"><?php echo $this->lang->line("Your Last 15 Activities"); ?></p>
                                    <!-- Hover Rows -->
                                    <div class="row clearfix">
                                        <div class="">
                                            <div class="">
                                                <div class="body table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("Time"); ?></th>
                                                            <th><?php echo $this->lang->line("Activity Description"); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach($userActivity as $key) {
                                                        ?>
                                                        <tr>
                                                            <td><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago"); elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago"); /*echo $this->Shared_model->ago_time($key->activity_time);*/ /*echo $this->jdf->jdate('Y/m/d G:i', $key->activity_time);*/ else echo timespan($key->activity_time, now(), 3);/*echo unix_to_human($key->activity_time);*/ /*echo timespan($key->activity_time, now(), 3);*/ /*echo $this->jdf->jdate('Y/m/d G:i', $key->activity_time);*/  ?></td>
                                                            <td><?php echo $key->activity_desc; ?></td>
                                                        </tr>
                                                         <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- #END# Hover Rows -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
$this->load->view('dashboard/common/footer_view');
$active_tab = $this->uri->segment(4);
?>
<script>
    $(document).ready(function() {
        $('.nav-tabs a[href="#<?php echo $active_tab; ?>"]').tab('show')
    });
</script>
