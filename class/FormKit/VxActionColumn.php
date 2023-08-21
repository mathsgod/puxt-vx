<?php

namespace FormKit;


class VxActionColumn extends ComponentBaseNode
{

    public function addEditButton()
    {
        $this->setAttribute('edit', true);
        return $this;
    }

    public function addViewButton()
    {
        $this->setAttribute('view', true);
        return $this;
    }

    public function addDeleteButton()
    {
        $this->setAttribute('delete', true);
        return $this;
    }


    public function view(bool $view = true)
    {
        $this->setAttribute('view', $view);
        return $this;
    }

    public function edit(bool $edit = true)
    {
        $this->setAttribute('edit', $edit);
        return $this;
    }

    public function delete(bool $delete = true)
    {
        $this->setAttribute('delete', $delete);
        return $this;
    }

    /**
     * @deprecated use delete() instead
     */
    public function showDelete()
    {
        $this->setAttribute('delete', true);
        return $this;
    }

    /**
     * @deprecated use edit() instead
     */
    public function showEdit()
    {
        $this->setAttribute('edit', true);
        return $this;
    }

    /**
     * @deprecated use view() instead
     */
    public function showView()
    {
        $this->setAttribute('view', true);
        return $this;
    }
}
