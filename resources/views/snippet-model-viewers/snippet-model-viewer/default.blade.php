<div {!! $component->getElementSnippetDataAttributes() !!}>
    {!! $component->getWrappedComponent()->render('default', [ 'element_data_provider' => $component ]) !!}
</div>