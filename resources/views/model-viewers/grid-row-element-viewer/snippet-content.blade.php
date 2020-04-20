<div class="row">
@foreach ($component->getModel()->elements() as $element)
    {!! $element->getModelViewerComponent()->render('default') !!}
@endforeach
</div>