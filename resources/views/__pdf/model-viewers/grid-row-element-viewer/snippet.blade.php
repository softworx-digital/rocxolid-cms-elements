<div
    data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}"
    data-preview="https://github.com/Kademi/keditor/raw/master/examples/snippets/preview/row_12.png"
    data-keditor-title="{{ $component->translate('model.title.singular') }}"
    data-keditor-categories="Grid">
    {!! $component->getModel()->addFakeColumns(1)->getModelViewerComponent()->setViewTheme($component->getViewTheme())->render() !!}
</div>

<div
    data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}"
    data-preview="https://github.com/Kademi/keditor/raw/master/examples/snippets/preview/row_12.png"
    data-keditor-title="{{ $component->translate('model.title.singular') }}"
    data-keditor-categories="Grid">
    {!! $component->getModel()->addFakeColumns(2)->getModelViewerComponent()->setViewTheme($component->getViewTheme())->render() !!}
</div>

<div
    data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}"
    data-preview="https://github.com/Kademi/keditor/raw/master/examples/snippets/preview/row_12.png"
    data-keditor-title="{{ $component->translate('model.title.singular') }}"
    data-keditor-categories="Grid">
    {!! $component->getModel()->addFakeColumns(3)->getModelViewerComponent()->setViewTheme($component->getViewTheme())->render() !!}
</div>