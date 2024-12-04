<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="resources/favicon.png" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap" rel="stylesheet">
  <style>
    body {
      background-image: url('resources/home.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .get-started-btn {
      @apply inline-block bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 text-white text-3xl font-mono rounded-full px-8 py-4 mt-52 relative overflow-hidden shadow-lg transform transition-all duration-300 hover:scale-105;
      position: relative;
      z-index: 10;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .circle-images {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      justify-content: center;
      align-items: center;
      width: 150px;
      height: 150px;
      pointer-events: none;
    }

    .circle-images img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: full;
      opacity: 0;
      transform: translate(0, 0);
      transition: opacity 0.3s ease, transform 0.3s ease;
      position: absolute;
    }

    .get-started-btn:hover .circle-images img:nth-child(1) {
      opacity: 1;
      transform: translate(90px, -90px);
    }

    .get-started-btn:hover .circle-images img:nth-child(2) {
      opacity: 1;
      transform: translate(-90px, -90px);
    }

    .get-started-btn:hover .circle-images img:nth-child(3) {
      opacity: 1;
      transform: translate(90px, 90px);
    }

    .get-started-btn:hover .circle-images img:nth-child(4) {
      opacity: 1;
      transform: translate(-90px, 90px);
    }
  </style>
  <title>ZeithZone</title>
</head>

<body class="flex justify-center items-center min-h-screen text-white font-sans">
  <div class="flex flex-col items-center">
    <div class="text-center fixed top-0 pt-12">
      <h1 class="text-4xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 animate-pulse">
        Welcome to ZenithZone Art Gallery
      </h1>

    </div>

    <a href="./art_show_page.php" class="get-started-btn group btn btn-active btn-secondary">
      Get Started
      <div class="circle-images">
        <img src="resources/pic1.png" alt="Pic 1" />
        <img src="resources/pic2.png" alt="Pic 2" />
        <img src="resources/pic3.png" alt="Pic 3" />
        <img src="resources/pic4.png" alt="Pic 4" />
      </div>
    </a>
  </div>
</body>

</html>