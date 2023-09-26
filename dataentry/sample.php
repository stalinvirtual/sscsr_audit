<!DOCTYPE html>
<html>
<head>
    <title>jQuery Progress Bar Example</title>
    <style>
body {
    font-family: Arial, sans-serif;
    text-align: center;
    margin-top: 100px;
}

.progress-container {
    width: 300px;
    height: 20px;
    border: 1px solid #ccc;
    margin: 0 auto;
    overflow: hidden;
}

.progress-bar {
    width: 0;
    height: 100%;
    background-color: #4CAF50;
}


    </style>
</head>
<body>
    <div class="progress-container">
        <div class="progress-bar" id="my-progress-bar"></div>
    </div>
    <button id="start-button">Start Progress</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    // Click event for the start button
    $('#start-button').click(function() {
        startProgress();
    });

    function startProgress() {
        var progressBar = $('#my-progress-bar');
        var width = 0;
        var interval = setInterval(function() {
            if (width >= 100) {
                clearInterval(interval);
            } else {
                width += 1;
                progressBar.css('width', width + '%');
            }
        }, 50);
    }
});

    </script>
</body>
</html>
