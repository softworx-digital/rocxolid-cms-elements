<div
    data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}"
    data-preview="https://github.com/Kademi/keditor/raw/master/examples/snippets/preview/text.png"
    data-keditor-title="{{ $component->translate('model.title.singular') }}"
    data-keditor-categories="Text">
    {!! $component->getModel()->getModelViewerComponent()->setViewTheme($component->getViewTheme())->render() !!}
</div>