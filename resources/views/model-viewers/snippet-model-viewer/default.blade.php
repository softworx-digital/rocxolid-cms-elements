<div {!! $component->getElementSnippetDataAttributes() !!}>
    {!! $component->getWrappedComponent()->render($component->getWrappedComponent()->getModel()->getTemplate()) !!}
</div>