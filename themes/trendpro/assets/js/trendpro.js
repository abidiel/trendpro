/*
 * Este trecho de código garante que todos os vídeos inseridos pelo bloco
 * "Mídia e Texto" do WordPress tenham os atributos autoplay, loop, muted e playsinline.
 * Isso faz com que os vídeos sejam reproduzidos automaticamente, em loop,
 * sem som e compatíveis com dispositivos móveis.
 *
 * Observação: O atributo 'muted' é necessário para o autoplay funcionar na maioria dos navegadores.
 */
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.wp-block-media-text__media video').forEach(function(video) {
    video.setAttribute('autoplay', '');
    video.setAttribute('loop', '');
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');
    video.muted = true; // Garante que o muted seja aplicado
    video.play();
  });
});



/*
* Este código gerencia a troca dinâmica de vídeos do YouTube baseada no dispositivo.
* Para dispositivos mobile (largura até 768px), utiliza o link do campo 'link_youtube_vertical'
* se estiver preenchido. Para desktop ou quando não há vídeo vertical disponível,
* utiliza sempre o link do campo 'link_youtube' como fallback.
*
* A função é executada no carregamento da página e também quando a janela é redimensionada,
* garantindo que o vídeo correto seja exibido independente de mudanças de orientação
* ou redimensionamento da tela.
*/
document.addEventListener('DOMContentLoaded', function () {
  const videoLinks = document.querySelectorAll('.video-link');

  function updateVideoLinks() {
      videoLinks.forEach(function (videoLink) {
          const isMobile = window.innerWidth <= 768;
          const desktopUrl = videoLink.dataset.desktop;
          const mobileUrl = videoLink.dataset.mobile;

          const urlToUse = (isMobile && mobileUrl) ? mobileUrl : desktopUrl;
          videoLink.href = urlToUse;

          if (isMobile && mobileUrl) {
              videoLink.setAttribute('data-video-type', 'vertical');
          } else {
              videoLink.setAttribute('data-video-type', 'horizontal');
          }
      });
  }

  updateVideoLinks();
  window.addEventListener('resize', updateVideoLinks);
});




/*
 * Este código gerencia a troca dinâmica de vídeos do YouTube baseada no dispositivo
 * e ajusta a proporção do iframe no modal para vídeos verticais em mobile.
 */
function updateVideoLink() {
  const isMobile = window.innerWidth <= 768;
  const desktopUrl = videoLink.dataset.desktop;
  const mobileUrl = videoLink.dataset.mobile;
  
  const urlToUse = (isMobile && mobileUrl) ? mobileUrl : desktopUrl;
  videoLink.href = urlToUse;
  
  if (isMobile && mobileUrl) {
      videoLink.setAttribute('data-video-type', 'vertical');
  } else {
      videoLink.setAttribute('data-video-type', 'horizontal');
  }
}

// Ajusta proporção do iframe quando popup abre
document.addEventListener('click', function(e) {
  if (e.target.closest('.popup-youtube')) {
      setTimeout(function() {
          const scaler = document.querySelector('.mfp-iframe-scaler');
          if (scaler) {
              const isMobile = window.innerWidth <= 768;
              if (isMobile) {
                  scaler.classList.add('vertical');
              } else {
                  scaler.classList.remove('vertical');
              }
          }
      }, 500);
  }
});