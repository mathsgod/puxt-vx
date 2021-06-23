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
                                            <router-link to="/User/{{user.user_id}}/setting" class="btn btn-primary">Edit</router-link>
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
                                    <p class="card-text mb-0">{{user.status}}</p>
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
                                        {% if permission[module.name]['R'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-read" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-read"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['U'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-write" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-write"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['C'] %}
                                        {% set checked="checked" %}
                                        {% endif %}
                                        <input type="checkbox" class="custom-control-input" id="admin-create" {{checked}} disabled />
                                        <label class="custom-control-label" for="admin-create"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {% set checked="" %}
                                        {% if permission[module.name]['D'] %}
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
use VX\UserLog;

return [
    "get" => function (VX $vx) {

        $this->user = $vx->object();
        $this->usergroup = collect($this->user->UserGroup()->toArray())->map(function ($o) {
            return $o->name;
        })->join(", ");

        $rt = $vx->ui->createRTable("userlog");
        $rt->order("userlog_id", "desc");
        $rt->add("ID", "userlog_id")->sortable()->searchable("equal");
        $rt->add("Login time", "login_dt")->sortable()->searchable("date");
        $rt->add("Logout time", "logout_dt")->sortable()->searchable("date");
        $rt->add("IP address", "ip")->ss();
        $rt->add("Result", "result")->sortable()->searchable("select")->searchOption(array("SUCCESS" => "SUCCESS", "FAIL" => "FAIL"));
        $rt->add("User agent", "user_agent")->searchable();

        $this->userlog_table = $rt;


        $this->modules = $vx->getModules();
        $this->permission = [];
        foreach ($vx->getModules() as $module) {
            $p = [];
            foreach (["C", "R", "U", "D"] as $action) {
                $p[$action] = $vx->allow($module, $action, $this->user);;
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

        //outp($els->toArray());
        //die();




        //die();
    },
    "entries" => [
        "userlog" => function (VX $vx) {
            $obj = $vx->object();
            $rt = $vx->ui->createRTableResponse();
            $rt->source = UserLog::Query(["user_id" => $obj->user_id]);
            return $rt;
        }
    ]


];
