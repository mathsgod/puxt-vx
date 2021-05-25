<el-card>{{form|raw}}</el-card>
<?php
return ["get" => function (VX $context) {

    $form = $context->createForm();
    $form->add("Name")->input("name")->required();
    //$form->add("Name")->select
    $this->form = $form;
}, "post" => function () {

    print_R($_POST);
}];
