@if (session()->has('status'))
<div class="alert alert-info">
    {{ session()->get('status') }}
</div>
@endif
@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif