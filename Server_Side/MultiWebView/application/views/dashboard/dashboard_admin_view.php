<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 style="padding-bottom: 7px;"><?php echo $this->lang->line("app_description"); ?></h2>
            <?php
            //Complete Your Profile Alert
            if(empty($userContent->user_firstname))
            {
                ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php echo $this->lang->line("System Message!"); ?><br></strong><?php echo $this->lang->line("Please update your information (Name & Mobile) to dismiss this warning."); ?>
                    <a style="color: white; text-decoration: none; font-size: 13.5px; font-weight: 500; border-bottom: 1px #000000 dashed;" href="<?php echo base_url()."dashboard/User/profile/profile_settings"; ?>"><?php echo $this->lang->line("Click Here!"); ?></a>
                </div>
                <?php
            }
            ?>

            <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->lang->line("Create / Remove / Update / Delete are disable on demo."); ?>
                </div>
            <?php } ?>
        </div>

        <!-- 4 Col Hover Expand Effect -->
        <div class="row clearfix">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/User/users_list"; ?>';">
                <div class="info-box bg-purple hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">people</i>
                    </div>
                    <div class="content">
                        <div class="text"><?php echo $this->lang->line("Users"); ?></div>
                        <div class="number"><?php echo $usersCount; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/Content/content_list"; ?>';">
                <div class="info-box bg-blue-grey hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">view_list</i>
                    </div>
                    <div class="content">
                        <div class="text"><?php echo $this->lang->line("Content"); ?></div>
                        <div class="number"><?php echo $contentCount; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/Settings/push_notification"; ?>';">
                <div class="info-box bg-brown hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="content">
                        <div class="text"><?php echo $this->lang->line("Push Notification"); ?></div>
                        <div class="number">!</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# 4 Col Hover Expand Effect -->

        <div class="row clearfix">
            <!-- Latest Activity -->
            <div class="col-xs-12 col-sm-12 col-md12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><?php echo $this->lang->line("Latest Activities"); ?></h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?php echo base_url()."dashboard/User/users_activity"; ?>"><?php echo $this->lang->line("Users Activity"); ?></a></li>
                                    <li><a href="<?php echo base_url()."dashboard/User/users_list"; ?>"><?php echo $this->lang->line("Users List"); ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div style="height: 219px; overflow-y: scroll; overflow-x: hidden">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line("Time"); ?></th>
                                        <th><?php echo $this->lang->line("User"); ?></th>
                                        <th><?php echo $this->lang->line("IP"); ?></th>
                                        <th><?php echo $this->lang->line("Activity Description"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($usersActivity as $key) {
                                        ?>
                                        <tr>
                                            <td class="font-light"><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->activity_time, now(), 2)." (".unix_to_human($key->activity_time).")";
                                                elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago")." (".$this->jdf->jdate('Y/m/d G:i', $key->activity_time).")";
                                                else echo timespan($key->activity_time, now(), 2); ?></td>
                                            <td class="font-light"><a href="<?php echo base_url()."dashboard/User/show_user/$key->user_id" ?>"><?php echo $key->user_username; ?></a></td>
                                            <td class="font-light"><?php if($_SESSION['user_role_id'] == 4) echo $this->lang->line("Hidden"); else echo $key->activity_ip; ?></td>
                                            <td class="font-light"><?php echo $key->activity_desc; ?></td>
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
            </div>
            <!-- #END# Latest Orders -->
        </div>

    </div>
</section>
