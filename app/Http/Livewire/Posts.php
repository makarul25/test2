<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;



class Posts extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $title, $body, $post_id, $searchTerm;
    public $updateMode = false;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';

    protected $listeners = ['remove'];

    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }
    private function headerConfig()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'body',
            'created_at' => [
                'label' => 'created at',
                'func' => function($value) {
                    return $value->diffForHumans();
                }
            
            ],
            'action' => 'Action'
        ];
    }
    private function resultData()
    {
        return Post::where(function ($query) {
            

            if($this->searchTerm != "") {
                $query->where('title', 'like', '%'.$this->searchTerm.'%');
                $query->orWhere('body', 'like', '%'.$this->searchTerm.'%');
            }
        })
        ->orderBy($this->sortColumn, $this->sortDirection)
        ->paginate(5);
    }


    public function render()
    {
        
        
        //dd($this->posts);
        return view('livewire.posts',[
            'posts' => $this->resultData(),
            'headers' => $this->headerConfig()
        ]);
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function resetInputFields(){
        $this->title = '';
        $this->body = '';
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
  
        Post::create($validatedData);
  
        //session()->flash('message', 'Post Created Successfully.');
        $this->dispatchBrowserEvent('closeModal'); 
        $this->resetInputFields();
        $this->alertSuccess();

    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
  
        $this->updateMode = true;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
  
        $post = Post::find($this->post_id);
        $post->update([
            'title' => $this->title,
            'body' => $this->body,
        ]);
  
        $this->updateMode = false;
  
        //session()->flash('message', 'Post Updated Successfully.');
        $this->dispatchBrowserEvent('closeModal'); 
        $this->alertSuccess();
        $this->resetInputFields();
  
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        //dd($id);
        Post::find($id)->delete();
        //session()->flash('message', 'Post Deleted Successfully.');
    }
    public function alertSuccess()
    {
        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Completed Successfully!', 
                'text' => 'It will list on the table soon.'
            ]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertConfirm($id)
    {
        //dd($id);
        $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',  
                'message' => 'Are you sure?', 
                'text' => 'If deleted, you will not be able to recover this imaginary file!',
                'itemId' => $id
            ]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        /* Write Delete Logic */
        $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'User Delete Successfully!', 
                'text' => 'It will not list on users table soon.'
            ]);
    }

}
