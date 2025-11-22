<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <title>Lobby</title>

    <style>
        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255,255,255,0.13);
            position: absolute;
            transform: translate(-50%,-50%);
            top: 48%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.1);
            box-shadow: 0 0 40px rgba(8,7,16,0.6);
            padding: 50px 35px;
        }
    </style>
    <script>
        "use strict";

        // Messages from the application

        window.chrome.webview.addEventListener('message', arg =>
		{
			// handle message
            if (arg.data.Action == undefined)
            {
                document.getElementById('actionMessage').innerHTML = arg.data;
            }
            else
            {
				// handle JSON
			    switch (arg.data.Action)
			    {
				    case '':
					    {
						    break;
					    }
			    }
            }
        });

        function QueForMatch()
		{
            var selectElement = document.getElementById('playerSelect');
            var selectedIndex = selectElement.selectedIndex;

            var xml = '<?xml version="1.0"?><result><modelSelect><model>';

            xml += selectElement.value;

            xml += '</model></modelSelect></result>';

			document.getElementById("output").textContent = xml;

            // send message to application
            window.chrome.webview.postMessage(xml);
        }
    </script>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
    </div>
    <form action="javascript:;" onsubmit="QueForMatch(this);">
        <select class="dropdown" id="playerSelect">
          <option value="Player">Player</option>
          <option value="Monkey">Monkey</option>
        </select>
    
        <button>QueForMatch</button>

        <p>Model:<span id="output"></span></p>
    </form>
</body>
</html>
