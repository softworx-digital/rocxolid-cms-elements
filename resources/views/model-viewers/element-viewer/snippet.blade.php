<div {{ $component->render('include.props') }} data-preview="https://github.com/Kademi/keditor/raw/master/examples/snippets/preview/text.png" data-keditor-title="{{ $component->translate('model.title.singular') }}" data-keditor-categories="Text">
    {!! $component->getModel()->getModelViewerComponent()->render('snippet-content') !!}
</div>