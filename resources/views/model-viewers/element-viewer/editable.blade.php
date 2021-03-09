@if (!$component->getModel()->getDependenciesDataProvider()->isReady())
<div class="editable"@if (isset($content_part_name)) data-name="{{ $content_part_name }}"@endif>
@endif
    @elementContent($content_part_name, $content_part_assignments, $default_view_name, $default_view_assignments)
@if (!$component->getModel()->getDependenciesDataProvider()->isReady())
</div>
@endif