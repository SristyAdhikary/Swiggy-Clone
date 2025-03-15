<?php
// order_tracking.php

if (!isset($_GET['order_id'])) {
    header("Location: index.php"); // Redirect if no order_id is provided
    exit;
}

$order_id = htmlspecialchars($_GET['order_id']); // Sanitize the order_id
$delivery_person = "Rahul"; // Delivery person name
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
    <link rel="icon" href="./assests/logo.avif" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        #map {
            height: 300px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        /* General styles for the status container */
.status-container {
    background-color: #f9f9f9; /* Light background color */
    border: 1px solid #e0e0e0; /* Subtle border */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    padding: 20px; /* Padding inside the container */
    margin: 20px 0; /* Margin for spacing */
    transition: transform 0.2s; /* Smooth hover effect */
}

/* Styling for the status messages */
.status {
    font-size: 20px; /* Increased font size for better visibility */
    text-align: center; /* Center the text */
    font-weight: bold; /* Make the text bold */
    color: #333; /* Dark text color */
    margin-bottom: 10px; /* Space between messages */
}

/* Icon styles */
.status-icon {
    font-size: 20px; 
    color: #ff5c00; /* Swiggy-like orange color for icons */
    margin-bottom: 10px; /* Space below the icon */
}

/* Hover effect for status container */
.status-container:hover {
    transform: scale(1.02); /* Slightly increase size on hover */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
}

