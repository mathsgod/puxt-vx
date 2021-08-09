<link rel="stylesheet" type="text/css" href="/css/pages/app-user.css">
<section class="app-user-view">
    <!-- User Card & Plan Starts -->
    <div class="row">
        <!-- User Card starts-->
        <div class="col-xl-9 col-lg-8 col-md-7">
            <div class="card user-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                            <div class="user-avatar-section">
                                <div class="d-flex justify-content-start">
                                    <img class="img-fluid rounded" src="http://localhost:8001/vx/images/user.png" height="104" width="104" alt="User avatar" />
                                    <div class="d-flex flex-column ml-1">
                                        <div class="user-info mb-1">
                                            <h4 class="mb-0">{{user.first_name}} {{user.last_name}}</h4>
                                            <span class="card-text">{{user.email}}</span>
                                        </div>
                                        <div class="d-flex flex-wrap">
                                            {% if can_change_password %}
                                            <router-link to="/User/{{user.user_id}}/change-password" class="btn btn-primary">Change password</router-link -->
                                            {% endif %}

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                            <div class="user-info-wrapper">
                                <div class="d-flex flex-wrap">
                                    <div class="user-info-title">
                                        <i data-feather="user" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Username</span>
                                    </div>
                                    <p class="card-text mb-0">{{user.username}}</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="check" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Status</span>
                                    </div>
                                    <p class="card-text mb-0">{{user.status()}}</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="star" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">User group</span>
                                    </div>
                                    <p class="card-text mb-0">{{usergroup}}</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="flag" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Phone</span>
                                    </div>
                                    <p class="card-text mb-0">{{user.phone}}</p>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="user-info-title">
                                        <i data-feather="phone" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Address</span>
                                    </div>
                                    <p class="card-text mb-0">{{user.addr1}}</p>
                                    <p class="card-text mb-0">{{user.addr2}}</p>
                                    <p class="card-text mb-0">{{user.addr3}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /User Card Ends-->


    </div>
    <!-- User Card & Plan Ends -->

    <!-- User Timeline & Permissions Starts -->
    <div class="row">
        <!-- information starts -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-2">User Timeline</h4>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        {% for item in timeline %}
                        <li class="timeline-item">
                            <span class="timeline-point timeline-point-{{item.type}} timeline-point-indicator"></span>
                            <div class="timeline-event">
                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                    <h6>{{item.title}}</h6>
                                    <span class="timeline-event-time">{{item.time}}</span>
                                </div>
                                <p class="mb-0">-</p>
                            </div>
                        </li>
                        {% endfor %}
                    </ul>
                </div>
            </div>
        </div>
        <!-- information Ends -->

        <!-- User Permissions Starts -->
        <div class="col-md-6">
            <!-- User Permissions -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Permissions</h4>
                </div>
                <p class="card-text ml-2">Permission according to roles</p>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="thead-light">
                            <tr>
                                <th>Module</th>
                                <th>Read</th>
                                <th>Write</th>
                                <th>Create</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for module in modules %}
                            <tr>
                                <td>{{module.name}}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['read'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-read" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['update'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-write" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['create'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-create" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['delete'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-delete" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-delete"></label>
                                    </div>
                                </td>
                            </tr>
                            {% endfor %}

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /User Permissions -->
        </div>
        <!-- User Permissions Ends -->
    </div>
    <!-- User Timeline & Permissions Ends -->

    <vx-card>
        <vx-card-body class="p-0">
            {{userlog_table|raw}}
        </vx-card-body>
    </vx-card>
</section>

<?php

use Carbon\Carbon;
use VX\EventLog;
use VX\UI\TableColumn;
use VX\UserLog;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-22 
 */
return new class
{
    function get(VX $vx)
    {

        $this->user = $vx->object();
        $this->can_change_password = $this->user->canChangePasswordBy($vx->user);

        $this->usergroup = collect($this->user->UserGroup())->map(function ($o) {
            return $o->name;
        })->join(", ");

        $rt = $vx->ui->createTable("userlog");
        $rt->setDefaultSort("userlog_id", "descending");
        $rt->add("ID", "userlog_id")->sortable()->searchable()->width("60");
        $rt->add("Login time", "login_dt")->sortable()->searchable(TableColumn::SEARCH_TYPE_DATE)->width("200");
        $rt->add("Logout time", "logout_dt")->sortable()->searchable(TableColumn::SEARCH_TYPE_DATE)->width("200");
        $rt->add("IP address", "ip")->sortable()->searchable()->width("130");

        $rt->add("Result", "result")->sortable()->filterable([
            [
                "value" => "SUCCESS",
                "text" => "Success"
            ],            [
                "value" => "FAIL",
                "text" => "Fail"
            ],
        ])->width("200");

        $rt->add("User agent", "user_agent")->searchable()->overflow();

        $this->userlog_table = $rt;

        $this->modules = $vx->getModules();
        $this->permission = [];
        $acl = $vx->getAcl();
        foreach ($vx->getModules() as $module) {
            $p = [];
            foreach (["create", "read", "update", "delete"] as $privilege) {
                $p[$privilege] = $acl->isAllowed($this->user, $module, $privilege);
            }

            $this->permission[$module->name] = $p;
        }
       
        // timeline
        $this->timeline = [];
        $els = EventLog::Query(["user_id" => $this->user->user_id])->orderBy(["eventlog_id" => "desc"])->limit(10);
        foreach ($els as $el) {
            $time = new Carbon($el->created_time);
            if ($el->action == "Insert") {
                $this->timeline[] = [
                    "type" => "success",
                    "title" => "Create a new " . $el->class,
                    "time" => $time->diffForHumans()
                ];
            } elseif ($el->action == "Delete") {
                $this->timeline[] = [
                    "type" => "danger",
                    "title" => $el->class . " deleted",
                    "time" => $time->diffForHumans()
                ];
            }
        };
    }

    function userlog(VX $vx)
    {
        $obj = $vx->object();
        $rt = $vx->ui->createTableResponse();
        $rt->source = UserLog::Query(["user_id" => $obj->user_id]);
        $rt->add("userlog_id");
        $rt->add("login_dt");
        $rt->add("logout_dt");
        $rt->add("ip");
        $rt->add("result");
        $rt->add("user_agent");
        return $rt;
    }
};
