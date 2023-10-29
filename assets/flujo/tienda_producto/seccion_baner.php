<!DOCTYPE html>
<html>
<head>
    <style>
.banner {
    width: 100%;
    top: 0;
    overflow: hidden;
            position: relative;
}

.banner img {
    width: 100%;
    display: block;
}

.banner img:nth-child(2) {
    display: none;
}

@keyframes bannerAnimation {
    0%, 100% {
        opacity: 1;
        z-index: 1;
    }
    25%, 100% {
        opacity: 0;
        z-index: 0;
    }
}


    </style>
</head>
<body>
    <div class="banner">
        <img src="../../img_prods/banner.png" alt="Banner 1">
        <img src="../../img_prods/banner.png" alt="Banner 2">
</div>
</body>
</html>
