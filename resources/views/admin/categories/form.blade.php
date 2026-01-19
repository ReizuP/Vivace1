@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ isset($category) ? 'Edit Category' : 'Add New Category' }}</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name ?? '') }}" required placeholder="e.g., Guitars, Pianos, Drums">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">The slug will be automatically generated from the name.</small>
                    </div>

                    @if(isset($category))
                    <div class="mb-3">
                        <label class="form-label">Current Slug</label>
                        <input type="text" class="form-control" value="{{ $category->slug }}" disabled>
                        <small class="text-muted">Slug will be updated based on the new name.</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This category currently has <strong>{{ $category->products->count() }}</strong> product(s).
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($category) ? 'Update Category' : 'Create Category' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-lightbulb"></i> Tips</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Category names should be unique</li>
                    <li>Use clear, descriptive names</li>
                    <li>The slug is auto-generated for SEO-friendly URLs</li>
                    <li>You cannot delete categories that have products</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection