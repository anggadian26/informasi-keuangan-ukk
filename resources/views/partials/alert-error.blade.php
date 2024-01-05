<style>
    /* public/css/styles.css */

    #notification {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-bottom: 0;
        padding: 0;
        transform: translateY(-100%);
        transition: transform 0.5s ease-in-out;
    }

    #notification.error {
        background-color: #f1f1f1;
    }

    .alert-content {
        color: #721c24;
        /* Set the text color for error notification */
    }

    #loading-bar {
        width: 100%;
        height: 4px;
        background-color: #721c24;
        /* Set the color for the loading bar */
        margin-bottom: 10px;
    }

    #close-btn {
        margin-top: 10px;
        padding: 10px;
        background-color: #721c24;
        /* Set the background color for the close button */
        color: #fff;
        border: none;
        cursor: pointer;
    }
</style>
<div id="notification-container">
    @if (session('error'))
        <div id="notification" class="error">
            <div id="loading-bar"></div>
            <div id="notification-content" class="alert-content">{{ session('error') }}</div>
            <button id="close-btn" onclick="closeNotification()">Close</button>
        </div>
    @endif

    @if ($errors->any())
        <div id="notification" class="error">
            <div id="loading-bar"></div>
            <div id="notification-content" class="alert-content">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
            <button id="close-btn" onclick="closeNotification()">Close</button>
        </div>
    @endif
</div>

<script>
    // public/js/script.js

    function showNotification(type, message) {
        const notification = document.getElementById('notification');
        const notificationContent = document.getElementById('notification-content');
        const loadingBar = document.getElementById('loading-bar');

        // Set content and style based on the type
        notificationContent.innerHTML = message;
        notification.className = type; // Set class for styling

        // Show loading bar for a short duration
        loadingBar.style.width = '100%';
        setTimeout(() => {
            loadingBar.style.width = '0';
        }, 500);

        // Show the notification
        notification.style.transform = 'translateY(0)';
        setTimeout(() => {
            closeNotification();
        }, 4000); // Close after 4 seconds
    }

    function closeNotification() {
        const notification = document.getElementById('notification');
        notification.style.transform = 'translateY(-100%)';
    }
</script>
