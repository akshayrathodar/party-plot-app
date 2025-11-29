<form action="{{ $url }}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger m-1" onclick="return confirm('Are you sure?');" type="submit">
        <i class="fa fa-trash" aria-hidden="true"></i>
    </button>
</form>
