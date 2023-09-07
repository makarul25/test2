<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
	Open Form
</button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button wire:click="resetInputFields()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn"></span>
                </button>
            </div>
           <div class="modal-body">         
           <form>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Title:</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Give Title" wire:model.lazy="title">
                    @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput2">Body:</label>
                    <textarea type="email" class="form-control" id="exampleFormControlInput2" wire:model.defer="body" placeholder="Enter Body"></textarea>
                    @error('body') <span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetInputFields()" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                @if($updateMode)
                <button type="button" wire:click.prevent="update()" class="btn btn-primary close-modal">Save changes</button>
                @else
                <button type="button" wire:click.prevent="store()" class="btn btn-primary close-modal">Save</button>
                @endif
            </div>
        </div>
    </div>
</div>