<?php

namespace VX\UI\EL;

use P\HTMLElement;
use P\HTMLTemplateElement;

class Upload extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-upload");
    }

    /**
     * required, request URL
     */
    function setAction(string $action)
    {
        $this->setAttribute("action", $action);
    }

    /**
     * whether uploading multiple files is permitted
     */
    function setHeaders(array $headers)
    {
        $this->setAttribute(":headers", json_encode($headers, JSON_UNESCAPED_UNICODE));
    }

    /**
     * whether uploading multiple files is permitted
     */
    function setMultiple(bool $multiple)
    {
        $this->setAttribute("multiple", $multiple);
    }

    /**
     * additions options of request
     */
    function setData(array $data){
        $this->setAttribute(":data",json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * key name for uploaded file
     */
    function setName(string $name){
        $this->setAttribute("name",$name);
    }

    /**
     * whether cookies are sent
     */
    function setWithCredentials(bool $with_credentials){
        $this->setAttribute("with-credentials",$with_credentials);
    }

    /**
     * whether to show the uploaded file list
     */
    function setShowFileList(bool $show){
        $this->setAttribute("show-file-list",$show);
    }

    /**
     * whether to activate drag and drop mode
     */
    function setDrag(bool $drag){
        $this->setAttribute("drag",$drag);
    }

    /**
     * accepted file types, will not work when thumbnail-mode is true
     */
    function setAccept(string $accept){
        $this->setAccept("accept",$accept);
    }

    /**
     * whether thumbnail is displayed
     */
    function setThumbnailMode(bool $thumbnail_model){
        $this->setAttribute("thumbnail-mode",$thumbnail_model);
    }

    /**
     * default uploaded files, e.g. [{name: 'food.jpg', url: 'https://xxx.cdn.com/xxx.jpg'}]
     */
    function setFileList(array $file_list){
        $this->setAttribute(":file-list",json_encode($file_list,JSON_UNESCAPED_UNICODE));
    }

    /**
     * type of fileList
     * @param string $type text/picture/picture-card
     */
    function setListType(string $type){
        $this->setAttribute("list-type",$type);
    }
    
    /**
     * whether to auto upload file
     */
    function setAutoUpload(bool $auto_upload){
        $this->setAttribute("auto-upload",$auto_upload);
    }

    /**
     * whether to disable upload
     */
    function setDisabled(bool $disabled){
        $this->setAttribute("disabled",$disabled);
    }

    /**
     * maximum number of uploads allowed
     */
    function setLimit(int $limit){
        $this->setAccept(":limit",$limit);
    }

    /**
     * content which triggers file dialog
     */
    function setTriggerSlot(callable $callable){
        $template=new HTMLTemplateElement;
        $template->setAttribute("slot","trigger");
        $callable($template);
        $this->append($template);
    }

    /**
     * content of tips
     */
    function setTipSlot(callable $callable){
        $template=new HTMLTemplateElement;
        $template->setAttribute("slot","tip");
        $callable($template);
        $this->append($template);
    }
}
