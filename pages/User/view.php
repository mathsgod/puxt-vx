<el-card>
    <vx-view>
        <vx-view-item label="First name">{{obj.first_name}}</vx-view-item>
        <vx-view-item label="Last name">{{obj.last_name}}</vx-view-item>
        <vx-view-item label="Username">{{obj.username}}</vx-view-item>
    </vx-view>
</el-card>
<?php
return ["get" => function (VX $context) {
    $this->obj = $context->object();
}];
