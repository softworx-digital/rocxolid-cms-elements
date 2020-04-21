<div class="text-content" data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}" {{ $component->render('include.props') }}>
    {!! $component->getModel()->getModelViewerComponent()->render('snippet-content') !!}
</div>