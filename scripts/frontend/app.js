function load() {
    view("home");
    if (!cookie_has("sid")) {
        api("scripts/backend/check/check.php", "check", "give", {}, (success, result, error) => {
            if (success) {
                cookie_push("sid", result.seshID);
                cookie_push("prefix", result.shash);
                get("given").innerText = cookie_pull("prefix");
            }
        });
    }
    get("given").innerText = cookie_pull("prefix");
}

function send() {
    api("scripts/backend/check/check.php", "check", "check", {seshID: cookie_pull("sid"), result: get("in").value}, (success, result, error) => {
        if (success) {
            get("r").style.color = "green";
            cookie_push("sid", undefined);
            cookie_push("prefix", undefined);
        } else {
            get("r").style.color = "red";
        }
        view("results");
        get("r").innerText = (success) ? result : error;
    });
}


function cookie_pull(name) {
    name += "=";
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return decodeURIComponent(cookie.substring(name.length, cookie.length));
        }
    }
    return undefined;
}

function cookie_push(name, value) {
    const date = new Date();
    date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
    document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + date.toUTCString() + ";domain=" + window.location.hostname + ";path=/";
}

function cookie_has(name) {
    return cookie_pull(name) !== undefined;
}