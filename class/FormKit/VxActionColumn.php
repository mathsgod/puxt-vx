<?php

namespace FormKit;


class VxActionColumn extends ComponentBaseNode
{

    public function addEditButton()
    {
        $this->setProp('edit', true);
        return $this;
    }

    public function addViewButton()
    {
        $this->setProp('view', true);
        return $this;
    }

    public function addDeleteButton()
    {
        $this->setProp('delete', true);
        return $this;
    }


    public function view(bool $view = true)
    {
        $this->setProp('view', $view);
        return $this;
    }

    public function edit(bool $edit = true)
    {
        $this->setProp('edit', $edit);
        return $this;
    }

    public function delete(bool $delete = true)
    {
        $this->setProp('delete', $delete);
        return $this;
    }

    /**
     * @deprecated use delete() instead
     */
    public function showDelete()
    {
        $this->setProp('delete', true);
        return $this;
    }

    /**
     * @deprecated use edit() instead
     */
    public function showEdit()
    {
        $this->setProp('edit', true);
        return $this;
    }

    /**
     * @deprecated use view() instead
     */
    public function showView()
    {
        $this->setProp('view', true);
        return $this;
    }
}
