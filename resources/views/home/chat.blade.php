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
        }

        .navbar {
            background-color: #ffcc00;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
        }

        #chat-container {
            display: flex;
            margin: 20px;
        }

        #contacts-list {
            width: 300px;
            height: 500px;
            overflow-y: auto;
            background-color: white;
            border-radius: 0.75rem;
            border: 1px solid #ced4da;
            margin-right: 20px;
            padding: 10px;
        }

        .contact-container {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }

        .contact-container img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .contact-container:hover {
            background-color: #007bff;
            color: white;
        }

        #talkjs-container {
            flex: 1;
            height: 500px;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: rgba(0, 0, 0, 0.05);
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        li {
            list-style-type: none;
        }

        .navbar-nav .nav-link {
            color: black !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">GOLD SMITH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chat') }}">Chat</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.show') }}">Profile</a></li>
                </ul>
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
                <!-- Contacts will be loaded here dynamically -->
            </div>
            <div id="talkjs-container">
                <span class="loading-text">Loading chat...</span>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Chat Application. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                console.log('Selected user:', otherUser);

                // Create a Talk.User instance for the selected user
                const otherUserTalk = new Talk.User({
                    id: otherUser.id,
                    name: otherUser.name,
                    email: otherUser.email // Add any other required fields
                });

                // Create or get the conversation
                const conversation = session.getOrCreateConversation(Talk.oneOnOneId(session.me, otherUserTalk));
                conversation.setParticipant(session.me);
                conversation.setParticipant(otherUserTalk);

                // Select the conversation in the chatbox
                chatbox.select(conversation);
                console.log('Conversation selected:', conversation);
            } else {
                console.error('User not found:', userId);
            }
        }

        $(document).ready(function () {
            loadContacts();

            function loadContacts() {
                const usertype = "{{ $loggedInUser->usertype }}"; // Get the usertype from loggedInUser

                $.ajax({
                    url: '{{ route('fecth-contact', '') }}' + '/' + usertype,
                    type: 'GET',
                    success: function (response) {
                        console.log('Response:', response); // Log the entire response

                        if (response.success && Array.isArray(response.data)) {
                            $('#contacts-list').empty();
                            $('#contacts-list').append('<h2>Contacts</h2>');

                            response.data.forEach(function (user) {
                                // If the logged-in user is an admin, show all users
                                if (usertype === 'admin' && user.usertype === 'use') {
                                    const contactHtml = `
                                        <div class="contact-container" onclick="selectUser(${user.id})">
                                            <span>${user.email ?? 'No email'}</span>
                                        </div>
                                    `;
                                    $('#contacts-list').append(contactHtml);
                                }
                                // If the logged-in user is not an admin, show only admin users in the list
                                else if (usertype === 'user' && user.usertype === 'admin') {
                                    const contactHtml = `
                                        <div class="contact-container" onclick="selectUser(${user.id})">
                                            <span>${user.email ?? 'No email'}</span>
                                            <span class="admin-label"> (Admin)</span>
                                        </div>
                                    `;
                                    $('#contacts-list').append(contactHtml);
                                }
                            });
                        } else {
                            console.error('No contacts found or invalid response format');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching contacts:', error);
                    }
                });
            }

            initializeTalkJS().catch(error => console.error('Error initializing TalkJS:', error));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
