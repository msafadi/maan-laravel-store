<div class="dropdown az-header-notification">
    <a href="" @if($unread) class="new" @endif><i class="typcn typcn-bell"></i></a>
    <div class="dropdown-menu">
        <div class="az-dropdown-header mg-b-20 d-sm-none">
            <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
        </div>
        <h6 class="az-notification-title">Notifications</h6>
        <p class="az-notification-text">You have <span id="unread">{{ $unread }}</span> unread notification</p>
        <div class="az-notification-list">
            @foreach ($notifications as $notification)
            <a href="{{ $notification->data['link'] }}?notify_id={{ $notification->id }}">
                <div class="media @if($notification->unread()) new @endif">
                    <div class="az-img-user"><img src="{{ asset('assets/dashboard/img/faces/face2.jpg') }}" alt=""></div>
                    <div class="media-body">
                        <p>{{ $notification->data['body'] }}</p>
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                    </div><!-- media-body -->
                </div><!-- media -->
            </a>
            @endforeach
        </div><!-- az-notification-list -->
        <div class="dropdown-footer"><a href="">View All Notifications</a></div>
    </div><!-- dropdown-menu -->
</div><!-- az-header-notification -->