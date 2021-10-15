<div id="{{ $component->getDomId('modal-show', $component->getModel()->getKey()) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            {!! $component->render('modal.modal-header') !!}

            <div class="modal-body">
            @if ($component->getModel()->image()->exists())
                {!! $component->getModel()->image->getModelViewerComponent()->render('related.show', [ 'attribute' => 'image', 'relation' => 'parent' ]) !!}
            @else
                {!! $component->getModel()->image()->make()->getModelViewerComponent()->render('related.unavailable', [
                    'attribute' => 'image',
                    'relation' => 'parent',
                    'related' => $component->getModel(),
                ]) !!}
            @endif
            </div>

            {!! $component->render('modal.modal-footer') !!}
        </div>
    </div>
</div>