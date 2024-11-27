@if (session('success'))
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #d4edda; background-color: #d4edda; color: #155724; border-radius: 4px;">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; border-radius: 4px;">
        {{ session('error') }}
    </div>
@endif
