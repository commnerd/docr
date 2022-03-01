<label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
<select name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}" class="form-control">
    @foreach ($field['options'] as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>