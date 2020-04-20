<div class="row" data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}" {{ $component->render('include.props') }}>
@foreach ($component->getModel()->elements() as $element)
    {!! $element->getModelViewerComponent()->render('default') !!}
@endforeach
</div>