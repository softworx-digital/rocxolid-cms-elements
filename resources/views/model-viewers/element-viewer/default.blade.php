<div {{ $component->render('include.props') }}>
    {!! $component->getModel()->getModelViewerComponent()->render('snippet-content') !!}
</div>