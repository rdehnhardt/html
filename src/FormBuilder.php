<?php namespace Rdehnhardt\Html;

use Collective\Html\FormBuilder as IlluminateFormBuilder;

class FormBuilder extends IlluminateFormBuilder
{
    /**
     * An array containing the currently opened form groups.
     *
     * @var array
     */
    protected $groupStack = array();

    /**
     * Open a new form group.
     *
     * @param  string $name
     * @param  mixed $label
     * @param  array $options
     * @return string
     */
    public function openGroup($name, $label = null, $options = array())
    {
        $options = $this->appendClassToOptions('form-group', $options);
        $this->groupStack[] = $name;
        $label = $label ? $this->label($name, $label) : '';

        return '<div' . $this->html->attributes($options) . '>' . $label;
    }

    /**
     * Close out the last opened form group.
     *
     * @return string
     */
    public function closeGroup()
    {
        $name = array_pop($this->groupStack);
        $errors = $this->getFormattedErrors($name);

        return $errors . '</div>';
    }

    /**
     * Open a new form actions.
     *
     * @param  array $options
     * @return string
     */
    public function openFormActions($options = array())
    {
        $options = $this->appendClassToOptions('form-actions', $options);

        return '<div' . $this->html->attributes($options) . '>';
    }

    /**
     * Close out the last opened form group.
     *
     * @return string
     */
    public function closeFormActions()
    {
        return '</div>';
    }

    /**
     * Create a form input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function input($type, $name, $value = null, $options = array())
    {
        if ($type != 'submit') {
            $options = $this->appendClassToOptions('form-control', $options);
        }

        if ($this->hasErrors($name)) {
            $options = $this->appendClassToOptions('is-invalid', $options);
        }

        return parent::input($type, $name, $value, $options);
    }

    /**
     * Create a select box field.
     *
     * @param  string $name
     * @param  array $list
     * @param  string $selected
     * @param array $selectAttributes
     * @param array $optionsAttributes
     * @param array $optgroupsAttributes
     * @return string
     */
    public function select($name, $list = [], $selected = null, array $selectAttributes = [], array $optionsAttributes = [], array $optgroupsAttributes = [])
    {
        $selectAttributes = $this->appendClassToOptions('form-control', $selectAttributes);

        if ($this->hasErrors($name)) {
            $selectAttributes = $this->appendClassToOptions('is-invalid', $selectAttributes);
        }

        return parent::select($name, $list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes);
    }

    /**
     * Create a plain form input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function plainInput($type, $name, $value = null, $options = array())
    {
        return parent::input($type, $name, $value, $options);
    }

    /**
     * Create a plain select box field.
     *
     * @param  string $name
     * @param  array $list
     * @param  string $selected
     * @param  array $options
     * @return string
     */
    public function plainSelect($name, $list = array(), $selected = null, $options = array())
    {
        return parent::select($name, $list, $selected, $options);
    }

    /**
     * Create a checkable input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  mixed $value
     * @param  bool $checked
     * @param  array $options
     * @return string
     */
    protected function checkable($type, $name, $value, $checked, $options)
    {
        $checked = $this->getCheckedState($type, $name, $value, $checked);

        if ($checked) {
            $options['checked'] = 'checked';
        }

        return parent::input($type, $name, $value, $options);
    }

    /**
     * Create a checkbox input field.
     *
     * @param  string $name
     * @param  mixed $value
     * @param  mixed $label
     * @param  bool $checked
     * @param  array $options
     * @return string
     */
    public function checkbox($name, $value = 1, $label = null, $checked = null, $options = array())
    {
        if ($this->hasErrors($name)) {
            $options = $this->appendClassToOptions('is-invalid', $options);
        }

        $checkable = parent::checkbox($name, $value, $checked, $options);

        return $this->wrapCheckable($label, 'checkbox', $checkable);
    }

    /**
     * Create a radio button input field.
     *
     * @param  string $name
     * @param  mixed $value
     * @param  mixed $label
     * @param  bool $checked
     * @param  array $options
     * @return string
     */
    public function radio($name, $value = null, $label = null, $checked = null, $options = array())
    {
        if ($this->hasErrors($name)) {
            $options = $this->appendClassToOptions('is-invalid', $options);
        }

        $checkable = parent::radio($name, $value, $checked, $options);

        return $this->wrapCheckable($label, 'radio', $checkable);
    }

    /**
     * Create an inline checkbox input field.
     *
     * @param  string $name
     * @param  mixed $value
     * @param  mixed $label
     * @param  bool $checked
     * @param  array $options
     * @return string
     */
    public function inlineCheckbox($name, $value = 1, $label = null, $checked = null, $options = array())
    {
        if ($this->hasErrors($name)) {
            $options = $this->appendClassToOptions('is-invalid', $options);
        }

        $checkable = parent::checkbox($name, $value, $checked, $options);

        return $this->wrapInlineCheckable($label, 'checkbox', $checkable);
    }

    /**
     * Create an inline radio button input field.
     *
     * @param  string $name
     * @param  mixed $value
     * @param  mixed $label
     * @param  bool $checked
     * @param  array $options
     * @return string
     */
    public function inlineRadio($name, $value = null, $label = null, $checked = null, $options = array())
    {
        if ($this->hasErrors($name)) {
            $options = $this->appendClassToOptions('is-invalid', $options);
        }

        $checkable = parent::radio($name, $value, $checked, $options);

        return $this->wrapInlineCheckable($label, 'radio', $checkable);
    }

    /**
     * Create a textarea input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function textarea($name, $value = null, $options = array())
    {
        $options = $this->appendClassToOptions('form-control', $options);

        if ($this->hasErrors($name)) {
            $options = $this->appendClassToOptions('is-invalid', $options);
        }

        return parent::textarea($name, $value, $options);
    }

    /**
     * Create a plain textarea input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function plainTextarea($name, $value = null, $options = array())
    {
        return parent::textarea($name, $value, $options);
    }

    /**
     * Append the given class to the given options array.
     *
     * @param  string $class
     * @param  array $options
     * @return array
     */
    private function appendClassToOptions($class, array $options = array())
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' ' : '';
        $options['class'] .= $class;

        return $options;
    }

    /**
     * Determine whether the form element with the given name
     * has any validation errors.
     *
     * @param  string $name
     * @return bool
     */
    private function hasErrors($name)
    {
        if (is_null($this->session) || !$this->session->has('errors')) {
            return false;
        }

        $errors = $this->session->get('errors');

        return $errors->has($this->transformKey($name));
    }

    /**
     * Get the formatted errors for the form element with the given name.
     *
     * @param  string $name
     * @return string
     */
    private function getFormattedErrors($name)
    {
        if (!$this->hasErrors($name)) {
            return '';
        }

        $errors = $this->session->get('errors');

        return $errors->first($this->transformKey($name), '<div class="invalid-feedback">:message</div>');
    }

    /**
     * Wrap the given checkable in the necessary wrappers.
     *
     * @param  mixed $label
     * @param  string $type
     * @param  string $checkable
     * @return string
     */
    private function wrapCheckable($label, $type, $checkable)
    {
        return '<div class="' . $type . '"><label>' . $checkable . ' ' . $label . '</label></div>';
    }

    /**
     * Wrap the given checkable in the necessary inline wrappers.
     *
     * @param  mixed $label
     * @param  string $type
     * @param  string $checkable
     * @return string
     */
    private function wrapInlineCheckable($label, $type, $checkable)
    {
        return '<div class="' . $type . '-inline">' . $checkable . ' ' . $label . '</div>';
    }
}
