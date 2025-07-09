/* ===================================
 Dynamic Video Loader
 ====================================== */


 document.addEventListener("DOMContentLoaded", function () {
  function loadVideo() {
      const isMobile = window.innerWidth <= 768;

      // Usando os dados passados por wp_localize_script
      const videoSrc = isMobile ? bannerData.video_mobile : bannerData.video_desktop;
      const posterSrc = isMobile ? bannerData.poster_mobile : bannerData.poster_desktop;

      const videoElement = document.getElementById("dynamic-video");
      const sourceElement = document.getElementById("video-source");

      if (videoElement && sourceElement) {
          if (sourceElement.getAttribute("src") !== videoSrc) {
              sourceElement.setAttribute("src", videoSrc);
              videoElement.setAttribute("poster", posterSrc);
              videoElement.load(); // Recarrega o vídeo com a nova fonte e poster
          }
      }
  }

  loadVideo();
  window.addEventListener("resize", loadVideo);
});