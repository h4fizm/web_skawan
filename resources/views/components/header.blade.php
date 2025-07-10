<div class="card mb-3 p-3">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-primary d-block d-lg-none me-3" id="toggle-sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div>
            @if(auth()->check())
                <h5 class="card-title mb-1">Halo, {{ auth()->user()->name }}!</h5>
                <p class="card-text text-muted">Username: <strong>{{ auth()->user()->username }}</strong></p>
            @else
                <h5 class="card-title mb-1">Hello, Guest!</h5>
            @endif
        </div>
    </div>
</div>
