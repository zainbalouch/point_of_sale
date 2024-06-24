<a href="{{ route('admin.reservations.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
<form action="{{ route('admin.reservations.destroy', $id) }}" class="my-1 my-xl-0" method="post" style="display: inline-block;">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> Delete</button>
</form>