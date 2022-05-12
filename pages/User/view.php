

<section class="app-user-view-account">
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mt-3 mb-2" src="{{user.photo()}}" height="110" width="110" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4>{{user.first_name}} {{user.last_name}}</h4>
                                {% for ug in usergroups %}
                                <span class="badge bg-light-secondary">{{ug}}</span>
                                {% endfor %}
                            </div>
                        </div>
                    </div>
                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Username:</span>
                                <span>{{user.username}}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Email:</span>
                                <span>{{user.email}}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Phone:</span>
                                <span>{{user.phone}}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Status:</span>
                                {% if  user.status==0 %}
                                <span class="badge bg-light-success">
                                    Active
                                </span>
                                {% else %}
                                <span class="badge bg-light-danger">
                                    Inactive
                                </span>
                                {% endif %}

                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Role:</span>
                                <span>{{usergroup}}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center pt-2">
                            {% if can_change_password %}
                            <router-link to="/User/{{user.user_id}}/change-password" class="btn btn-primary">Change password</router-link>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->

        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">


            <!-- Activity Timeline -->
            <div class="card">
                <h4 class="card-header">User Activity Timeline</h4>
                <div class="card-body pt-1">
                    <ul class="timeline ms-50">
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
            <!-- /Activity Timeline -->

            <div class="card">
                <h4 class="card-header">{{'Permissions'|trans}}</h4>

                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead class="thead-light">
                            <tr>
                                <th>{{'Module'|trans}}</th>
                                <th>{{'Read'|trans}}</th>
                                <th>{{'Write'|trans}}</th>
                                <th>{{'Create'|trans}}</th>
                                <th>{{'Delete'|trans}}</th>
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
            <!-- /Activity Timeline -->

        </div>
        <!--/ User Content -->

    </div>
</section>

{{userlog_table|raw}}




<?php

use Carbon\Carbon;
use VX\EventLog;
use VX\UI\TableColumn;
use VX\User;
use VX\UserLog;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-22 
 */
return new class
{
    function get(VX $vx)
    {

        $this->user = User::FromGlobal();
        $this->can_change_password = $this->user->canChangePasswordBy($vx->user);

        $this->usergroup = collect($this->user->UserGroup())->map(function ($o) {
            return $o->name;
        })->join(", ");

        $this->usergroups = collect($this->user->UserGroup())->map(function ($o) {
            return $o->name;
        })->toArray();


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
        $els = EventLog::Query(["user_id" => $this->user->user_id])->order(["eventlog_id" => "desc"])->limit(10);
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
