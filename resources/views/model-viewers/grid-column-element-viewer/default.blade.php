<div {{ $component->render('include.props') }} class="{{ $component->getModel()->gridLayout() }}">
    {!! $component->getModel()->getModelViewerComponent()->render('snippet-content') !!}
</div>