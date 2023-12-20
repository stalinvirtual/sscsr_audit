<!-- footer -->
<div class="footer">
  <i class="fa fa-object-group nav-icon" id="btnFullscreen" aria-hidden="true" title="full screen"></i>
  <p>©
    <?php echo date("Y"); ?> <a href="#">NIC</a> . All Rights Reserved .
  </p>
</div>
<!-- //footer -->
<script src="js/bootstrap.js"></script>
<script src="js/proton.js"></script>
<script src="js/jquery.validate.min.js"
  crossorigin="anonymous"></script>
<script type="text/javascript">
  endTime = 0;
  countdown("ten-countdown", 1, 20);
  function countdown(elementName, minutes, seconds) {
    var element, hours, mins, msLeft, time;
    function twoDigits(n) {
      return (n <= 9 ? "0" + n : n);
    }
    function updateTimer() {
      //debugger;
      msLeft = endTime - (+new Date);
      if (msLeft < 3600) {
        // // logout();
       Swal.fire({
        title: 'Your session is about to expire. Do you want to stay logged in?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
      }).then((result) => {
        if (result.value) {
          window.location.href = 'add_exam.php';
        } else {
          window.location.href = 'logout.php';
        }
      });
        // Set an additional timeout to log out if the user doesn't interact with Swal
      setTimeout(function() {
        window.location.href = "logout.php";
      }, 30000); // This timeout is set to 30 seconds (adjust as needed)
      } else {
        time = new Date(msLeft);
        hours = time.getUTCHours();
        mins = time.getUTCMinutes();
        element.innerHTML = 'Session Time: ' + (hours ? hours + ':' + twoDigits(mins) : mins) + ':' + twoDigits(time.getUTCSeconds());
        setTimeout(updateTimer, time.getUTCMilliseconds() + 500);
      }
    }
    //debugger;
    element = document.getElementById('so');
    //endTime = (+new Date) + 3600 * (60 * minutes + seconds) + 500;
    endTime = (+new Date) + (30 * 60 * 1000);
    updateTimer();
  }
  // window.addEventListener('mousemove', e => endTime = (+new Date) + 3600 * (60 * 1 + 20) + 500)
  window.addEventListener('mousemove', e => {
    endTime = (+new Date) + (30 * 60 * 1000);
  });
</script>
<script type="text/javascript">
  function toggleFullscreen(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
      !document.webkitFullscreenElement && !document.msFullscreenElement) {
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
      } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
    }
  }
  document.getElementById('btnFullscreen').addEventListener('click', function () {
    toggleFullscreen();
  });
</script>
</body>
</html>