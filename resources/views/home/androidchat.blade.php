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
        /* Your existing styles here */
    </style>
</head>

<body>
    <div class="container">
        <div id="chat-container">
            <div id="talkjs-container">
                <span class="loading-text">Loading chat between {{ $user1->name }} and {{ $user2->name }}...</span>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        let chatbox;
        let session;

        async function initializeTalkJS() {
            try {
                // Ensure TalkJS is ready
                await Talk.ready;
                console.log('TalkJS initialized');

                // Define the logged-in user
                const me = new Talk.User({
                    id: "{{ $loggedInUser->id ?? $user1->id }}", 
                    name: "{{ $loggedInUser->name ?? $user1->name }}"
                });
                console.log('Logged-in user:', me);

                // Define user1 and user2 for the chat
                const user1 = new Talk.User({
                    id: "{{ $user1->id }}", 
                    name: "{{ $user1->name }}"
                });
                console.log('User 1:', user1);

                const user2 = new Talk.User({
                    id: "{{ $user2->id }}", 
                    name: "{{ $user2->name }}"
                });
                console.log('User 2:', user2);

                // Create a session with the logged-in user
                session = new Talk.Session({
                    appId: "t3gaOQ7O", // Ensure this is the correct App ID
                    me: me
                });
                console.log('Session created:', session);

                // Create or retrieve the conversation between user1 and user2
                const conversation = session.getOrCreateConversation(Talk.oneOnOneId(user1, user2));
                conversation.setParticipant(user1);
                conversation.setParticipant(user2);
                console.log('Conversation created:', conversation);

                // Mount the chatbox
                chatbox = session.createChatbox(conversation);
                chatbox.mount(document.getElementById("talkjs-container"));
                console.log('Chatbox mounted successfully');

                // Hide the loading text
                document.querySelector(".loading-text").style.display = "none";
            } catch (error) {
                console.error('Error initializing TalkJS:', error);
            }
        }

        // Initialize TalkJS when the document is ready
        $(document).ready(function () {
            initializeTalkJS().catch(error => console.error('Error during TalkJS initialization:', error));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