/* Estimated time styling */
.estimated-time {
    font-size: 18px; /* Font size for estimated time */
    color: #555; /* Slightly lighter color */
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .status {
        font-size: 18px; /* Smaller font size on mobile */
    }

    .status-icon {
        font-size: 30px; /* Smaller icon on mobile */
    }
}

        .time {
            font-weight: bold;
            color: #28a745;
        }
        .delivery-info {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            position: relative;
        }
        .delivery-person {
            font-weight: bold;
            color: #ff5c00;
        }
        .call-icon {
            font-size: 20px;
            color: #ff5c00;
            cursor: pointer;
            margin-left: 10px;
            position: absolute;
            top: 22px;
            right: 10px;
        }



        .call-message {
        display: none; /* Initially hidden */
        font-size: 14px; /* Slightly smaller font */
        color: #fff; /* White text for better contrast */
        background-color: #ff5c00; /* Swiggy-like orange background */
        padding: 8px 12px; /* Padding for a nicer look */
        border-radius: 5px; /* Rounded corners */
        margin-top: 5px; /* Space between icon and message */
        position: absolute; /* Position it relative to the delivery-info div */
        top: 50px; /* Adjust this based on your layout */
        right: 10px; /* Align it with the call icon */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
    }


        /* Delivery instructions input */
        .instruction-box {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .instruction-box input {
            width: calc(100% - 16px); /* Adjust width to avoid overflow */
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .instruction-box button {
            background-color: #ff5c00;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        /* Add & Browse for More Meals */
        .more-meals {
            text-align: center;
            margin: 15px 0;
        }
        .more-meals a {
            text-decoration: underline;
            color: #ff5c00;
            cursor: pointer;
        }
        /* Chat box style */
        .chat-box {
            display: none; /* Initially hidden */
            position: fixed;
            bottom: 100px; /* Position the chat box higher */
            right: 20px;
            width: 300px; /* Slightly more compact chat box */
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .chat-box-header {
            background-color: #fff; /* White background */
            color: black; /* Black text */
            padding: 10px;
            font-size: 18px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .chat-box-body {
            padding: 10px;
            max-height: 200px;
            overflow-y: auto;
            display: flex;
            flex-direction: column-reverse; /* Reverse the order of messages */
        }
        .predefined-question {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }
        .predefined-question button {
            background-color: #ff5c00;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .predefined-question button:hover {
            background-color: #e94e00;
        }
        .chat-bubble {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
            max-width: 80%; /* Limit width */
        }
        .chat-bubble-user {
            background-color: #ffe7a1; /* User bubble color */
            margin-left: auto; /* Align to the right */
            text-align: right; /* Text aligned to right */
        }
        .chat-bubble-delivery {
            background-color: #ffeed0; /* Delivery person bubble color */
            margin-right: auto; /* Align to the left */
            text-align: left; /* Text aligned to left */
        }
        /* Chat toggle icon */
        .chat-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ff5c00;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
        /* Typing animation */
        .typing-indicator {
            display: none;
            font-style: italic;
            color: #999;
            margin-bottom: 5px;
        }
        .status-icon {
            margin-left: 8px; /* Space between text and icon */
        }
        .preparing-icon {
            animation: bounce 0.5s ease infinite alternate; /* Add bouncing animation */
        }
        @keyframes bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Track Your Order</h2>
    <div id="map"></div>
    
    <div class="status" id="order-status">
        <span id="status-message">Order Status: Order Placed</span>
        <span id="status-icon" class="status-icon"><i class="fas fa-hourglass-half"></i></span>
        <br>
        Estimated Delivery Time: <span id="estimated-time" class="time">30 minutes</span>
    </div>

    <div class="delivery-info">
        <p>Delivery Person: <span class="delivery-person"><?php echo $delivery_person; ?></span></p>
        <i class="fas fa-phone call-icon" onclick="showMessage()"></i>
        <span class="call-message" id="callMessage"></span> <!-- Placeholder for the message -->
        <p id="delivery-instructions">No instructions yet</p> <!-- Placeholder for delivery instructions -->
    </div>


<div class="instruction-box">
        <input type="text" id="instructions-input" placeholder="Add delivery instructions...">
        <button onclick="submitInstructions()">Submit Instructions</button>
    </div>
    
    <div class="more-meals">
        <a href="index.html">Browse for More Meals</a>
    </div>
</div>

<!-- Chat toggle button -->
<div class="chat-toggle" onclick="toggleChat()">
    <i class="fas fa-comments"></i>
</div>

<!-- Chat box -->
<div class="chat-box" id="chat-box">
    <div class="chat-box-header">Chat with Delivery Person</div>
    <div class="chat-box-body">
        <div class="predefined-question">
            <button onclick="sendQuestion('Where are you?')">Where are you?</button>
            <button onclick="sendQuestion('How long will it take?')">How long will it take?</button>
            <button onclick="sendQuestion('Call me upon arrival')">Call me upon arrival</button>
        </div>
        <div class="typing-indicator" id="typing-indicator">...typing</div>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>





<script>


 // Initialize the order delivery status
 let orderDelivered = false; // Variable to track delivery status

function showMessage() {
    const messageElement = document.getElementById('callMessage');

    // Check if the order has been delivered
    if (orderDelivered) {
        messageElement.textContent = 'Your order has arrived! Enjoy your meal!'; // Message for delivered order
    } else {
        messageElement.textContent = 'Your Swiggy partner is on the way! Do not hesitate to message them'; // Original message
    }

    messageElement.style.display = 'block'; // Make the message visible

    // Optional: Hide the message after a few seconds
    setTimeout(() => {
        messageElement.textContent = ''; // Clear the message
        messageElement.style.display = 'none'; // Hide the message
    }, 3000); // Message will disappear after 3 seconds
}


















    // Initialize the map
    var map = L.map('map').setView([22.5700, 88.3600], 14); // Center of delivery route
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);



    // Submit delivery instructions
    function submitInstructions() {
        var instructions = document.getElementById('instructions-input').value;
        var instructionsDisplay = document.getElementById('delivery-instructions');

        if (instructions.trim() !== "") {
            instructionsDisplay.innerText = "Instructions: " + instructions; // Update the displayed instructions
            document.getElementById('instructions-input').value = ""; // Clear input after submission
        } else {
            instructionsDisplay.innerText = "No instructions yet"; // Show default message if input is empty
        }
    }

    // Define icons for home, restaurant, and bike
    var homeIcon = L.divIcon({
        html: '<i class="fas fa-home fa-2x icon-modern" style="color:black"></i>',
        iconSize: [30, 30],
        className: 'fa-icon'
    });

    var restaurantIcon = L.divIcon({
        html: '<i class="fas fa-utensils fa-2x icon-modern" style="color:black"></i>',
        iconSize: [30, 30],
        className: 'fa-icon'
    });

    var bikeIcon = L.divIcon({
        html: '<i class="fas fa-bicycle fa-2x icon-modern" style="color:#ff5c00"></i>',
        iconSize: [40, 40],
        className: 'fa-icon'
    });

    // Add markers for home and restaurant
    var homeMarker = L.marker([22.5626, 88.3696], { icon: homeIcon }).addTo(map).bindPopup("Home");
    var restaurantMarker = L.marker([22.5786, 88.3489], { icon: restaurantIcon }).addTo(map).bindPopup("Restaurant");

    // Delivery person's bike marker (hidden initially)
    var deliveryPersonMarker = L.marker([22.5786, 88.3489], { icon: bikeIcon }).addTo(map).bindPopup("Delivery Person");

    // Define the delivery route as a polyline (Swiggy-like orange route)
    var deliveryRoute = [
        [22.5786, 88.3489],  // Restaurant
        [22.5700, 88.3600],  // Mid-point
        [22.5626, 88.3696]   // Home
    ];

    var routePolyline = L.polyline(deliveryRoute, { color: '#ff5c00', weight: 4 }).addTo(map);

    // Auto-focus map to fit the route
    map.fitBounds(routePolyline.getBounds());

    // Order status updates and bike movement logic
    var orderStatuses = [
        { status: "Order Placed", icon: "fas fa-check", time: 30, position: 0 },
        { status: "Preparing", icon: "fas fa-utensils preparing-icon", time: 40, position: 0 },
        { status: "Out for Delivery", icon: "fas fa-bicycle", time: 20, position: 1 },
        { status: "Arriving in 5 minutes", icon: "fas fa-clock", time: 5, position: 1 },
        { status: "Delivered", icon: "fas fa-check-circle", time: 0, position: 2 }
    ];

    var currentStatusIndex = 0;

    // Function to move the bike smoothly along the route
    function moveBikeToPosition(targetPosition, delay = 0) {
        setTimeout(() => {
            var currentLatLng = deliveryPersonMarker.getLatLng();
            var targetLatLng = L.latLng(targetPosition);
            var steps = 200; // Increased steps for slower animation
            var stepLat = (targetLatLng.lat - currentLatLng.lat) / steps;
            var stepLng = (targetLatLng.lng - currentLatLng.lng) / steps;

            var stepCount = 0;
            function animateStep() {
                if (stepCount < steps) {
                    var newLat = currentLatLng.lat + stepLat * stepCount;
                    var newLng = currentLatLng.lng + stepLng * stepCount;
                    deliveryPersonMarker.setLatLng([newLat, newLng]);
                    stepCount++;
                    requestAnimationFrame(animateStep);
                }
            }
            animateStep(); // Start the animation
        }, delay);
    }

    function updateStatus() {
        if (currentStatusIndex < orderStatuses.length) {
            var status = orderStatuses[currentStatusIndex];

            // Update status and icon
            document.getElementById('status-message').innerText = "Order Status: " + status.status;
            document.getElementById('status-icon').innerHTML = `<i class="${status.icon} status-icon"></i>`;
            document.getElementById('estimated-time').innerText = status.time > 0 ? status.time + " minutes" : "Delivered";

            // Move the bike only once it's "Out for Delivery"
            if (status.status === "Out for Delivery") {
                moveBikeToPosition(deliveryRoute[status.position], 0); // Move to first point
                setTimeout(() => moveBikeToPosition(deliveryRoute[status.position + 1], 5000), 5000); // Halt for 5 seconds and move
                setTimeout(() => moveBikeToPosition(deliveryRoute[status.position + 2], 5000), 10000); // Halt for another 5 seconds and move
            } else if (currentStatusIndex > 2) {
                var targetPosition = deliveryRoute[status.position];
                moveBikeToPosition(targetPosition); // Move the bike smoothly
            }

            currentStatusIndex++;
            setTimeout(updateStatus, 7000); // Update status every 7 seconds
        }
    }

    updateStatus(); // Start the status update

    // Chatbox toggle functionality (single tap)
    function toggleChat() {
        var chatBox = document.getElementById('chat-box');
        chatBox.style.display = chatBox.style.display === 'none' ? 'block' : 'none';
    }

    // Handle the predefined chat questions
    function sendQuestion(question) {
        var typingIndicator = document.getElementById('typing-indicator');
        typingIndicator.style.display = 'block'; // Show typing animation

        setTimeout(() => {
            var response = "";
            if (currentStatusIndex >= orderStatuses.length) { // If order is delivered
                response = "Your order has arrived! Enjoy your meal!";
            } else {
                switch (question) {
                    case "Where are you?":
                        response = "I'm on the way, just a few minutes away!";
                        break;
                    case "How long will it take?":
                        response = "It will take approximately " + document.getElementById('estimated-time').innerText + ".";
                        break;
                    case "Call me upon arrival":
                        response = "Sure, I will give you a call when I reach.";
                        break;
                    default:
                        response = "Sorry, I can't answer that right now.";
                }
            }
            typingIndicator.style.display = 'none'; // Hide typing animation
            
            // Create a new chat bubble and prepend it
            var chatResponse = document.createElement('div');
            chatResponse.classList.add('chat-bubble', 'chat-bubble-delivery');
            chatResponse.innerText = response;
            document.querySelector('.chat-box-body').prepend(chatResponse); // Prepend the latest message
            
            // Keep scroll at the top since messages are prepended
            document.querySelector('.chat-box-body').scrollTop = 0; 
        }, 1500); // Simulate typing delay
    }

    // Submit delivery instructions
    function submitInstructions() {
        var instructions = document.getElementById('instructions-input').value;
        if (instructions.trim() !== "") {
            document.getElementById('delivery-instructions').innerText = "Instructions: " + instructions;
            document.getElementById('instructions-input').value = ""; // Clear input after submission
        }
    }
</script>

</body>
</html>
