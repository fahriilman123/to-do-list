<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Simple To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      rel="stylesheet"
    />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>
<body>

<div class="todo-container">
    <h2>📝 Simple To-Do List</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form tambah to-do -->
    <form action="{{ route('todos.add') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input
              type="text"
              name="title"
              class="form-control"
              placeholder="Tambahkan tugas..."
              required
              autofocus
            />
            <button type="submit" class="btn btn-primary" title="Tambah tugas">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </form>

    <!-- Daftar to-do -->
    <h5>Belum Dikerjakan</h5>
    <ul class="list-group mb-4">
        @forelse ($todosPending as $todo)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <form action="{{ route('todos.complete', $todo->id) }}" method="POST" class="d-flex align-items-center w-100">
                    @csrf
                    @method('PATCH')
                    <label for="todo-{{ $todo->id }}" class="mb-0 flex-grow-1">{{ $todo->title }}</label>
                    <input type="checkbox" name="is_completed" value="1" id="todo-{{ $todo->id }}" class="form-check-input me-3" style="cursor: pointer;" onchange="this.form.submit()">
                </form>
            </li>
        @empty
            <li class="list-group-item text-center">Tidak ada tugas yang belum dikerjakan.</li>
        @endforelse
    </ul>

    <h5>Sudah Dikerjakan</h5>
    <ul class="list-group">
        @forelse ($todosCompleted as $todo)
            <li class="list-group-item d-flex justify-content-between align-items-center completed todo-item">
                {{ $todo->title }}
                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('Yakin hapus tugas ini?')" class="ms-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" title="Hapus tugas">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </li>
        @empty
            <li class="list-group-item text-center">Belum ada tugas yang sudah dikerjakan.</li>
        @endforelse
    </ul>



</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
