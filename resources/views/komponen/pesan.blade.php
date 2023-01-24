@if (Session::has('succes'))
      <div class="pt-3">
        <div class="alert alert-succes">
          {{ Session::get('succes')}}
        </div>
      </div>
      @endif

      @if ($errors->any())
<div class="pt-3">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $item)
                <li>
                    {{ $item }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif