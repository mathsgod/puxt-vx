<?php

namespace FormKit;


use Symfony\Contracts\Translation\TranslatorInterface;

class SchemaNode extends \FormKit\Schema
{
    use FormKitTrait;

    protected $translator;

    function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
        parent::__construct();
        $this->registerClass("router-link", RouterLink::class);

        foreach (glob(__DIR__ . "/Element/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerClass($kebabCase, "FormKit\\Element\\" . $class);
        }

        foreach (glob(__DIR__ . "/Element/Inputs/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerInputClass($kebabCase, "FormKit\\Element\\Inputs\\" . $class);
        }

        foreach (glob(__DIR__ . "/Quasar/*.php") as $file) {
            $class = basename($file, ".php");
            //to kebab-case
            $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $class));
            $this->registerClass($kebabCase, "FormKit\\Quasar\\" . $class);
        }


        $this->registerInputClass("vxForm", VxForm::class);
        $this->registerClass("vx-table", VxTable::class);
        $this->registerClass("vx-table-action-column", VxActionColumn::class);
        $this->registerClass("vx-column", VxColumn::class);
        $this->registerInputClass("vxRepeater", VxRepeater::class);
        $this->registerInputClass("FormCodeInput", VxFormCodeInput::class);
        $this->registerInputClass("FormTinymce", VxFormTinymce::class);
        $this->registerInputClass("vxFormFileInput", VxFormTinymce::class);
        $this->registerClass("vx-link", VxLink::class);

        $this->registerDefaultDOMNodeClass(ElementNode::class);
    }

    /**
     * @deprecated use appendComponent instead
     */
    public function addComponent(string $name, array $props = []): ComponentNode
    {

        //check to kebab case
        $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

        /** @var Schema $schema */
        $schema = $this;
        $schema->registerClass($name, ComponentNode::class);


        $comp = $this->appendHTML("<{$name}></{$name}>")[0];
        foreach ($props as $key => $value) {
            $comp->setAttribute($key, $value);
        }
        return $comp;
    }


    public function getTranslator(): ?TranslatorInterface
    {
        return $this->translator;
    }
}
