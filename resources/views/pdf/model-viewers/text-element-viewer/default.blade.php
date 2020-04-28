<div class="{{ $component->getModel()->gridLayoutClass() }}" data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}" {{ $component->render('include.props') }}>
    {!! $component->getModel()->content !!}
</div>