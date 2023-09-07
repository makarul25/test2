<div>
  
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
  
    
        @include('livewire.create')
    
  
    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created_at</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $key => $post)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->body }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                <button wire:click="edit({{ $post->id }})" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit Form
                </button>
                <button wire:click="alertConfirm({{ $post->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @push('js')
    <script>

window.addEventListener('closeModal', event => {
            document.querySelector('#exampleModal').style.display = "none";
            document.querySelector('.modal-backdrop').remove();
        })
    


window.addEventListener('swal:modal', event => { 
    Swal.fire({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
    });
});
  
window.addEventListener('swal:confirm', event => { 
    Swal.fire({
      title: event.detail.message,
      text: event.detail.text,
      icon: event.detail.type,
      showCancelButton: true,
    })
    .then((willDelete) => {
      if (willDelete.value) {
        @this.call('delete',event.detail.itemId)
      }else {
        @this.call('cancel')
      }
    });
});
 </script>
    @endpush
    <script type="text/javascript">
        window.livewire.on('userStore', () => {
            alert('failed2');
            $('#exampleModal').modal('hide');
            return false;
        });

        
    </script>

    
</div>