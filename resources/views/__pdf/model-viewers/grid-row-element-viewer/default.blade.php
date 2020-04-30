<div class="{{ $component->getModel()->gridLayoutClass() }}" data-type="{{ $component->getModel()->getDocumentEditorComponentType() }}" {{ $component->render('include.props') }}>
    <div class="col-sm-12">
        <table class="table table-condensed">
            <tr>
            @foreach ($component->getModel()->elements() as $element)
                {!! $element->getModelViewerComponent()->setViewTheme($component->getViewTheme())->render($element->getPivotData()->get('template')) !!}
            @endforeach
            </tr>
        </table>
    </div>
</div>