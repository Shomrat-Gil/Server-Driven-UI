<?php

abstract class AbstractComponentClass
{
    protected $componentData = [];

    final public static function make(): static
    {
        return new static();
    }

    final public function render(): array
    {
        return $this->componentData;
    }

    final public function setStyle(array $style): static
    {
        return $this->assignComponentData('style', $style);
    }

    final public function setLayout(null|string $layout): static
    {
        //ROW or column
        return $this->assignComponentData('layout', $layout);
    }

    final protected function assignComponentData(string $key, mixed $value): static
    {
        $this->componentData[$key] = $value;
        return $this;
    }

    final protected function setComponentDefault(string $key, bool $isArray = false): mixed
    {
        if (!array_key_exists($key, $this->componentData)) {
            $val = null;
            if ($isArray) {
                $val = [];
            }
            $this->componentData[$key] = $val;
        }
        return $this->componentData[$key];
    }
}

class LabelComponent extends AbstractComponentClass
{
    public function setTitle(null|TextStyleCard $title): static
    {
        return $this->assignComponentData('title', $title);
    }
}

class HeadingComponent extends AbstractComponentClass
{
    public function setTitle(null|TextStyleCard $title): static
    {
        return $this->assignComponentData('title', $title);
    }

    public function setSubTitle(null|TextStyleCard $subTitle): static
    {
        return $this->assignComponentData('sub_title', $subTitle);
    }

}

class TextStyleCard extends AbstractComponentClass
{

    public function setValue(mixed $value): static
    {
        return $this->assignComponentData('value', $value);
    }

    public function setColor(null|string $color): static
    {
        return $this->assignComponentData('color', $color);
    }

    public function setBackgroundColor(null|string $color): static
    {
        return $this->assignComponentData('background_color', $color);
    }

    public function setBold(bool $bold): static
    {
        return $this->assignComponentData('bold', $bold);
    }

    public function setItalic(bool $italic): static
    {
        return $this->assignComponentData('italic', $italic);
    }

    public function setUnderline(bool $underline): static
    {
        return $this->assignComponentData('underline', $underline);
    }

    public function setInline(bool $inline): static
    {
        return $this->assignComponentData('inline', $inline);
    }

    public function setLinethrough(bool $linethrough): static
    {
        return $this->assignComponentData('linethrough', $linethrough);
    }

    public function setTextAlign(string $align): static
    {
        return $this->assignComponentData('text_align', $align);
    }

    public function setHeadings(int $heading): static
    {
        return $this->assignComponentData('heading', $heading);
    }

    public function setClass(string $class): static
    {
        $classes = $this->setComponentDefault('class', true);
        $classes[] = $class;
        return $this->assignComponentData('class', $classes);
    }
}

class InputFormComponent extends AbstractComponentClass
{
    public function setName(string $name): static
    {
        return $this->assignComponentData('name', $name);
    }

    public function setLabel(string $label): static
    {
        return $this->assignComponentData('label', $label);
    }

    public function setValue(string $value): static
    {
        return $this->assignComponentData('value', $value);
    }

    public function setType(string $type): static
    {
        // need to add a validation e.g., text, password, email, etc.
        //need to be an Enum based value
        return $this->assignComponentData('type', $type);
    }

    public function setPlaceholder(string $placeholder): static
    {
        return $this->assignComponentData('placeholder', $placeholder);
    }

    public function setRequired(bool $required = true): static
    {
        return $this->assignComponentData('required', $required);
    }

    public function setInline(bool $inline): static
    {
        $this->assignComponentData('inline', $inline);
        return $this;
    }

    /**
     * The validation method for the UI to use
     */
    public function setValidation(string $method): static
    {
        return $this->assignComponentData('validation', $method);
    }
}

class DropdownComponent extends AbstractComponentClass
{
    public function setName(string $name): static
    {
        return $this->assignComponentData('name', $name);
    }

    public function setLabel(string $label): static
    {
        return $this->assignComponentData('label', $label);
    }

    public function setSelectedValue(string $value): static
    {
        return $this->assignComponentData('selected_value', $value);
    }

    public function addOption(string $value, string $label): static
    {
        $options = $this->setComponentDefault('options', true);
        $options[] = ['value' => $value, 'label' => $label];
        return $this->assignComponentData('options', $options);
    }

    public function setInline(bool $inline): static
    {
        $this->assignComponentData('inline', $inline);
        return $this;
    }

