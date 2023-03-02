<!doctype html>
<html lang="en">

<head>
    <title>Login 05</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script nonce="4e43bc18-0d88-4592-b387-1b03930606d0">
        (function(w, d) {
            ! function(f, g, h, i) {
                f[h] = f[h] || {};
                f[h].executed = [];
                f.zaraz = {
                    deferred: [],
                    listeners: []
                };
                f.zaraz.q = [];
                f.zaraz._f = function(j) {
                    return function() {
                        var k = Array.prototype.slice.call(arguments);
                        f.zaraz.q.push({
                            m: j,
                            a: k
                        })
                    }
                };
                for (const l of ["track", "set", "debug"]) f.zaraz[l] = f.zaraz._f(l);
                f.zaraz.init = () => {
                    var m = g.getElementsByTagName(i)[0],
                        n = g.createElement(i),
                        o = g.getElementsByTagName("title")[0];
                    o && (f[h].t = g.getElementsByTagName("title")[0].text);
                    f[h].x = Math.random();
                    f[h].w = f.screen.width;
                    f[h].h = f.screen.height;
                    f[h].j = f.innerHeight;
                    f[h].e = f.innerWidth;
                    f[h].l = f.location.href;
                    f[h].r = g.referrer;
                    f[h].k = f.screen.colorDepth;
                    f[h].n = g.characterSet;
                    f[h].o = (new Date).getTimezoneOffset();
                    if (f.dataLayer)
                        for (const s of Object.entries(Object.entries(dataLayer).reduce(((t, u) => ({
                                ...t[1],
                                ...u[1]
                            }))))) zaraz.set(s[0], s[1], {
                            scope: "page"
                        });
                    f[h].q = [];
                    for (; f.zaraz.q.length;) {
                        const v = f.zaraz.q.shift();
                        f[h].q.push(v)
                    }
                    n.defer = !0;
                    for (const w of [localStorage, sessionStorage]) Object.keys(w || {}).filter((y => y.startsWith("_zaraz_"))).forEach((x => {
                        try {
                            f[h]["z_" + x.slice(7)] = JSON.parse(w.getItem(x))
                        } catch {
                            f[h]["z_" + x.slice(7)] = w.getItem(x)
                        }
                    }));
                    n.referrerPolicy = "origin";
                    n.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(f[h])));
                    m.parentNode.insertBefore(n, m)
                };
                ["complete", "interactive"].includes(g.readyState) ? zaraz.init() : f.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, "zarazData", "script");
        })(window, document);
    </script>
</head>

<body>
    <section class="ftco-section">

    </section>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"7a19675c5e2b37e3","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.2.0","si":100}' crossorigin="anonymous"></script>
</body>

</html>