<div class="d-inline-block position-relative" wire:poll.10s="refreshNotifications">
    <a href="#" class="nav-link" id="notificationDropdown" role="button" data-toggle="dropdown" aria-expanded="false" style="color: #3EA293; font-size: 1.2rem; margin-right: 15px;">
        <i class="fas fa-bell"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; margin-top: 5px; margin-left: -8px;">
                {{ $unreadCount }}
                <span class="sr-only">unread messages</span>
            </span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="notificationDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
        <span class="dropdown-item dropdown-header font-weight-bold">Notifications</span>
        <div class="dropdown-divider"></div>
        
        @forelse($notifications as $notification)
            @php
                $isVideoCall = isset($notification->data['type']) && $notification->data['type'] == 'video_call';
            @endphp

            <div class="dropdown-item border-bottom p-2 {{ $notification->read_at ? '' : 'bg-light' }}" style="white-space: normal; cursor: {{ $isVideoCall ? 'default' : 'pointer' }};">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-start" style="flex: 1;" 
                        @if(!$isVideoCall) 
                            wire:click.prevent="markAsRead('{{ $notification->id }}')" 
                        @endif
                    >
                        <div class="mr-2 mt-1">
                            @if(isset($notification->data['type']) && $notification->data['type'] == 'note')
                                <i class="fas fa-sticky-note text-primary"></i>
                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'appointment')
                                <i class="fas fa-calendar-alt text-success"></i>
                            @elseif($isVideoCall)
                                <i class="fas fa-video text-danger"></i>
                            @else
                                <i class="fas fa-info-circle text-secondary"></i>
                            @endif
                        </div>
                        <div>
                            <p class="mb-0 small font-weight-bold text-dark">{{ $notification->data['summary'] ?? 'New Notification' }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-muted p-0 ml-2" wire:click.stop="deleteNotification('{{ $notification->id }}')" title="Remove" style="text-decoration: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="dropdown-divider"></div>
        @empty
            <a href="#" class="dropdown-item dropdown-footer text-center small text-muted">No notifications</a>
        @endforelse
    </div>
</div>
