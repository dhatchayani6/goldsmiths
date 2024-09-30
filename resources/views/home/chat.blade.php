<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.talkjs.com/talk.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            color: #495057;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: background-color 0.3s;
        }

        .navbar {
            background-color: #ffcc00;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-brand:hover,
        .navbar-nav .nav-link:hover {
            color: #d1e7dd !important;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            /* Align items to the start */
            margin: auto;
            flex: 1;
            max-width: 1200px;
            /* Optional: Limit the maximum width */
            padding: 20px;
        }

        #chat-container {
            display: flex;
            width: 100%;
            /* Use full width of container */
        }

        #contacts-list {
            overflow-y: auto;
            width: 660px;
            height: 500px;
            background-color: #ffffff;
            border-radius: 0.75rem;
            border: 1px solid #ced4da;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            position: relative;
            animation: fadeIn 0.5s ease-in-out;
            margin-right: 20px;
            /* Space between chat and contacts */
            text-align: center;
        }

        #contacts-list:hover {
            transform: scale(1.02);
        }

        #contacts-list h2 {
            padding: 20px;
            text-align: center;
            color: #007bff;
            border-bottom: 1px solid #d4d4d4;
        }

        .contact-container {
            padding: 15px;
            border-bottom: 1px solid #d4d4d4;
            transition: background-color 0.3s, transform 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .contact-container:hover {
            background-color: #007bff;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .contact-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s;
            border-radius: 0.75rem;
        }

        .contact-container:hover::before {
            opacity: 1;
        }

        .contact-name {
            font-weight: 600;
            transition: color 0.3s;
        }

        .contact-container:hover .contact-name {
            color: #ffffff;
        }

        #talkjs-container {
            width: 100%;
            /* Use full width of chat container */
            height: 500px;
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s;
            animation: fadeIn 0.5s ease-in-out;
        }

        .loading-text {
            font-style: italic;
            color: #6c757d;
        }

        .welcome-text {
            font-weight: 600;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        footer {
            background-color: rgba(0, 0, 0, 0.05);
            color: black;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            transition: background-color 0.3s;
        }



        @media (max-width: 768px) {
            #contacts-list {
                width: 100%;
                /* Make contacts list full width on small screens */
                margin-right: 0;
                /* Remove margin */
                margin-bottom: 20px;
                /* Add space below */
            }

            #talkjs-container {
                width: 100%;
            }

            .container {
                flex-direction: column;
                align-items: center;
            }
        }

        li {
            list-style-type: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Chat Application</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chat') }}">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.show') }}">Profile</a>
                    </li>
                </ul>
                <span class="navbar-text me-3 welcome-text">
                    Welcome, {{ $loggedInUser->name }}!
                </span>
                @if (Auth::check())
                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}" class="nav-link">
                            @csrf
                            <button class="btn btn-outline-danger my-2 my-sm-0">LOGOUT ({{ Auth::user()->name }})</button>
                        </form>
                    </li>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        <div id="chat-container">
            <div id="contacts-list">
                <h2>Contacts</h2>
                @foreach($users as $user)
                                @if(
                                        ($loggedInUser->usertype === 'admin' && $user->usertype !== 'admin') ||
                                        ($loggedInUser->usertype !== 'admin' && $user->usertype === 'admin')
                                    )
                                                <div class="contact-container" onclick="selectUser({{ $user->id }})">
                                                    <div class="contact-name">{{ $user->name ?? 'Unknown' }}</div>
                                                    <span>{{ $user->email ?? 'No email' }}</span>
                                                </div>
                                @endif
                @endforeach
            </div>
            <div id="talkjs-container" class="mb-4">
                <span class="loading-text">Loading chat...</span>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Chat Application. All rights reserved.</p>
    </footer>

    <script type="text/javascript">
        let chatbox;
        let session;

        async function initializeTalkJS() {
            await Talk.ready;

            const me = new Talk.User({ id: "{{ $loggedInUser->id }}", name: "{{ $loggedInUser->name }}" });
            session = new Talk.Session({ appId: "t3gaOQ7O", me });

            chatbox = session.createChatbox();
            chatbox.mount(document.getElementById("talkjs-container"));
        }

        function selectUser(userId) {
            const otherUser = @json($users).find(user => user.id === userId);
            if (otherUser) {
                const conversation = session.getOrCreateConversation(Talk.oneOnOneId(session.me, new Talk.User({ id: otherUser.id, name: otherUser.name })));
                conversation.setParticipant(session.me);
                conversation.setParticipant(new Talk.User({ id: otherUser.id, name: otherUser.name }));
                chatbox.select(conversation);
            }
        }

        initializeTalkJS().catch(error => console.error('Error initializing TalkJS:', error));
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>