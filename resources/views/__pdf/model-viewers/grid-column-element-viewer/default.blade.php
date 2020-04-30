<td class="{{ $component->getModel()->gridLayoutClass() }}" data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}" {{ $component->render('include.props') }}>
@foreach ($component->getModel()->elements() as $element)
    {!! $element->getModelViewerComponent()->setViewTheme($component->getViewTheme())->render($element->getPivotData()->get('template')) !!}
@endforeach
</td>