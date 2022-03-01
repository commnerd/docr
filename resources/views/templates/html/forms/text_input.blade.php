@include('templates.html.forms.input', [
    'field' => [
        'name' => $field['name'],
        'label' => $field['label'],
        'value' => $field['value'] ?? '',
        'placeholder' => $field['placeholder'] ?? '',
        'type' => 'text',
    ],
])