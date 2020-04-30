<div class="{{ $component->getModel()->gridLayoutClass() }}" data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}" {{ $component->render('include.props') }}>
    @yield($component->getDomId($component->getModel(), 'section'), 'undefined')
</div>