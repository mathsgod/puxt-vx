<el-card>
    {{form|raw}}
</el-card>

<?php
return ["get" => function (VX $context) {

    $form = $context->createForm();
    $form->setData(["input1" => "input1", "select1" => 2,"cb1"=>true]);
    $form->add("Input")->input("input1");
    $form->add("Select")->select("select1", ["A" => 1, "B" => 2, "C" => 3]);
    $form->add("Date")->date("date1");

    $form->add("CB")->checkbox("cb1");
    $this->form = $form;
}];