    /**
     * The validation method for the UI to use
     */
    public function setValidation(string $method): static
    {
        return $this->assignComponentData('validation', $method);
    }
}

class ActionCard extends AbstractComponentClass
{
    public function setLabel(TextStyleCard $label): static
    {
        $displayStyle = $this->setComponentDefault('display_style');
        if (is_null($displayStyle)) {
            $this->setDisplayStyle();
        }
        return $this->assignComponentData('label', $label);
    }

    public function setBorderColor(bool $color): static
    {
        return $this->assignComponentData('border_color', $color);
    }

    public function setStyleOutline(): static
    {
        return $this->setDisplayStyle(false);
    }

    public function setNavigationKey(string $navigationKey, null|int $id): static
    {
        if (!is_null($id)) {
            $navigationKey .= ':' . $id;
        }
        return $this->assignComponentData('navigation_key', $navigationKey);
    }

    public function setSubmitForm(string $submitFormUrl, string $submitFormMethod = 'POST'): static
    {
        $submitForm = [
            'url' => $submitFormUrl,
            'method' => $submitFormMethod,
        ];
        return $this->assignComponentData('submit_form', $submitForm);
    }

    public function setSubmitConfirmationMessage(string $confirmMessage): static
    {
        return $this->assignComponentData('submit_form_cnfirmation', $confirmMessage);
    }

    private function setDisplayStyle(bool $isFill = true): static
    {
        $val = 'OUTLINE';
        if ($isFill) {
            $val = 'FILL';
        }
        return $this->assignComponentData('display_style', $val);
    }

}

class SdUI
{
    private $uiData = [];

    public static function make(null|string $type = null): static
    {
        $static = new static();
        if ($type === null) {
            $type = 'layout';
        }
        //ToDo validation against tyle list, for example: "layout", "carousel",  "gallery" etc.
        $static->uiData['_type'] = $type;
        return $static;
    }

    public function append(SdUI|AbstractComponentClass $element, ?string $groupingKey = null): static
    {
        if ($element instanceof AbstractComponentClass) {
            $element = $this->assignElement($element);
        } else {
            $element = $element->render();
        }

        if ($groupingKey !== null) {
            $groupedElement = $this->groupElements([$element], $groupingKey);
            $this->uiData['components'] = array_merge_recursive($this->uiData['components'] ?? [], $groupedElement);
        } else {
            $this->uiData['components'][] = $element;
        }

        return $this;
    }

    public function add(SdUI|AbstractComponentClass $element): static
    {

        $element = $this->assignElement($element);

        //TO-DO Need to convert into snake case
        $key = str_replace('Component', '', $element['_type']);

        $this->uiData[$key] = $element;

        return $this;
    }

    public function appendAction(ActionCard $action): static
    {
        $this->append($action, 'actions');
        return $this;
    }

    public function setCurrentPageFetch(string $url, string $method = 'GET'): static
    {
        $this->uiData['fetch'] = [
            'url' => $url,
            'method' => $method,
        ];

        return $this;
    }

    public function setPayload(string $key, mixed $value): static
    {
        if (!array_key_exists('payload', $this->uiData)) {
            $this->uiData['payload'] = [];
        }
        $this->uiData['payload'][$key] = $value;
        return $this;
    }

    public function addRow(): static
    {
        $this->uiData['_type'] = 'grid';
        if (!array_key_exists('rows', $this->uiData)) {
            $this->uiData['rows'] = [];
        }

        $this->uiData['rows'][] = [];

        return $this;
    }

    public function appendColumn(SdUI|AbstractComponentClass $element): static
    {
        if (!array_key_exists('rows', $this->uiData)) {
            $this->addRow();
        }
        $rowKey = array_key_last($this->uiData['rows']);
        if (!array_key_exists('column', $this->uiData['rows'][$rowKey])) {
            $this->uiData['rows'][$rowKey]['column'] = [];
        }
        $this->uiData['rows'][$rowKey]['column'][] = $this->assignElement($element);

        return $this;
    }

    private function assignElement(SdUI|AbstractComponentClass $element): array
    {
        $type = get_class($element);
        return [
            '_type' => $type,
            '_key' => md5($type),
            'data' => $element->render()
        ];
    }

    private function groupElements(array $elements, string $groupingKey): array
    {
        $groupedElement = [];
        $groupedElement[$groupingKey] = $elements;

        return $groupedElement;
    }

    public function render()
    {
        return $this->uiData;
    }
}
