<div id="{{ $component->getDomId('modal-show', $component->getModel()->getKey()) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            {!! $component->render('modal.modal-header') !!}

            <div class="modal-body">
            {!! $component->getModel()->images()->make()->getModelViewerComponent()->render('gallery.show', [
                'attribute' => 'images',
                'relation' => 'parent',
                'related' => $component->getModel(),
            ]) !!}
            </div>

            {!! $component->render('modal.modal-footer') !!}
        </div>
    </div>
</div>