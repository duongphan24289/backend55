<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>xxxx</title>

    <link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
</head>
<body>

{{--<video id="example_video_1" class="video-js vjs-default-skin vjs-big-play-centered"--}}
       {{--controls preload="auto" height="600" width="980">--}}

    {{--<source src="https://www.youtube.com/watch?v=wVdGo8dBmjw" />--}}
{{--</video>--}}

<OBJECT ID="SopPlayer" name = "SopPlayer"
        CLASSID=clsid:8FEFF364-6A5F-4966-A917-A3AC28411659
        CODEBASE="http://download.sopcast.cn/download/SOPCORE.CAB#version=2,0,4,0"
        HEIGHT=350 WIDTH=450>
    <param name="AutoStart" value="1">
    <param name="SopAddress" value="sop://broker.sopcast.com:3912/[color=#ff0000][/color][color=#ff0033]Channelnumber[/color]">
    <param name="ChannelName" value="[color=#cc0000][/color]Nameofchannel">
</OBJECT>


<script src="//vjs.zencdn.net/4.12/video.js"></script>

<script>
//    videojs(document.getElementById('example_video_1'), {}, function() {
//        // This is functionally the same as the previous example.
//    });
</script>
</body>
</html>