<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered 50% Popup Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.7/build/pannellum.css"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.7/build/pannellum.js"></script>
    <style>
        /* Center the main trigger button on the page */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }

          #panorama {
              width: 600px;
              height: 400px;
          }


        .trigger-btn {
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* The Popup Box Configuration */
        dialog {
            /* Takes up 50% of viewport width and height */
            width: 50vw;
            height: 50vh;
            
            /* Ensures it stays perfectly centered */
            margin: auto; 
            
            /* Presentation styling */
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            padding: 0; /* Clear default padding for flex layout inside */
        }

        /* Flex container inside the popup to layout content cleanly */
        .popup-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
            padding: 30px;
        }

        .popup-body {
            flex-grow: 1; /* Pushes the close button to the bottom */
            overflow-y: auto; /* Adds scrollbar if content exceeds 50vh */
        }

        .close-btn {
            align-self: flex-end;
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style the dim background overlay */
        dialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body>

    <button id="openPopup" class="trigger-btn">Open 50% Popup</button>

    <dialog id="myPopup">
        <div class="popup-content">
            <div class="popup-body">
                <h2>Custom HTML Title</h2>
<div id="panorama"></div>
<script>
pannellum.viewer('panorama', {
    "type": "equirectangular",
    "panorama": "sinema360.jpg"
});
</script>

                <hr>
                <p>This popup takes up exactly <b>50% of the entire screen width (50vw)</b> and <b>50% of the screen height (50vh)</b>.</p>
                <p>Because it uses standard HTML, you can place anything you want in here:</p>
                <ul>
                    <li>Images</li>
                    <li>Forms</li>
                    <li>Videos</li>
                </ul>
            </div>
            <button id="closePopup" class="close-btn">Close</button>
        </div>
    </dialog>

    <script>
        const popup = document.getElementById('myPopup');
        const openBtn = document.getElementById('openPopup');
        const closeBtn = document.getElementById('closePopup');

        // Open popup as a modal overlay
        openBtn.addEventListener('click', () => {
            popup.showModal();
        });

        // Close popup
        closeBtn.addEventListener('click', () => {
            popup.close();
        });

        // Optional: Close popup if clicking outside the white box (on the backdrop)
        popup.addEventListener('click', (lightBox) => {
            const dialogDimensions = popup.getBoundingClientRect();
            if (
                lightBox.clientX < dialogDimensions.left ||
                lightBox.clientX > dialogDimensions.right ||
                lightBox.clientY < dialogDimensions.top ||
                lightBox.clientY > dialogDimensions.bottom
            ) {
                popup.close();
            }
        });
    </script>

</body>
</html>