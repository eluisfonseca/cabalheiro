/**
 * Created by Lightstorm on 06/01/2016.
 */
function testUrlForMedia(pastedData) {
    /*pastedData="https://www.youtube.com/embed/vyJeZqVP6gQ?rel=0&hd=1";
    var success = false;
    var media   = {};
    if (pastedData.match('http://(www.)?youtube|youtu\.be')) {
        if (pastedData.match('embed')) { youtube_id = pastedData.split(/embed\//)[1].split('"')[0]; }
        else { youtube_id = pastedData.split(/v\/|v=|youtu\.be\//)[1].split(/[?&]/)[0]; }
        media.type  = "youtube";
        media.id    = youtube_id;
        success = true;
    }
    else if (pastedData.match('http://(player.)?vimeo\.com')) {
        vimeo_id = pastedData.split(/video\/|http:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
        media.type  = "vimeo";
        media.id    = vimeo_id;
        success = true;
    }
    else if (pastedData.match('http://player\.soundcloud\.com')) {
        soundcloud_url = unescape(pastedData.split(/value="/)[1].split(/["]/)[0]);
        soundcloud_id = soundcloud_url.split(/tracks\//)[1].split(/[&"]/)[0];
        media.type  = "soundcloud";
        media.id    = soundcloud_id;
        success = true;
    }
    if (success) { alert(media.id);return media; }
    else { alert("No valid media id detected"); }
    return false;*/

    var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = pastedData.match(regExp);
    if (match && match[2].length == 11) {
        alert(match[2]);
    } else {
        alert("No valid media id detected");
    }
}