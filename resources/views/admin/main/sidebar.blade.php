<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{asset('theme/images/icon/logo.png')}}" alt="Cool Admin"/>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="active has-sub">
                    <a class="js-arrow" href="{{route('admin.profile')}}">
                        <i class="fas fa-tachometer-alt"></i>Profile</a>

                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="{{route('admin.index')}}">
                        <i class="fas fa-copy"></i>Quản lý user</a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="{{route('admin.chat')}}">
                        <i class="fas fa-comments"></i>Chat work </a>
                </li>
                <li class="dropdown dropdown-notifications">
                    <a href="{{route('admin.notification')}}">
                        <i class="fas fa-comments"></i>
                        Notification
                    </a>
                    <div id="notification"  style="height: 50px; background: #00a2e3; color: #ffffff; line-height: 50px;display:none">
                        Bạn có một tin nhắn mới
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
                    <script >
                        $(document).ready(function(){
                            console.log('vao day 1');
                            Pusher.logToConsole = true;
                            // Khởi tạo một đối tượng Pusher với app_key
                            var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
                                cluster: 'ap1',
                                encrypted: true
                            });
                            //Đăng ký với kênh chanel-demo-real-time mà ta đã tạo trong file DemoPusherEvent.php
                            var channel = pusher.subscribe('Notify');
                            //Bind một function addMesagePusher với sự kiện DemoPusherEvent
                            channel.bind('real-time-new-message-db', function ($member) {
                                console.log($member);
                                document.getElementById('notification').style.display='block';
                            });
                        });
                        //function add message
                        // function addMessageDemo() {
                        //     console.log('vao day roi nay')
                        //     document.getElementById('notification').style.display='block';
                        // }

                    </script>
                </li>
            </ul>
        </nav>
    </div>
</aside>