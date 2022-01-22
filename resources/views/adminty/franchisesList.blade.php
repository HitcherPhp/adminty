@if(isset($franchises))
    @if($all)
        <a href="{{ route('select_franchise', ['id' => 0, 'name' => 'Все франшизы']) }}">
            <div class="media userlist-box">
                <div class="media-body">
                    <div style="color: #34495e" class="f-13 chat-header">Все франшизы</div>
                </div>
            </div>
        </a>
    @endif
    @foreach ($franchises as $f)
        <a href="{{ route('select_franchise', $f) }}">
            <div class="media userlist-box">
                <div class="media-body">
                    @if($f['user_id'] == $user_id)
                        <div style="color: #ffac05" class="f-13 chat-header">{{ $f['name'] }}</div>
                    @else
                        <div style="color: #6610f2" class="f-13 chat-header">{{ $f['name'] }}</div>
                    @endif
                </div>
            </div>
        </a>
    @endforeach
@endif


