<!DOCTYPE html>
<html>

<head>
<title>Movie</title>
<meta charset="UTF-8">
<style>
body
{
	background-color:black;
	font-family:Arial;
	font-size:16px;
}
table
{
	border-collapse: collapse;
	/*border:3px solid red;*/
}
.videoContainer
{
	vertical-align:top;
	width:800px;
	height:600px;
}
.video
{
	/*border:1px solid red;*/
	vertical-align:top;
}
.controls
{
	/*border:1px solid red;*/
	width:100%;
}
.timer
{
	color:white;
	text-align:center;
}
.slider
{
	width:630px;
}
/* Don't display default media controls during fullscreen */
::-webkit-media-controls
{
  display:none !important;
}
.list
{
	/*border:1px solid blue;*/
	vertical-align:top;
}
.list span
{
	background-color:gray;
	border-bottom:1px solid;
	display: block;
}
.list span:hover
{
	background-color:darkGoldenRod;
	border-bottom:1px solid;
	cursor:pointer;
}
.title
{
	color:white;
}
.title span
{
	/*display: block;*/
}
</style>
<script type="text/javascript">
var video = null;

class Video
{
    constructor(size, source)
	{
		document.getElementById('title').innerHTML = source;

		this.duration = document.getElementById('duration');

		// tbody is inserted even though not in the original html source
		this.controls = document.getElementById('controls').querySelectorAll('table > tbody > tr > td > img');

		this.playButton = null;
		this.stopButton = null;
		this.muteButton = null;

		for (var i = 0; i < this.controls.length; i++)
		{
			if (this.controls[i].id === 'play')
			{
				this.playButton = this.controls[i];

				this.playButton.src = 'images/play.svg';
			}
			if (this.controls[i].id === 'stop')
			{
				this.stopButton = this.controls[i];

                this.stopButton.src = 'images/stop.svg';
			}
			if (this.controls[i].id === 'mute')
			{
				this.muteButton = this.controls[i];

                this.muteButton.src = 'images/mute.svg';
			}
		}

		this.slider = document.getElementById('controls').querySelectorAll('table > tbody > tr > td > input');
		this.slider = this.slider[0];

		// need to make a reference to the parent object so the parent methods can be called from event handlers
		this.slider.parentContainer = this;
		this.slider.addEventListener('input', function ()
		{
			// calling parent class method
            this.parentContainer.UpdateSlider();
		});

		this.timer = document.getElementById('timer');

        this.isPlaying = false;

		this.video = document.getElementById('video');

		// another reference to the parent object
		this.video.parentContainer = this;

		if (size > 0)
        {
            this.video.width = size * 16;
            this.video.height = size * 9;

			var r = document.getElementById('range');
			var p = document.getElementById('play').width;

			r.style.width = this.video.width - document.getElementById('play').width - 65 -
						document.getElementById('stop').width -
						document.getElementById('mute').width -
						document.getElementById('timer').width -
						document.getElementById('fullscreen').width + "px";

			console.log(this.video.width);
			console.log(r.style.width);
        }

		var t = source.split('.');
        this.video.type = 'video/' + t[1];

        this.video.src = source;

        this.video.controls = false;
        this.video.disablePictureInPicture = true;
        this.video.preload = 'metadata';
        this.video.controlslist = 'nodownload';

        this.video.addEventListener('ended', function ()
        {
			this.isPlaying = false;

			this.parentContainer.playButton.src = 'images/play.svg';

			//self.close();
			//window.close();
        });

        this.video.addEventListener('loadedmetadata', function ()
        {
			this.parentContainer.UpdateTimer();
        });

        this.video.addEventListener('pause', function ()
        {
			this.isPlaying = false;
        });

        this.video.addEventListener('play', function ()
        {
			this.isPlaying = true;
        });

        this.video.addEventListener('playing', function ()
        {
			this.isPlaying = true;
        });

        this.video.addEventListener('seeking', function ()
        {
			this.pause();

			this.parentContainer.playButton.src = 'images/play.svg';
        });

        this.video.addEventListener('timeupdate', function ()
        {
			this.parentContainer.UpdateTimer();
        });
    }

	UpdateTimer()
    {
		this.timer.innerHTML = (this.video.duration - this.video.currentTime).toFixed(2);

		this.slider.value = (this.video.currentTime / this.video.duration).toFixed(2) * 100;

        this.duration.innerHTML = this.timer.innerHTML;
    }

    UpdateSlider()
	{
		this.video.currentTime = (this.video.duration * this.slider.value / 100);
    }

	TogglePlayingState()
	{
		if (this.video.isPlaying === true)
		{
			this.video.pause();

			this.video.isPlaying = false;

            this.playButton.src = 'images/play.svg';
		}
		else
		{
			this.video.play();

			this.video.isPlaying = true;

            this.playButton.src = 'images/pause.svg';
		}
	}

	Stop()
    {
		this.playButton.src = 'images/play.svg';

		this.slider.value = 0;

		this.video.pause();
		this.video.currentTime = 0;
	}

	ToggleMuteState()
	{
		if (this.video.muted === true)
		{
			this.video.muted = false;

			this.muteButton.src = 'images/mute.svg';
		}
		else
		{
			this.video.muted = true;

            this.muteButton.src = 'images/muted.svg';
		}
	}

	ToggleFullscreen()
	{
		this.video.requestFullscreen();
	}
}

function JavascriptInit()
{
	var videos = [
<?php
$images = glob("*.mp4");

$count = count($images);

for ($i=0;$i<count($images) - 1;$i++)
{
    printf("    \"" . $images[$i] . "\",\n");
}

printf("    \"" . $images[count($images) - 1] . "\"");
?>	
	];

	var list = document.getElementById("list");

	for (var i = 0; i < videos.length; i++)
	{
		var v = list.appendChild(document.createElement('span'));

		v.setAttribute("onclick", "SetVideoSourceName('" + videos[i] + "')");

		v.textContent = videos[i];
	}

    video = new Video(75, '');
}

function SetVideoSourceName(n)
{
	video = new Video(75, n);
}
</script>
</head>

<body onload="JavascriptInit()">


<table>
	<tr>
		<td class="videoContainer">
			<table>
				<tr>
					<td colspan="3" class="video">
						<video id="video" onclick="video.TogglePlayingState();"></video>
					</td>
				</tr>
				<tr>
					<td id="controls" class="controls">
						<table>
							<tr>
								<td>
									<img id="play" onclick="video.TogglePlayingState();" src="images/play.svg" width="25" height="25" />
								</td>
								<td>
									<img id="stop" onclick="video.Stop();" src="images/stop.svg" width="25" height="25" />
								</td>
								<td>
									<img id="mute" onclick="video.ToggleMuteState();" src="images/mute.svg" width="25" height="25" />
								</td>
								<td>
									<input id="range" class="slider" type="range" min="0" max="100" value="0">
								</td>
								<td class="timer" id="timer">
								</td>
								<td>
									<img id="fullscreen" onclick="video.ToggleFullscreen();" src="images/fullscreen.svg" width="25" height="25" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="title">
						<span id="title"></span>
						<span id="duration"></span>
					</td>
				</tr>
			</table>
		</td>

		<td id="list" class="list">
		</td>
	</tr>
</table>

</body>
</html>