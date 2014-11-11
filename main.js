/**
 * Created by saithiril on 05.11.14.
 */
var utils;

utils = {
    xmlhttp: (function () {
        'use strict';
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } catch (ee) {
            }
        }
        if (typeof XMLHttpRequest !== 'undefined') {
            return new XMLHttpRequest();
        }
    }())
};

function like_photo(e, image_id) {
    var
        likes_count = document.getElementById('likes_count_'+image_id),
        xmlhttp = utils.xmlhttp;

    xmlhttp.open('GET', 'like_photo.php?id='+image_id, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4)
        {
            if(xmlhttp.status==0) {
            }
            if(xmlhttp.status == 200) {
                var response = xmlhttp.responseText;
                if(response != "NO")
                    likes_count.innerHTML = response;
            }
        }
    }
    xmlhttp.send();
}