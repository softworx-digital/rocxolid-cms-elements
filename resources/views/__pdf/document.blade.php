<style type="text/css">
	* { font-family: Arial; }
</style>
<page backtop="5mm" backbottom="14mm" backleft="10mm" backright="10mm" pagegroup="new">
@if ($document->estate()->exists())
Nehnuteľnosť: {{ $document->estate->getTitle() }}
@endif
<br />
@if ($document->tenant()->exists())
Nájomník: {{ $document->tenant->getTitle() }}
@endif


@foreach ($document->document->elements() as $element)
    {!! $element->getModelViewerComponent()->setViewPackage('pdf')->render($element->getPivotData()->get('template')) !!}
@endforeach
</page>