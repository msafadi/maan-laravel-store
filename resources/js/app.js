require('./bootstrap');

window.Echo.private('Notifications.' + userId)
    .notification((event) => {
        alert(event.title + ": " + event.body)

        $('.az-notification-list').prepend(`<a href="${event.link}?notify_id=${event.id}">
            <div class="media new">
                <div class="az-img-user"><img src="/assets/dashboard/img/faces/face2.jpg" alt=""></div>
                <div class="media-body">
                    <p>${event.body}</p>
                    <span>${(new Date).toLocaleTimeString()}</span>
                </div><!-- media-body -->
            </div><!-- media -->
        </a>`);

        var unread = Number($('#unread').text());
        $('#unread').text(++unread)
    })
